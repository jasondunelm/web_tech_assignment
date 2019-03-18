<?php
/**
 * Created by PhpStorm.
 * User: jasonhao
 * Date: 2019-03-14
 * Time: 14:26
 */

session_start();
include("functions.php");

$msg = "";

if (isset($_POST['upload'])) {
    $target = "images/" . basename($_FILES['image']['name']);

    $image = $_FILES['image']['name'];
    $text = $_POST['text'];

    $sql = "INSERT INTO Images (images, gameID) VALUES ('$image', '$text')";

    $query = mysqli_query($link, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg = "Image uploaded successfully";
    } else {
        $msg = "There was a problem uploading image";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
    <style>
        #content {
            width: 50%;
            margin: 20px auto;
            border: 1px solid #cbcbcb;
        }

        form {
            width: 50%;
            margin: 20px auto;
        }

        form div {
            margin-top: 5px;
        }

        #img_div {
            width: 80%;
            padding: 5px;
            margin: 15px auto;
            border: 1px solid #cbcbcb;
        }

        #img_div:after {
            content: "";
            display: block;
            clear: both;
        }

        img {
            float: left;
            margin: 5px;
            width: 300px;
            height: 140px;
        }
    </style>
</head>
<body>
<div id="content">
    <?php
    $sql = "SELECT * FROM Games";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_array($result)) {
        echo "<div id='img_div'>";
        echo "<img src='images/" . $row['image'] . "'>";
        echo "<p>" . $row['text'] . "</p>";
        echo "</div>";
    }

    ?>
    <form action="uploadImage.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="size" value="1000000">
        <div>
            <input type="file" name="image">
        </div>
        <div>
            <textarea name="text" cols="40" rows="4" placeholder="Say something about this image"></textarea>
        </div>
        <div>
            <input type="submit" name="upload" value="Upload Image">
        </div>
    </form>

</div>

</body>
</html>