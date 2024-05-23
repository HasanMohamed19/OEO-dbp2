<?php

include_once '../helpers/Database.php';

const MENU_BREAKFAST = 1;
const MENU_LUNCH = 2;
const MENU_HOT_BEVERAGES = 3;
const MENU_COLD_BEVERAGES = 4;

const AVAILABLE_STATUS = 1;
const CANCELLED_STATUS = 2;

class MenuItem {

    private $itemId;
    private $name;
    private $description;
    private $price;
    private $imagePath;
    // service_id
    private $cateringServiceId;
    private $ItemStatus;

    public function initWith($itemId, $name, $description, $price, $imagePath, $cateringServiceId, $ItemStatus) {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imagePath = $imagePath;
        $this->cateringServiceId = $cateringServiceId;
        $this->ItemStatus = $ItemStatus;
    }

    public function initWithMenuItemid($id) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Menu_Item WHERE item_id = ' . $id);
        $this->initWith($data->item_id, $data->name, $data->description, $data->price, $data->image_path, $data->service_id, $data->item_status_id);
    }

    public function __construct() {
        $this->itemId = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->imagePath = null;
        $this->cateringServiceId = null;
        $this->ItemStatus = null;
    }


    public static function getAllItems() {
        $db = Database::getInstance();
        $q = 'SELECT * FROM dbProj_Menu_Item;';
        $data = $db->multiFetch($q);
        return $data;
    }

    public static function getItemPage($serviceId, $pageNum, $count) {
        $pageNum -= 1;
        $db = Database::getInstance();
        $q = 'SELECT SQL_CALC_FOUND_ROWS * FROM dbProj_Menu_Item WHERE service_id = '.$serviceId
                . ' AND item_status_id = '.AVAILABLE_STATUS.' LIMIT '.($pageNum*$count).','.$count;
        $data = $db->multiFetch($q);
        return $data;
    }
    
    public static function getItemCount($serviceId) {
        $db = Database::getInstance();
        $q = 'SELECT COUNT(*) AS total FROM dbProj_Menu_Item WHERE service_id = '.$serviceId.' AND item_status_id = ' . AVAILABLE_STATUS;
        $data = $db->singleFetch($q);
        return $data->total;
    }
    


    public function getItemId() {
        return $this->itemId;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    public function getCateringServiceId() {
        return $this->cateringServiceId;
    }

    public function getItemStatus() {
        return $this->ItemStatus;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setImagePath($imagePath) {
        $this->imagePath = $imagePath;
    }

    public function setItemStaus($ItemStatus) {
        $this->ItemStatus = $ItemStatus;
    }

    public function setCateringService($cateringServiceId) {
        $this->cateringServiceId = $cateringServiceId;
    }

    function getAllMenuItems($start, $end, $filter) {
        $db = Database::getInstance();
           $start = $start * $end - $end; 
        
        
        $q = 'Select * from dbProj_Menu_Item ';
            if ($filter=='ava') {
                $q .= 'WHERE item_status_id = ' .AVAILABLE_STATUS;
            }
            else if ($filter=='cncl') {
                $q .= 'WHERE item_status_id = ' .CANCELLED_STATUS; 
            }
        if (isset($start))
            $q .= ' limit ' . $start . ',' . $end;
        $data = $db->multiFetch($q);
        return $data;
    }

    
    
    public static function countAllItems() {
        $db = Database::getInstance();
        $q = "Select * from dbProj_Menu_Item";
        $dataCount = $db->getRows($q);
        return $dataCount;
    }

    public static function countAvailableItems() {
        $db = Database::getInstance();
        $q = "Select * from dbProj_Menu_Item WHERE item_status_id = " . AVAILABLE_STATUS;;
        $dataCount = $db->getRows($q);
        return $dataCount;
    }

    public static function countCancelledItems() {
        $db = Database::getInstance();
        $q = "Select * from dbProj_Menu_Item WHERE item_status_id = " . CANCELLED_STATUS;
        $dataCount = $db->getRows($q);
        return $dataCount;
    }

    public function getCateringSerivceName() {
        switch ($this->cateringServiceId) {
            case 1:
                return "Breakfast";
                break;
            case 2:
                return "Lunch";
                break;
            case 3:
                return "Hot Beverages";
                break;
            case 4:
                return "Cold Beverages";
                break;
        }
    }

    function addMenuItem() {
        $db = new Database();
        if ($this->isValid()) {
            $this->name = $db->sanitizeString($this->name);
            $this->description = $db->sanitizeString($this->description);
            $this->price = $db->sanitizeString($this->price);
            $this->imagePath = $db->sanitizeString($this->imagePath);
            $this->cateringServiceId = $db->sanitizeString($this->cateringServiceId);
            $this->ItemStatus = $db->sanitizeString($this->ItemStatus);

            $q = "INSERT INTO dbProj_Menu_Item(name,description,price,image_path,service_id,item_status_id) VALUES(?,?,?,?,?,?)";

            $stmt = mysqli_prepare($db->getDatabase(), $q);

            if ($stmt) {
                $stmt->bind_param('ssdsii', $this->name, $this->description, $this->price, $this->imagePath, $this->cateringServiceId, $this->ItemStatus);
                if (!$stmt->execute()) {
                    ($stmt);
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                }
            } else {
                $db->displayError($q);
                return false;
            }
            return true;
        } else {
            echo'invalid inputs';
        }
    }

    function deleteMenuItem() {
        $db = new Database();
        $this->itemId = $db->sanitizeString($this->itemId);
        $q = "Delete from dbProj_Menu_Item where item_id=?";
        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if ($stmt) {
            $stmt->bind_param('i', $this->itemId);
            if (!$stmt->execute()) {
                ($stmt);
                echo 'Execute failed';
                $db->displayError($q);
                return false;
            }
        } else {
            $db->displayError($q);
            return false;
        }
        unlink($this->imagePath);
        return true;
    }

    function updateMenuItem() {
        $db = new Database();
        if ($this->isValid()) {
            $this->itemId = $db->sanitizeString($this->itemId);
            $this->name = $db->sanitizeString($this->name);
            $this->description = $db->sanitizeString($this->description);
            $this->price = $db->sanitizeString($this->price);
            $this->imagePath = $db->sanitizeString($this->imagePath);
            $this->cateringServiceId = $db->sanitizeString($this->cateringServiceId);
            $this->ItemStatus = $db->sanitizeString($this->ItemStatus);
            
            //check if image has been updated, if true delete the image from the server
            $oldImg = $db->singleFetch("SELECT image_path FROM dbProj_Menu_Item WHERE item_id = '" . $this->itemId."'")->image_path;
            if ($oldImg!=$this->imagePath){
                unlink($oldImg);
            }
            $q = "UPDATE dbProj_Menu_Item set name = ? ,description = ?  ,price = ? ,image_path = ? ,service_id = ?, item_status_id = ? WHERE item_id = ? ";

            $stmt = mysqli_prepare($db->getDatabase(), $q);

            if ($stmt) {
                $stmt->bind_param('ssdsiii', $this->name, $this->description, $this->price, $this->imagePath, $this->cateringServiceId, $this->ItemStatus, $this->itemId);
                if (!$stmt->execute()) {
                    ($stmt);
                    echo 'Execute failed';
                    $db->displayError($q);
                    return false;
                }
            } else {
                $db->displayError($q);
                return false;
            }
            return true;
        } else {
            echo'invalid values :(';
        }
    }

    function getItemStatusName() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT status_name FROM dbProj_Availability_Status a JOIN dbProj_Menu_Item m ON m.item_status_id = a.availability_status_id WHERE m.item_id = '$this->itemId'");
//       ($data);
        return $data;
    }

    public function isValid() {
        $errors = array();

        if (empty($this->name))
            $errors[] = 'You must enter a Name';

        if (empty($this->price))
            $errors[] = 'You must enter a price';

        if (empty($this->imagePath)) {
//            echo'no image';
            $errors[] = 'You must add an Image Path';
        }
        if (empty($this->ItemStatus))
            $errors[] = 'You must enter a status';

        if (empty($this->cateringServiceId)) {
//            echo'no service';
            $errors[] = 'You must add a catering service type';
        }
        if (empty($errors))
            return true;
        else
            return false;
    }
    
    // added manually
    public function initMenuItemWithId() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Menu_Item WHERE item_id = ' . $this->itemId);
        $this->initWith($data->item_id, $data->name, $data->description, $data->price, $data->image_path, $data->service_id, $data->item_status_id);
    }
}
