<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Employee
 *
 * @author Hassan
 */
class Employee extends User {
    
    private $employeeId;
    private $firstName;
    private $lastName;
    private $department;
    
    public function getEmployeeId() {
        return $this->employeeId;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getDepartment() {
        return $this->department;
    }

    public function setEmployeeId($employeeId) {
        $this->employeeId = $employeeId;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setDepartment($department) {
        $this->department = $department;
    }


    
}
