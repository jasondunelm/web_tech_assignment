<?php
session_start();
include("functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Record a Game | WGC</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--More CSS features by author-->
    <link rel="stylesheet" href="style_WestGames.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <style>

        #welcomeMsg {
            font-size: 25px;
            margin-top: 10px;
            color: #DF6126;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-xl navbar-light" style="background-color: #FAFFF2;">

    <a class="navbar-brand" href="home_page.php">West Games Club</a>

    <p class="mr-auto" id="welcomeMsg"> Welcome <?php

        $id = $_SESSION['id'];

        $query = "SELECT Users.firstName FROM Users WHERE id=" . $id;

        $result = mysqli_query($link, $query);

        $row = mysqli_fetch_assoc($result);

        echo($row['firstName']) ?>!</p>
    <!--nav bar toggler-->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!--nav bar with menu and collapse features-->
    <div class="collapse navbar-collapse" id="navbarCollapse">

        <form class="navbar-form navbar-right form-inline ml-auto" method="post">
            <div class="form-group">
                <input type="text" id="searchGame" name="searchGame" placeholder="search a game"
                       class="form-control mr-2"
                       value="<?php echo addslashes($_POST['searchGame']); ?>"/>

                <input type="submit" name="submit" class="btn btn-success my-2 my-sm-0" value="Search Game">
            </div>
        </form>

        <ul class="navbar-nav mr-auto ml-auto">

            <li class="nav-item active">
                <a class="nav-link" href="home_page.php">Home Page <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="game_record.php">Record Game</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="index.php?logout=1">Log Out</a>
            </li>

        </ul>
    </div>
</nav>

<!--contents on page-->
<div class="jumbotron jumbotron-fluid">

    <div class="row mx-2">

        <form method="post" name="recordForm" class="mx-auto text-left"
              enctype="multipart/form-data">
            <?php displayError(); ?>

            <h4 class="display-5" id="recordForm">Upload your new Game Record</h4>

            <p><strong>1. Please choose the game you played:</strong></p>

            <?php

            $query = "SELECT gameName FROM Games ORDER BY Games.gameName ASC";

            $result = mysqli_query($link, $query);
            echo "<select name=q0><option value=''>Select a Board Game</option>";
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <option><?php echo $row["gameName"]; ?></option>
            <?php }
            echo "</select>";
            ?>
            <br/><br/>

            <p><strong>2. When did you play this board game?</strong></p>

            <p>Date: <input name="q1" type="text" id="datepicker" placeholder="choose a date"></p>

            <p><strong>3. Please tick all players (username) whom you played with:</strong></p>

            <?php
            $query = "SELECT userName, FirstName, LastName, id FROM Users ORDER BY Users.FirstName ASC";

            $result = mysqli_query($link, $query);
            echo "<table border='1' cellspacing='3' width='auto'>";
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <input name="q2[]" type='checkbox' value="<?php echo $row["userName"] ?>"/><?php echo " ";
                echo $row["FirstName"];
                echo ".";
                echo $row["LastName"];
                echo " (";
                echo $row["userName"];
                echo ")";
                ?>
                <br/>
            <?php }
            echo "</table><br/>";
            ?>

            <p><strong>4. Who is the winner of this board game?</strong></p>

            <?php
            $query = "SELECT FirstName, LastName, userName FROM Users ORDER BY Users.FirstName ASC";

            $result = mysqli_query($link, $query);
            echo "<select name='q3[]'><option value=''>Select a Winner</option>";
            while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo $row["userName"] ?>"><?php echo " ";
                    echo $row["FirstName"];
                    echo ".";
                    echo $row["LastName"];
                    echo " (";
                    echo $row["userName"];
                    echo ")";
                    ?></option>
            <?php }
            echo "</select>";
            ?>
            <br/><br/>

            <button type="submit" name="submit" value="Upload Record" class="btn btn-primary my-2 my-sm-0"
                    id="submitBtn">Submit
            </button>

            <button class="btn btn-primary my-2 my-sm-0 ml-5" type="reset" value="Reset">Reset</button>

        </form>
    </div>
</div>


<!--footer-->
<div class="footer">
    <div class="view1">
        Copyright&nbsp;&copy; 2019 West Games Club &nbsp;
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
</body>
</html>
