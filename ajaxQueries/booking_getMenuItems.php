<?php
include '../models/MenuItem.php';
$serviceId = $_GET['serviceId'];
$pageNum = $_GET['pageNum'];
$count = $_GET['count'];
$items = MenuItem::getItemPage($serviceId, $pageNum, $count);

echo json_encode($items);
