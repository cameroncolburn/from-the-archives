<?php

include "app.config.php";
include "app.model.php";

$results = array();
$act = (isset($_REQUEST['act'])) ? $_REQUEST['act'] : "";
$dir = (isset($_REQUEST['directory'])) ? $_REQUEST['directory'] : "";

switch ($act) {
    case "onephoto":
        $TPL["results"] = readSingleImage($conn, $_REQUEST['id']);
        $TPL["faces"] = readRelatedFaces($conn, $_REQUEST['id']);
        include "app.photo.php";
        break;

    default:
        $TPL["results"] = readAllImages($conn);

        include "app.view.php";
}
