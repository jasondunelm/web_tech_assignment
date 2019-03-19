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
    <title>Home Page | WGC</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--More CSS features by author-->
    <link rel="stylesheet" href="style_WestGames.css">
</head>
<body>
<nav class="navbar navbar-expand-xl navbar-light" style="background-color: #FAFFF2;">

    <a class="navbar-brand" href="home_page_admin.php">West Games Club</a>

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

            <li class="nav-item active dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Admin Functions
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="list_matches.php">List of Matches</a>
                    <a class="dropdown-item" href="leader_boards.php">Leader Boards</a>
                    <a class="dropdown-item" href="#">Statistics</a>
                    <a class="dropdown-item" href="#">Game Store</a>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="home_page_admin.php">Home Page <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="game_record_admin.php">Record Game</a>
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

            <form method="post" class="form-group mx-auto">

                <table width="auto" border="1" cellpadding="4" cellspacing="1"
                       class="table table-bordered table-dark"><h4 class="display-5">Account
                        Information</h4>
                    <thead>
                    <?php
                    $query = "SELECT Users.id, Users.userName, Users.firstName, Users.lastName, Users.userType FROM Users WHERE id=" . $_SESSION['id'];

                    $result = mysqli_query($link, $query);

                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td>User ID</td>
                            <td><?php echo $row["id"]; ?></td>
                        </tr>

                        <tr>
                            <td>User Name</td>
                            <td><?php echo $row["userName"]; ?></td>
                        </tr>

                        <tr>
                            <td>First Name</td>
                            <td><?php echo $row["firstName"]; ?></td>
                        </tr>

                        <tr>
                            <td>Last Name</td>
                            <td><?php echo $row["lastName"]; ?></td>
                        </tr>

                        <tr>
                            <td>User Type</td>
                            <td><?php echo $row["userType"]; ?></td>
                        </tr>
                    <?php } ?>
                    </thead>

                </table>

            </form>
        </div>

        <div class="row">

            <form method="post" class="mx-auto">

                <table width="auto" border="1" cellpadding="4" cellspacing="1"
                       class="table table-bordered table-dark"><h4 class="display-5">
                        Your recent play records</h4>
                    <div class="input-group mb-3">
                        <input type="text" name="q" class="form-control"
                               placeholder="Search win records by game name" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <input type="submit" name="submit" value="Filter" class="btn btn-primary mr-3">
                            <input type="submit" name="submit" value="All records" class="btn btn-primary">
                        </div>
                    </div>
                    <thead>
                    <tr>
                        <td>Match ID</td>
                        <td>Game Name</td>
                        <td>Match Date</td>
                        <td>Game Result</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if (!$_POST['submit']) {
                        $query = "SELECT Games.gameID, Games.gameName, Matches.matchID, Results.matchResult, Results.matchDate, Results.userID FROM Games JOIN Matches ON Games.gameID = Matches.gameID JOIN Results ON Matches.matchID = Results.matchID WHERE userID='" . $_SESSION['id'] . "'ORDER BY Results.matchID";

                        $result = mysqli_query($link, $query);

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row["matchID"]; ?></td>
                                <td><?php echo $row["gameName"]; ?></td>
                                <td><?php echo $row["matchDate"]; ?></td>
                                <td><?php echo $row["matchResult"]; ?></td>
                            </tr>
                        <?php }
                    } else {
                        if ($_POST['submit'] =="Filter") {
                            $q = $link->real_escape_string($_POST['q']);

                            $sql = $link->query("SELECT Games.gameID, Games.gameName, Matches.matchID, Results.matchResult, Results.matchDate, Results.userID
FROM Games
JOIN Matches ON Games.gameID = Matches.gameID
JOIN Results ON Matches.matchID = Results.matchID
WHERE userID='" . $_SESSION['id'] . "'AND gameName LIKE '%$q%'");

                            if ($sql->num_rows > 0) {
                                while ($row = $sql->fetch_array()) { ?>
                                    <tr>
                                        <td><?php echo $row["matchID"]; ?></td>
                                        <td><?php echo $row["gameName"]; ?></td>
                                        <td><?php echo $row["matchDate"]; ?></td>
                                        <td><?php echo $row["matchResult"]; ?></td>
                                    </tr>

                                <?php }
                            }
                        }
                    }

                    if ($_POST['submit']=="All records") {
                        $query = "SELECT Games.gameID, Games.gameName, Matches.matchID, Results.matchResult, Results.matchDate, Results.userID FROM Games JOIN Matches ON Games.gameID = Matches.gameID JOIN Results ON Matches.matchID = Results.matchID WHERE userID='" . $_SESSION['id'] . "'ORDER BY Results.matchID";

                        $result = mysqli_query($link, $query);

                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row["matchID"]; ?></td>
                                <td><?php echo $row["gameName"]; ?></td>
                                <td><?php echo $row["matchDate"]; ?></td>
                                <td><?php echo $row["matchResult"]; ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    </tbody>
                </table>
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