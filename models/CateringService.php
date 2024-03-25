<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CateringService
 *
 * @author Hassan
 */
class CateringService {
    
    private $serviceId;
    private $name;
    private $description;
    private array $items;
    
    public function getServiceId() {
        return $this->serviceId;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function getItems() {
        return $this->items;
    }

    public function setServiceId($serviceId) {
        $this->serviceId = $serviceId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function setItem($items) {
        $this->items = $items;
    }
    
}
