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

        <div class="text-center bg-dark-subtle rounded border border-dark-subtle p-5 mb-5">

            <h2><?php echo $TPL["results"][0]["filename"] ?></h2>
            <div id="img-container">
                <canvas id="myCanvas" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="faceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $TPL["faces"][0]["filename"] ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 text-center">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" disabled>Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        var img = new Image();
        img.onload = function() {
            var container = document.getElementById('img-container');
            var canvas = document.getElementById("myCanvas");
            var ctx = canvas.getContext("2d");
            var scaleX = canvas.offsetWidth / img.width;
            var scaleY = canvas.offsetHeight / img.height;
            canvas.width = img.width * scaleX;
            canvas.height = img.height * scaleY;
            ctx.drawImage(img, 0, 0, img.width * scaleX, img.height * scaleY);
            var faces = <?php echo json_encode($TPL["faces"]); ?>;
            faces.forEach(face => {
                var boxX = face["x_axis"];
                var boxY = face["y_axis"];
                var boxWidth = face["width"];
                var boxHeight = face["height"];
                var scaleBoxX = Math.ceil(boxX * scaleX);
                var scaleBoxY = Math.ceil(boxY * scaleY);
                var scaleBoxWidth = Math.ceil(boxWidth * scaleX);
                var scaleBoxHeight = Math.ceil(boxHeight * scaleY);

                // Create anchor tag
                var anchor = document.createElement('a');
                anchor.href = '#';
                anchor.style.position = 'absolute';
                anchor.style.left = (scaleBoxX + container.offsetLeft) + 'px';
                anchor.style.top = (scaleBoxY + container.offsetTop) + 'px';
                anchor.style.width = scaleBoxWidth + 'px';
                anchor.style.height = scaleBoxHeight + 'px';
                anchor.style.display = 'block';
                anchor.style.border = '2px solid yellow';

                anchor.addEventListener('click', function(event) {
                    event.preventDefault();
                    var faceModal = new bootstrap.Modal(document.getElementById('faceModal'));
                    faceModal.show();
                    var modalBody = document.querySelector('#faceModal .modal-body');
                    modalBody.innerHTML = '<img src="../' + face["file_path"] + '">';
                    modalBody.innerHTML += '<p>Name: ' + face["name"] + '</p>';
                });

                container.appendChild(anchor);
            });
        };
        img.src = '../<?php echo addslashes($TPL["results"][0]["file_path"]); ?>';
    </script>



</body>

</html>