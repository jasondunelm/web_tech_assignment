<?php

session_start();

include("functions.php");

$gameNM = $_GET["gameNM"];

$query = "SELECT * FROM Games WHERE gameName LIKE ('$gameNM%')";

$res = mysqli_query($link, $query);

echo "<table border='1'>";

while ($row = mysqli_fetch_array($res)) { ?>

    <tr>
        <td><?php echo $row["gameName"]; ?></td>
    </tr>


<?php }

echo "</table>";

?>
