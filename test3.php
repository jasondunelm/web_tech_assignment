<?php
// edit a game info to database

$gameID = "180974";
$newRating = "1";
$newNumOfPlayers = "2-4 players";
$newGameDes = "11Potion Explosion is a game for 2 to 4 players by Horrible Games.It was designed by Lorenzo Silva, Andrea Crespi and Stefano Castelli.Dear students, it's time for the final exams of the Potions class! The rules are always the same: Take an ingredient marble from the dispenser and watch the others fall. If you connect marbles of the same color, they explode and you can take them, too! Complete your potions using the marbles you collect, and drink them to unleash their magical power. Remember, though, that to win the Student of the Year award, being quick won't be enough: you'll also need to brew the most valuable potions in Potion Explosion!";

$query = "UPDATE Games SET gameRating = '$newRating', gameNumPlayer = '$newNumOfPlayers', gameDescription = '".mysqli_real_escape_string($link, $newGameDes)."' WHERE Games.gameID = '$gameID'";
echo $query;
//$data = mysqli_query($link, $query);
//if ($data) {
//$message = "Game info updated successfully! <a href=game_list.php>Check updated list here</a>";
//} else {
//$error = "Update is failed, please try again!";
//}
//
//} else if (isset($_POST['cancelGameEdit'])) {
//header("Location:game_list.php");


?>
