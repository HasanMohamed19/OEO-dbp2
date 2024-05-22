<?php
include '../models/MenuItem.php';

$serviceId = $_GET['serviceId'];
$menuItemCount = MenuItem::getItemCount($serviceId);

echo $menuItemCount;