<?php
require_once __DIR__ . '/controls/HomeController.php';
$conn = Database::getConnection();
$controller = new HomeController($conn);
$controller->index();
?>