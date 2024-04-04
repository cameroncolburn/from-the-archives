<?php
function readAllImages($conn)
{
    $results = array();

    try {
        $query = "SELECT * FROM image";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        while ($nextRow = $stmt->fetch()) $results[] = $nextRow;
    } catch (PDOException $e) {
        $e->getMessage();
    }

    return $results;
}

function readSingleImage($conn, $id)
{
    $results = array();

    try {
        $query = "SELECT * FROM image WHERE image_id = $id;";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        while ($nextRow = $stmt->fetch()) $results[] = $nextRow;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return $results;
}

function readRelatedFaces($conn, $id)
{
    $results = array();

    try {
        $query = "SELECT * FROM face WHERE image_id = $id AND is_face = 1;";
        // $query = "SELECT * FROM face WHERE image_id = $id;";                        // This line is for testing
        $stmt = $conn->prepare($query);
        $stmt->execute();

        while ($nextRow = $stmt->fetch()) $results[] = $nextRow;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return $results;
}

function createPerson($conn, $face_id, $firstname, $lastname, $serial_number, $file_path)
{
    try {
        $stmt = $conn->prepare("INSERT INTO person (face_id, firstname, lastname, serial_number, file_path)" .
            " VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$face_id, $firstname, $lastname, $serial_number, $file_path]);
    } catch (PDOException $e) {
        echo "Insert failed: " . $e->getMessage();
        exit();
    }
}

function getPerson($conn, $face_id)
{
    $results = array();

    try {
        $query = "SELECT * FROM face WHERE face_id = $face_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        while ($nextRow = $stmt->fetch()) $results[] = $nextRow;
    } catch (PDOException $e) {
        $e->getMessage();
    }
    return $results;
}

function getFaceImage($conn, $face_id)
{
    $results = array();

    try {
        $query = "SELECT file_path FROM face  WHERE face_id = $face_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        while ($nextRow = $stmt->fetch()) $results[] = $nextRow[0];
    } catch (PDOException $e) {
        $e->getMessage();
    }

    return $results;
}
