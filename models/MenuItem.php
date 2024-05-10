<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MenuItem
 *
 * @author Hassan
 */
include '../helpers/Database.php';

// if required this can be changed to class as before
//Catering Services
const Breakfast = 1;
const Lunch = 2;
const HotBeverages = 3;
const ColdBeverages = 4;

class MenuItem {

    private $itemId;
    private $name;
    private $description;
    private $price;
    private $imagePath;
    private $service_id;

    public function initWith($itemId, $name, $description, $price, $imagePath, $service_id) {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imagePath = $imagePath;
        $this->service_id = $service_id;
    }

    public function initWithMenuItemid($id) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM dbProj_Menu_Item WHERE item_id = ' . $id);
        $this->initWith($data->item_id, $data->name, $data->description, $data->price, $data->image_path, $data->service_id);
    }

    public function __construct() {
        $this->itemId = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->imagePath = null;
        $this->service_id = null;
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

    public function getCateringService() {
        return $this->service_id;
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

    public function setCateringService($service_id) {
        $this->service_id = $service_id;
    }

    function getAllMenuItems() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from dbProj_Menu_Item');
        return $data;
    }

    function addMenuItem() {
        try {
            $db = Database::getInstance();
            $insertQry = "INSERT INTO dbProj_Menu_Item(item_id,name,description,price,image_path,service_id) VALUES( NULL,'$this->name','$this->description', '$this->price','$this->imagePath','$this->service_id')";
            if (!($db->querySQL($insertQry))) {
                echo'insert failed  :(';
                return false;
            }
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    function deleteMenuItem() {
        try {
            $db = Database::getInstance();
            $deleteQry = $db->querySQL("Delete from dbProj_Menu_Item where item_id=" . $this->itemId);
//            unlink($this->imagePath);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    function updateMenuItem() {
        try {
            $db = Database::getInstance();

            if (is_null($this->imagePath) || $this->imagePath == '') {
                $this->imagePath = $db->singleFetch('Select image_path from dbProj_Menu_Item where item_id =' . $this->itemId)->image_path;
            }
            $data = 'UPDATE dbProj_Menu_Item set
			name = \'' . $this->name . '\'  ,
                        description = \'' . $this->description . '\' ,
                        price = \'' . $this->price . '\' ,
                        image_path = \'' . $this->imagePath . '\',
                        service_id = \'' . $this->service_id . '\'
                            WHERE item_id = ' . $this->itemId;

            $db->querySQL($data);
            return true;
        } catch (Exception $e) {

            echo 'Exception: ' . $e;
            return false;
        }
    }

    public function isValid() {
        $errors = array();

        if (empty($this->name))
            $errors[] = 'You must enter a Name';

        if (empty($this->price))
            $errors[] = 'You must enter a price';

        if (empty($this->imagePath))
            $errors = 'You must add an Image Path';

        if (empty($this->service_id))
            $errors[] = 'You must add a catering service type';

        if (empty($errors))
            return true;
        else
            return false;
    }
}
