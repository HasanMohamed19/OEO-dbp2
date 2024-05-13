<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of HallImage
 *
 * @author Hassan
 */
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
    
    function getAllImagesForHall($hallImageId) {
        $db = Database::getInstance();
        $data = $db->multiFetch("SELECT * FROM dbProj_Hall_Image WHERE hall_image_id = " . $hallImageId);
        return $data;
    }
    
    public function deleteImage() {
        try {
            $db = Database::getInstance();
            $deleteQry = $db->querySQL("Delete from dbProj_Hall_Image where hall_image_id = " . $this->hallImageId);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
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
