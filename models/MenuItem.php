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
include '../helpers/Database.php';
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
        $db = new Database();
        if ($this->isValid()) {
            $this->name = $db->sanitizeString($this->name);
            $this->description = $db->sanitizeString($this->description);
            $this->price = $db->sanitizeString($this->price);
            $this->imagePath = $db->sanitizeString($this->imagePath);
            $this->cateringServiceId = $db->sanitizeString($this->cateringServiceId);
            $this->ItemStatus = $db->sanitizeString($this->ItemStatus);

            $q = "INSERT INTO dbProj_Menu_Item(name,description,price,image_path,service_id,service_status_id) VALUES(?,?,?,?,?,?)";

            $stmt = mysqli_prepare($db->getDatabase(), $q);

            if ($stmt) {
                $stmt->bind_param('ssdsii', $this->name, $this->description, $this->price, $this->imagePath, $this->cateringServiceId, $this->ItemStatus);
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

            $q = "UPDATE dbProj_Menu_Item set name = ? ,description = ?  ,price = ? ,image_path = ? ,service_id = ?, item_status_id = ? WHERE item_id = ? ";

            $stmt = mysqli_prepare($db->getDatabase(), $q);

            if ($stmt) {
                $stmt->bind_param('ssdsiii', $this->name, $this->description, $this->price, $this->imagePath, $this->cateringServiceId, $this->ItemStatus, $this->itemId);
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
        } else {
            echo'invalid values :(';
        }
    }

    function getItemStatusName() {
        $db = Database::getInstance();
        $data = $db->singleFetch("SELECT status_name FROM dbProj_Availability_Status a JOIN dbProj_Menu_Item m ON m.item_status_id = a.availability_status_id WHERE m.item_id = '$this->itemId'");
//       var_dump($data);
        return $data;
    }

    public function isValid() {
        $errors = array();

        if (empty($this->name))
            $errors[] = 'You must enter a Name';

        if (empty($this->price))
            $errors[] = 'You must enter a price';

        if (empty($this->imagePath)) {
            echo'no image';
            $errors[] = 'You must add an Image Path';
        }
        if (empty($this->ItemStatus))
            $errors[] = 'You must enter a status';

        if (empty($this->cateringServiceId)) {
            echo'no service';
            $errors[] = 'You must add a catering service type';
        }
        if (empty($errors))
            return true;
        else
            return false;
    }
}
