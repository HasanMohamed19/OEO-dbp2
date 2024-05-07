<?php
include '../models/MenuItem.php';
$items = MenuItem::getAllItems();

echo json_encode($items);
