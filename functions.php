<?php
session_start();

// to connect with mySQL database either to use PDO or mysqli_connect
try {
    $pdo = new PDO('mysql:host=127.0.0.1; dbname=west_games', 'root', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$link = mysqli_connect("127.0.0.1", "root", "password", "west_games");

// to logout and clear session records
if ($_GET["logout"] == 1 AND $_SESSION['id']) {

    session_destroy();

    $message = "You have been logged out. Have a good day!";

}

// to register a new user
if ($_POST['submit'] == "Sign Up") {

    if (!$_POST['email']) {
        $error .= "<br />Please enter your email.";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error .= "<br />Please enter a valid email address.";
    }

    if (!$_POST['password']) {
        $error .= "<br />Please enter your password.";
    } else {
        if (strlen($_POST['password']) < 8) $error .= "<br />Please enter a password at least 8 characters.";
        if (!preg_match('`[A-Z]`', $_POST['password'])) $error .= "<br />Please include at least one capital letter in your password.";
    }

    if (!addslashes($_POST['firstName'])) {
        $error .= "<br />Please enter your First Name.";
    }

    if (!addslashes($_POST['lastName'])) {
        $error .= "<br />Please enter your Last Name.";
    }

    if ($error) {
        $error = "There were error(s) in your signup details:" . $error;
    } else {

        $query = "SELECT * FROM Users WHERE userName='" . mysqli_real_escape_string($link, $_POST['email']) . "'";

        $result = mysqli_query($link, $query);

        $results = mysqli_num_rows($result);

        if ($results) {
            $error = "That email address is already registered, Do you want to log in ?";
        } else {

            $query = "INSERT INTO Users (userName, password, firstName, lastName, userType) VALUES('" . mysqli_real_escape_string($link, $_POST['email']) . "','" . md5(md5($_POST['email']) . $_POST['password']) . "','" . ($_POST['firstName']) . "','" . ($_POST['lastName']) . "','user')";

            mysqli_query($link, $query);

            $message = "You have been signed up!";

            $_SESSION['id'] = mysqli_insert_id($link);

        }
    }
}

// to login the system
if ($_POST['submit'] == "Log In") {

    $query = "SELECT * FROM Users WHERE userName='" . mysqli_real_escape_string($link, $_POST['loginemail']) . "' AND password='" . md5(md5($_POST['loginemail']) . $_POST['loginpassword']) . "' LIMIT 1";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) { //found user
        // check if userType is admin or user
        $row = mysqli_fetch_assoc($result);

        if ($row['userType'] == 'admin') {
            $_SESSION['id'] = $row['id'];
            $_SESSION['userType'] = $row['userType'];
            header("Location:home_page_admin.php");
        } else {
            $_SESSION['id'] = $row['id'];
            header("Location:home_page.php");
        }

    } else {
        $error = "We could not find a user with that email and password. Please try again later.";
    }
}

// to judge if user is an admin user type
function isAdmin()
{
    if (isset($_SESSION['id']) && $_SESSION['id']['userType'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

// display an Error message if any
function displayError()
{
    global $error;
    global $message;

    if ($error) {

        echo '<div class="alert alert-danger">' . addslashes($error) . '</div>';

    }

    if ($message) {

        echo '<div class="alert alert-success">' . addslashes($message) . '</div>';

    }
}

// upload a game record to database
if ($_POST['submit'] == "Upload Record") {

    $post_q0 = $_POST['q0'];
    $post_q1 = $_POST['q1'];
    $post_q2 = $_POST['q2'];
    $post_q3 = $_POST['q3'];
    $player_id_array = array();

    if (!$_POST['q0']) {
        $error .= "<br />Please answer question one!";
    }

    if (!$_POST['q1']) {
        $error .= "<br />Please answer question two!";
    }

    if (!$_POST['q2']) {
        $error .= "<br />Please answer question three!";
    }

    if (!$_POST['q3']) {
        $error .= "<br />Please answer question four!";
    }

    if ($error) {
        $error = "There were error(s) in your game record details:" . $error;
    } else {
        //to obtain a new matchID from mySQL
        $query = "SELECT * FROM Games WHERE gameName = '$post_q0'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);

        if ($row) {
            $gameID = $row["gameID"];
            $gameName = $row["gameName"];
            $query = "INSERT INTO Matches (gameID, gameName) VALUES ('$gameID', '$gameName')";
            $result = mysqli_query($link, $query);
            $query1 = "SELECT matchID FROM Matches ORDER BY matchID DESC LIMIT 1";
            $result1 = mysqli_query($link, $query1);
            $row = mysqli_fetch_array($result1);
            $row_matchID = $row["matchID"];

        }
        //to obtain players userID from mySQL
        if (!empty($post_q2)) {
            foreach ($post_q2 as $selected) {
                $values = explode('|', $selected);
                $userName = $values[0];
                $query = "SELECT * FROM Users WHERE userName = '$userName'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                array_push($player_id_array, $row["id"]);

            }
        }
        //to obtain winner's userID from mySQL
        if ($_POST['submit'] == "Upload Record") {

            $post_q3 = $_POST['q3'];

            foreach ($post_q3 as $selected) {
                $values = explode('|', $selected);
                $userName = $values[0];
                $query = "SELECT * FROM Users WHERE userName = '$userName'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                $row_winnerID = $row["id"];
            }
        }

        foreach ($player_id_array as $selected) {
            if ($selected == $row_winnerID) {
                $query = "INSERT INTO Results (matchID, matchDate, userID, matchResult) VALUES('$row_matchID', '$post_q1', '$selected', 'win')";
            } else {
                $query = "INSERT INTO Results (matchID, matchDate, userID, matchResult) VALUES('$row_matchID', '$post_q1', '$selected', 'lose')";
            }

            mysqli_query($link, $query);
        }

        $message = "This game record been uploaded successfully!";
        $userType = $_SESSION['userType'];

        if ($userType == 'admin') {
            $_SESSION['gameID'] = $row['gameID'];
            header('Location:game_record_admin.php');
        } else {
            $_SESSION['gameID'] = $row['gameID'];
            header('Location:game_record.php');
        }

    }

}

// search a game name via search bar
if ($_POST['submit'] == "Search Game") {

    $userType = $_SESSION['userType'];

    if (!$_POST['searchGame']) {
        $error .= "Did you enter anything? Please enter something to start search!";
    } else {
        $query = "SELECT * FROM Games WHERE gameName LIKE '%" . mysqli_real_escape_string($link, $_POST['searchGame']) . "%'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) == 1) { //found game
            // check if userType is admin or user
            $row = mysqli_fetch_assoc($result);

            if ($userType == 'admin') {
                $_SESSION['gameID'] = $row['gameID'];
                header('Location:game_info_admin.php');
            } else {
                $_SESSION['gameID'] = $row['gameID'];
                header('Location:game_info.php');
            }
        } else {
            $error = "We could not find a game name similar with your request name. Please try again.";
        }
    }
}

// edit a game record to database
if (isset($_POST['updateRecord'])) {
    $newResult = $_POST['newResult'];
    $resultID = $_GET['rid'];
    $query = "UPDATE Results SET matchResult = '$newResult' WHERE Results.resultID = '$resultID'";
    $data = mysqli_query($link, $query);
    if ($data) {
        $message = "Game result updated successfully! <a href=list_matches.php>Check updated list here</a>";
    } else {
        $error = "Update is failed, please try again!";
    }

} else if (isset($_POST['cancelEdit'])) {
    header("Location:list_matches.php");
}

// delete a player's game record in database
if (isset($_POST['deleteRecord'])) {
    $resultID = $_GET['rid'];
    $query = "DELETE FROM Results WHERE Results.resultID = '$resultID'";
    $data = mysqli_query($link, $query);
    if ($data) {
        $message = "Game result deleted successfully! <a href=list_matches.php>Check updated list here";
    } else {
        $error = "Delete is failed, please try again!";
    }
}


?>