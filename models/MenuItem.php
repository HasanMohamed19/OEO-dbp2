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
// if required this can be changed to class as before
//enum CateringService: int {
//    case Breakfast = 1;
//    case Lunch = 2;
//    case HotBeverages = 3;
//    case ColdBeverages = 4;
//}

const MENU_BREAKFAST = 1;
const MENU_LUNCH = 2;
const MENU_HOT_BEVERAGES = 3;
const MENU_COLD_BEVERAGES = 4;

class MenuItem {

    private $itemId;
    private $name;
    private $description;
    private $price;
    private $imagePath;
    // service_id
    private $cateringServiceId;

    public function initWith($itemId, $name, $description, $price, $imagePath, $cateringServiceId) {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imagePath = $imagePath;
        $this->cateringServiceId = $cateringServiceId;
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
        $this->cateringServiceId = null;
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

    public function setCateringService($cateringServiceId) {
        $this->cateringServiceId = $cateringServiceId;
    }

    function getAllMenuItems() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from dbProj_Menu_Item');
        return $data;
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
