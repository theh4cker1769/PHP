<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($conn);

if (isset($_POST['submit'])) {
    $uploadFolder = 'uploads/';
    $allowedFileType = array('jpg', 'png', 'jpeg');

    if (!empty(array_filter($_FILES['fileUpload']['name']))) {

        // Loop through file items
        foreach ($_FILES['fileUpload']['name'] as $id => $val) {
            // Get files upload path
            $fileName        = $_FILES['fileUpload']['name'][$id];
            $tempLocation    = $_FILES['fileUpload']['tmp_name'][$id];
            $targetFilePath  = $uploadFolder . $fileName;
            $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .imgGallery img {
            padding: 8px;
            max-width: 100px;
        }
    </style>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data" class="mb-3" style="width: 30%;margin: 0 auto;margin-top: 50px;">
        <div class="imgGallery">
            <!-- image preview -->
        </div>

        <!-- Display response messages -->
        <?php if (!empty($response)) { ?>
            <div class="alert <?php echo $response["status"]; ?>">
                <?php echo $response["message"]; ?>
            </div>
        <?php } ?>

        <div class="custom-file">
            <input type="file" name="fileUpload[]" class="custom-file-input" id="chooseFile" multiple>
            <label class="custom-file-label" for="chooseFile">Select file</label>
        </div>

        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
            Upload Files
        </button>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script>
        $(function() {
            // Image preview with js
            var imgPreview = function(input, imgPreviewPlace) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $($.parseHTML('<img>')).attr('src', e.target.result).appendTo(imgPreviewPlace);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }

            $('#chooseFile').on('change', function() {
                imgPreview(this, 'div.imgGallery');
            });

        });
    </script>
</body>

</html>