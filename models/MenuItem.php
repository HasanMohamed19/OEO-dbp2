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
}

}
