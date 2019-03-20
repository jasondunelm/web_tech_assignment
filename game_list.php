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
                    <a class="dropdown-item" href="leader_board_game.php">Leader Board - Game</a>
                    <a class="dropdown-item" href="leader_board_member.php">Leader Board - Member</a>
                    <a class="dropdown-item" href="won_percentage.php">Statics: Won-Played Percentage</a>
                    <a class="dropdown-item" href="matches_per_day.php">Statics: Number of Matches per Day</a>
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

            <form method="post" class="mx-auto">

                <table class="table-sm table-bordered table-dark text-sm"><h4 class="display-5">
                        List of Board Games</h4>
                    <div class="form-inline mb-3">
                        <?php

                        $query = "SELECT gameName FROM Games ORDER BY Games.gameName ASC";

                        $result = mysqli_query($link, $query);
                        echo "<select name='selectedGame' class='mx-auto'><option value=''>Select a Board Game</option>";
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option><?php echo $row["gameName"]; ?></option>
                        <?php }
                        echo "</select>";
                        ?>
                        <div class="input-group-append mx-auto">
                            <input type="submit" name="submit" value="Filter Game" class="btn btn-primary mr-3">
                            <input type="submit" name="submit" value="Add New Game" class="btn btn-primary mr-3">
                            <input type="submit" name="submit" value="All Records" class="btn btn-primary">
                        </div>
                    </div>
                    <thead>
                    <tr>
                        <td>Game ID</td>
                        <td>Game Name</td>
                        <td>Game Rating</td>
                        <td>Number Players for play</td>
                        <td>Game Image</td>
                        <td>Game Description</td>
                        <td>Operations</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!$_POST['submit'] == "Filter Game") {
                        $query = "SELECT * FROM Games ORDER BY `Games`.`gameRating` ASC";

                        $result = mysqli_query($link, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>" . $row["gameID"] . "</td>
                            <td>" . $row["gameName"] . "</td>
                            <td>" . $row["gameRating"] . "</td>
                            <td>" . $row["gameNumPlayer"] . "</td>
                            <td><img style='width: 8rem;' src = 'images/" . $row['images'] . "'></td>
                            <td class='col-2 text-sm-left'>" . $row["gameDescription"] . "</td>
                            <td><a href=\"edit_game_info.php?gid=$row[gameID]&gn=$row[gameName]&gr=$row[gameRating]&gnp=$row[gameNumPlayer]&gimg=$row[images]&gdes=$row[gameDescription]\" class=\"btn btn-warning my-2 my-sm-0\">Edit</a></td>
                        </tr>";
                        }
                    } else if ($_POST['submit'] == "All Records") {
                        $query = "SELECT * FROM Games ORDER BY `Games`.`gameRating` ASC";

                        $result = mysqli_query($link, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>" . $row["gameID"] . "</td>
                            <td>" . $row["gameName"] . "</td>
                            <td>" . $row["gameRating"] . "</td>
                            <td>" . $row["gameNumPlayer"] . "</td>
                            <td><img style='width: 8rem;' src = 'images/" . $row['images'] . "'></td>
                            <td class='col-2 text-sm-left'>" . $row["gameDescription"] . "</td>
                            <td><a href=\"edit_game_info.php?gid=$row[gameID]&gn=$row[gameName]&gr=$row[gameRating]&gnp=$row[gameNumPlayer]&gimg=$row[images]&gdes=$row[gameDescription]\" class=\"btn btn-warning my-2 my-sm-0\">Edit</a></td>
                        </tr>";
                        }
                    } else if ($_POST['submit'] == "Filter Game") {
                            $post_selectedGame = $_POST["selectedGame"];

                            if ($_POST["selectedGame"]) {
                                $error = "Please select a game!";
                            } else {
                                $query = "SELECT * FROM Games WHERE gameName='$post_selectedGame'";

                                $result = mysqli_query($link, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>" . $row["gameID"] . "</td>
                                            <td>" . $row["gameName"] . "</td>
                                            <td>" . $row["gameRating"] . "</td>
                                            <td>" . $row["gameNumPlayer"] . "</td>
                                            <td><img style='width: 8rem;' src = 'images/" . $row['images'] . "'></td>
                                            <td class='col-2 text-sm-left'>" . $row["gameDescription"] . "</td>
                                            <td><a href=\"edit_game_info.php?gid=$row[gameID]&gn=$row[gameName]&gr=$row[gameRating]&gnp=$row[gameNumPlayer]&gimg=$row[images]&gdes=$row[gameDescription]\" class=\"btn btn-warning my-2 my-sm-0\">Edit</a></td>
                                          </tr>";
                                }
                            }
                        } else {
                        if ($_POST["submit"] == "Add New Game"){
                            header("Location:add_new_game.php");
                        }
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