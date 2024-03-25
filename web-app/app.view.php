<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>From The Archives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light-subtle">
    <div class="container">
        <h1 class="fw-light text-center text-lg-start mt-4 mb-0">
            <a href="app.ctrl.php" style="color: unset;" class="text-decoration-none">From The Archives</a>
        </h1>
        <hr class="mt-2 mb-5">

        <div class="text-center bg-dark-subtle rounded border border-dark-subtle p-5">

            <h2>All Images</h2>
            <p>Click on a photo</p>

            <div class="d-flex flex-row flex-wrap justify-content-center">
                <?php
                $count = 0;
                foreach ($TPL["results"] as $row) {
                ?>
                    <a href="app.ctrl.php?act=onephoto&id=<?php echo $row['image_id'] ?>" class="m-2">
                        <img class="img-thumbnail" src='..<?php echo DIRECTORY_SEPARATOR . $row['thumbnail_path'] ?>'>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>