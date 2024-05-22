<?php

include_once '../helpers/Database.php';

class HallImage {

    private $hallImageId;
    private $hallImagePath;
    private $hall_id;

    public function __construct() {
        $this->hallImageId = null;
        $this->hallImagePath = null;
        $this->hall_id = null;
    }

    public function initWith($hallImageId, $hallImagePath, $hall_id) {
        $this->hallImageId = $hallImageId;
        $this->hallImagePath = $hallImagePath;
        $this->hall_id = $hall_id;
    }

    function initWithImageId($hallImageId) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Hall_Image WHERE hall_image_id = ' . $hallImageId);
        $this->initWith($data->hall_image_id, $data->hall_image_path, $data->hall_id);
    }

    
    function getAllImagesForHall($hallId) {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM dbProj_Hall_Image WHERE hall_id = " . $hallId);
        return $data;
    }

    function addHallImage() {
        $db = new Database();

        $this->hallImagePath = $db->sanitizeString($this->hallImagePath);
        $this->hall_id = $db->sanitizeString($this->hall_id);

        $q = "INSERT INTO dbProj_Hall_Image(hall_image_path,hall_id) VALUES(?,?)";

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if ($stmt) {
            $stmt->bind_param('si', $this->hallImagePath, $this->hall_id);
            if (!$stmt->execute()) {
                var_dump($stmt);
                echo 'Execute failed';
                $db->displayError($q);
                return false;
            }
        } else {
            $db->displayError($q);
            return false;
        }
        return true;
    }

    public function deleteImage() {
        $db = new Database();

        $this->hallImagePath = $db->sanitizeString($this->hallImagePath);
        $q = "Delete from dbProj_Hall_Image where hall_image_path = ?";

        $stmt = mysqli_prepare($db->getDatabase(), $q);

        if ($stmt) {
            $stmt->bind_param('s', $this->hallImagePath);
            if (!$stmt->execute()) {
                var_dump($stmt);
                echo 'Execute failed';
                $db->displayError($q);
                return false;
            }
        } else {
            $db->displayError($q);
            return false;
        }
        unlink($this->$hallImagePath);
        echo 'image deleted;';
        return true;
    }

    public function getHallImageId() {
        return $this->hallImageId;
    }

    public function getHallImagePath() {
        return $this->hallImagePath;
    }

    public function getHall_id() {
        return $this->hall_id;
    }

    public function setHallImageId($hallImageId) {
        $this->hallImageId = $hallImageId;
    }

    public function setHallImagePath($hallImagePath) {
        $this->hallImagePath = $hallImagePath;
    }

    public function setHall_id($hall_id) {
        $this->hall_id = $hall_id;
    }
}
