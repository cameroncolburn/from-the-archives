<?php

$DB["server"] = "localhost";
$DB["db"] = "photos_db";
$DB["password"] = "";
$DB["username"] = "root";

try {
    $conn = new PDO(
        "mysql:host=" . $DB["server"] . ";dbname=" . $DB["db"],
        $DB["username"],
        $DB["password"]
    );
} catch (PDOException $e) {
    $e->getMessage();
}
