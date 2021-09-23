<?php
session_start();

include("connection.php");
include("functions.php");



// images insertion in database
if (isset($_POST['submit'])) {

    $uploadsDir = "uploads/";
    $allowedFileType = array('jpg', 'png', 'jpeg');

    // Velidate if files exist
    if (!empty(array_filter($_FILES['fileUpload']['name']))) {

        // Loop through file items
        foreach ($_FILES['fileUpload']['name'] as $id => $val) {
            // Get files upload path
            $fileName        = $_FILES['fileUpload']['name'][$id];
            $tempLocation    = $_FILES['fileUpload']['tmp_name'][$id];
            $targetFilePath  = $uploadsDir . $fileName;
            $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $uploadOk = 1;

            if (in_array($fileType, $allowedFileType)) {
                if (move_uploaded_file($tempLocation, $targetFilePath)) {
                    $sqlVal = "('" . $fileName . "')";
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "File coud not be uploaded."
                    );
                }
            } else {
                $response = array(
                    "status" => "alert-danger",
                    "message" => "Only .jpg, .jpeg and .png file formats allowed."
                );
            }
            // Add into MySQL database
            if (!empty($sqlVal)) {
                $insert = $conn->query("INSERT INTO imageupload (images) VALUES $sqlVal");
                if ($insert) {
                    $response = array(
                        "status" => "alert-success",
                        "message" => "Files successfully uploaded."
                    );
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Files coudn't be uploaded due to database error."
                    );
                }
            }
        }
    } else {
        // Error
        $response = array(
            "status" => "alert-danger",
            "message" => "Please select a file to upload."
        );
    }
}


function php_func($conn)
{
    if (isset($_GET['deleteSubmit'])) {
        $storeId = $_GET['idimage'];

        $querySelect = "select image from imageupload where id = '$storeId'";
        mysqli_query($conn, $querySelect);

        $queryDel = "delete from imageupload where id = '$storeId'";
        mysqli_query($conn, $queryDel);
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Gallery</title>
</head>
<style>
    .container {
        max-width: 450px;
    }

    .imgGallery img {
        padding: 8px;
        max-width: 100px;
    }
</style>

<body>


    <div class="container mt-5">
        <form action="" method="post" enctype="multipart/form-data" class="mb-3">
            <h3 class="text-center mb-5">This is Israil's Gallery</h3>

            <div class="user-image mb-3 text-center">
                <div class="imgGallery">
                    <!-- Image preview -->
                </div>
            </div>

            <div class="custom-file">
                <input type="file" name="fileUpload[]" class="custom-file-input" id="chooseFile" multiple>
                <label class="custom-file-label" for="chooseFile">Select file</label>
            </div>

            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                Upload Files
            </button>
        </form>



        <div class="spacer" style="height: 100px;"></div>
        <div id="carouselExampleIndicators" class="container carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $sql = "SELECT * FROM imageupload";
                $result =  mysqli_query($conn, $sql);
                $number_of_images = mysqli_num_rows($result);
                for ($i = 0; $i < $number_of_images; $i++) {
                ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) {
                                                                                                        echo 'class="active"';
                                                                                                    } ?>></li>
                <?php
                }
                ?>
            </ol>
            <div class="carousel-inner">


                <?php

                for ($i = 0; $i < $number_of_images; $i++) {
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class="carousel-item <?php if ($i == 0) {
                                                    echo "active";
                                                } ?>">
                        <img src="uploads/<?php echo $row['images']; ?>" class="d-block w-100" alt="...">
                    </div>

                <?php
                }
                ?>




            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="spcacer" style="height: 100px;"></div>

    <!-- Gallery Content -->
    <div class="container-fluid">

        <h1 class="fw-light text-center text-lg-start mt-4 mb-0">Thumbnail Gallery</h1>

        <hr class="mt-2 mb-5">

        <div class="row text-center text-lg-start">
            <?php
            $sql = "SELECT * FROM imageupload";
            $result =  mysqli_query($conn, $sql);
            $number_of_images = mysqli_num_rows($result);
            for ($i = 0; $i < $number_of_images; $i++) {
                $row = mysqli_fetch_assoc($result);

            ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="#" class="d-block mb-4 h-100">
                        <img src="uploads/<?php echo $row['images']; ?>" class="img-fluid img-thumbnail" alt="">
                        <form action="" method="GET">
                            <input type="hidden" name="idimage" value="<?php echo $row['id']; ?>">
                            <button name="deleteSubmit" onclick="clickMe()">Delete</button>
                        </form>

                    </a>
                </div>

            <?php
            }
            ?>



        </div>
        <?php

        ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script>
        function clickMe() {
            var result = "<?php php_func($conn); ?>"
            document.write(result);
        }
        $('.button-delete').click(function() {
            $.ajax({
                type: "GET",
                url: "some.php",
                data: {
                    name: "John"
                }
            }).done(function(msg) {
                alert("Data Saved: " + msg);
            });
        });
        $(function() {

            var multiImgPreview = function(input, imgPreviewPlaceholder) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#chooseFile').on('change', function() {
                multiImgPreview(this, 'div.imgGallery');
            });
        });
    </script>


</body>

</html>