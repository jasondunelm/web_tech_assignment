<?php

session_start();
include("../functions.php");

echo $_SESSION['userType']."<br>";
echo $_SESSION['gameID'];

if ($_SESSION['gameID']==13){
    header('Location:game_info_admin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

</body>
</html>





