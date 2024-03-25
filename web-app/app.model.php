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
