<?php

include "app.config.php";
include "app.model.php";

$results = array();
$act = (isset($_REQUEST['act'])) ? $_REQUEST['act'] : "";
$dir = (isset($_REQUEST['directory'])) ? $_REQUEST['directory'] : "";

switch ($act) {
    case "create":
        $face_id = $_REQUEST["face_id"];
        $firstname = $_REQUEST["firstname"];
        $lastname = $_REQUEST["lastname"];
        $serial_number = $_REQUEST["serial_number"];
        $newPath = 'images' . DIRECTORY_SEPARATOR . 'people' . DIRECTORY_SEPARATOR . $firstname . '_' . $lastname;
        $imgDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $newPath;

        if (!file_exists($imgDir)) {
            mkdir($imgDir, 0777, true);
            echo "Folder created successfully <br>";
        }

        $face_img = getFaceImage($conn, $face_id);
        $sourceImagePath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $face_img[0];
        $destinationImagePath = $imgDir . DIRECTORY_SEPARATOR . basename($face_img[0]);

        if (file_exists($sourceImagePath)) {
            if (copy($sourceImagePath, $destinationImagePath)) {
                echo "Image copied successfully to $destinationImagePath";
            } else {
                echo "Failed to copy image";
            }
        } else {
            echo "Image does not exist in the source path";
        }
        createPerson($conn, $face_id, $firstname, $lastname, $serial_number, $newPath . DIRECTORY_SEPARATOR . basename($face_img[0]));

        header("Location: index.php");
        exit;
        break;
    case "onephoto":
        $TPL["results"] = readSingleImage($conn, $_REQUEST['id']);
        $TPL["faces"] = readRelatedFaces($conn, $_REQUEST['id']);
        include "app.photo.php";
        break;
    case "view":
        $TPL["person"] = getPerson($conn, $_REQUEST['face_id']);
        include "app.photo.php";
        break;
    default:
        $TPL["results"] = readAllImages($conn);
        include "app.view.php";
}
