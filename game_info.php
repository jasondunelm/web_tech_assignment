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
    <title>Game Info | WGC</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--More CSS features by author-->
    <link rel="stylesheet" href="style_WestGames.css">

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
    <div class="container text-center">
        <?php displayError(); ?>
        <div class="row">
            <form method="get" class="mx-auto" action="game_record.php">
                <table width="auto" border="1" cellpadding="4" cellspacing="1"
                       class="table table-bordered table-dark">
                    <thead>
                    <?php
                    $searchGame = $_SESSION['gameID'];

                    $query = "SELECT * FROM Games WHERE gameID LIKE ('$searchGame%')";

                    $result = mysqli_query($link, $query);

                    $row = mysqli_fetch_assoc($result) ?>
                    <tr>
                        <td>Game Name:</td>
                        <td>
                            <?php echo "<img style='width: 12rem;' src = 'images/" . $row['images'] . "'>" . "<br/>"; ?>
                            <?php echo "<br/>" . $row["gameName"]; ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Game ID:</td>
                        <td><?php echo $row["gameID"]; ?></td>
                    </tr>

                    <tr>
                        <td>Number Players for play:</td>
                        <td><?php echo "<br/>" . $row["gameNumPlayer"]; ?></td>
                    </tr>
                    <tr>
                        <td>Game Description:</td>
                        <td class="text-left"><?php echo $row["gameDescription"]; ?></td>
                    </tr>
                    </thead>
                    <tbody>


                </table>
                <button type="submit" name="goRecord" value="Go Record" class="btn btn-primary my-2 my-sm-0"
                        id="submitBtn">Make a New Game Record
                </button>
            </form>
        </div>
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

</body>
</html>
