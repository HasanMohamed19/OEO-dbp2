<?php

include_once '../helpers/Database.php';
include_once 'Hall.php';

class Event {

    private $eventId;
    private $name;
    private $startDate;
    private $endDate;
    private $startTime;
    private $endTime;
    private $audienceNumber;

    public function __construct() {
        $this->eventId = null;
        $this->name = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->startTime = null;
        $this->endTime = null;
        $this->audienceNumber = null;
    }

    public function initWith($eventId, $name, $startDate, $endDate, $startTime, $endTime, $audienceNumber) {
        $this->eventId = $eventId;
        $this->name = $name;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->audienceNumber = $audienceNumber;
    }
    
    public function addEvent($hallId) {
        if ($this->isValid($hallId) > 1) {
            try {
                $db = Database::getInstance();
                $q = 'INSERT INTO `dbProj_Event`(`event_id`, `event_name`, `start_date`, `end_date`, `start_time`, `end_time`, `audience_number`)
                 VALUES (NULL, \'' . $this->name . '\',\'' . $this->startDate . '\',\'' . $this->endDate . '\',\'' . $this->startTime . '\',\''. $this->endTime.'\','.$this->audienceNumber.')';
                $data = $db->querySql($q);
                ($q);
                $this->eventId = mysqli_insert_id($db->dblink);
                return true;
            } catch (Exception $e) {
                echo 'Exception: ' . $e;
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function isValid($hallId) {

        if (empty($this->name))
            return 'Please enter a name for your event.';
        
        if (strlen($this->name) <= 3)
            return 'Event name must be more than three characters long.';
        
        if (empty($this->startDate))
            return 'Please enter the date your event starts.';
        
        if (empty($this->endDate))
            return 'Please enter the date your event ends.';
        
        if ($this->endDate < $this->startDate)
            return 'Your event cannot end before it starts. Please enter a valid date range.';
        
        if ($this->startDate <= date('Y-m-d')) 
            return 'Your event cannot take place today or earlier.';
        
        // check if hall is already booked
        if (!$this->isHallAvailable($hallId, $isEditing))
            return 'There is a hall already booked at the selected date. Please enter a different date.';
        
        if (empty($this->startTime))
            return 'Please enter the time your event starts.';

        if (empty($this->endTime))
            return 'Please enter the time your event ends.';
        
        if ($this->endTime <= $this->startTime && $this->startDate === $this->endDate)
            return 'The event must be at least 1 day longer.';
        
        $dtEndTime = new DateTime($this->endTime);
        $dtStartTime = new DateTime($this->startTime);
        $timeDiff = $dtEndTime->diff($dtStartTime);
        
        if ($timeDiff->h < 1)
            return 'The event must be at least 1 hour long.';
        
        if (empty($this->audienceNumber) || $this->audienceNumber <= 0)
            return 'Please enter a valid audience number.';

        // check if audience number exceeds hall capacity
        if (!$this->checkHallCapacity($hallId))
            return 'The selected hall is too small to fit your expected audience number. Please choose a bigger hall.';
        
        // returns 1 if all checks passed, error message otherwise
        return 1;
    }
    
    public function isHallAvailable($hallId) {
        // checks current start_date and end_date with hall to 
        // see if it is available at that time
        $db = Database::getInstance();
        $hallIdSanitized = $db->sanitizeString($hallId);
        $q = "SELECT e.start_date, e.end_date, e.event_id "
                . "FROM dbProj_Hall h "
                . "JOIN dbProj_Reservation r ON h.hall_id = r.hall_id "
                . "JOIN dbProj_Event e ON r.event_id = e.event_id "
                . "WHERE h.hall_id = ? "
                . "AND r.reservation_status_id IN (3,4)";
        
        $stmt = mysqli_prepare($db->getDatabase(),$q);
        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
//      ($stmt);
        $stmt->bind_param('s', $hallIdSanitized);
        if (!$stmt->execute()) {
            $db->displayError($q);
            return false;
        }
        $result = $stmt->get_result();
        $valid = true;
        while ($row = $result->fetch_assoc()) {
            $startDate = $row['start_date'];
            $endDate = $row['end_date'];
            $eventId = $row['event_id'];
            
            // ignore event if it is the same as this one
            if ($eventId == $this->eventId) continue;
            
            // if current startdate or enddate are in the checked reservation's
            // date range, its invalid
            
            if ($this->startDate >= $startDate && $this->startDate <= $endDate) {
                $valid = false;
            }
            if ($this->endDate >= $startDate && $this->endDate <= $endDate) {
                $valid = false;
            }
            // if the checked reservation's startdate is in the current date 
            // range, also invalid
            if ($startDate >= $this->startDate && $startDate <= $this->endDate) {
                $valid = false;
            }
        }
        return $valid;
    }
    
    public function checkHallCapacity($hallId) {
        $capacity = Hall::queryHallCapacity($hallId);
         return ($this->audienceNumber <= $capacity);
    }
    public function initWithEventId($eventId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Event WHERE event_id = ' . $eventId);
        $this->initWith($data->event_id, $data->event_name, $data->start_date, $data->end_date, $data->start_time, $data->end_time, $data->audience_number);
    }
    
    public static function getEventsForHall($hallId) {
        $db = new Database();
        $hallId = $db->sanitizeString($hallId);
        $q = "SELECT * "
                . "FROM dbProj_Event e "
                . "JOIN dbProj_Reservation r ON e.event_id = r.event_id "
                . "WHERE r.hall_id = ?";

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        $stmt->bind_param('i', $hallId);
        if (!$stmt->execute()) {
//                ($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        $result = $stmt->get_result();             
//        ($result);
        $data = $result->fetch_all(MYSQLI_ASSOC);
//        ($data);
        //returns results as array
        return $data;
    }
    
    public static function getEventsForHallSorted($hallId, $sortType, $startDate) {
        $db = new Database();
        $hallId = $db->sanitizeString($hallId);
        
        if ($sortType == 'asc') {
            $q = "SELECT * "
                    . "FROM dbProj_Event e "
                    . "JOIN dbProj_Reservation r ON e.event_id = r.event_id "
                    . "WHERE r.hall_id = ? "
                    . "AND e.end_date >= ? "
                    . "ORDER BY e.end_date ASC";
        } else {
//            echo "sorting desc";
            $q = "SELECT * "
                    . "FROM dbProj_Event e "
                    . "JOIN dbProj_Reservation r ON e.event_id = r.event_id "
                    . "WHERE r.hall_id = ? "
                    . "AND e.start_date <= ? "
                    . "ORDER BY e.start_date DESC";
        }

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if (!$stmt) {
            $db->displayError($q);
            return false;
        }
        // $startDate is used to filter events before/after this date
        $stmt->bind_param('is', $hallId, $startDate);
        if (!$stmt->execute()) {
//                ($stmt);
            echo 'Execute failed';
            $db->displayError($q);
            return false;
        }
        $result = $stmt->get_result();             
//        ($result);
        $data = $result->fetch_all(MYSQLI_ASSOC);
//        ($data);
        //returns results as array
        return $data;
    }

    public function getEventId() {
        return $this->eventId;
    }

    public function getName() {
        return $this->name;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function getAudienceNumber() {
        return $this->audienceNumber;
    }

    public function setEventId($eventId) {
        $this->eventId = $eventId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }

    public function setEndTime($endTime) {
        $this->endTime = $endTime;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function setAudienceNumber($audienceNumber) {
        $this->audienceNumber = $audienceNumber;
    }

    public function checkDaysDifference($eventId, $startDate) {
//        include '../debugging.php';
        $db = new Database();
        $q = "SELECT DATEDIFF(?, NOW()) AS dayDiff FROM dbProj_Event WHERE event_id = ?";

        $this->startDate = $db->sanitizeString($startDate);
        $this->eventId = $db->sanitizeString($eventId);

        $stmt = mysqli_prepare($db->getDatabase(), $q);
        if ($stmt) {
            $stmt->bind_param('si', $this->startDate, $this->eventId);

            if (!$stmt->execute()) {
//                ($stmt);
                echo 'Execute Failed';
                $db->displayError($q);
//                    return false;
            } else {
                $result = $stmt->get_result();
                $data = $result->fetch_array(MYSQLI_ASSOC);
//                ($data);
                return $data["dayDiff"];
            }
        } else {
            echo 'Execute Failed';
            $db->displayError($q);
        }
    }

}
