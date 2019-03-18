<?php
session_start();
include("functions.php");
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>West Games Club</title>

    <style>
        .heroImage {
            background-image: url("images/background.jpg");
            height: auto;
            border-radius: 0;
            background-size: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-xl navbar-light" style="background-color: #FAFFF2;">

    <a class="navbar-brand" href="index.php"><h3>West Games Club</h3></a>

    <!--nav bar toggler-->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!--nav bar with menu and collapse features-->
    <div class="collapse navbar-collapse" id="navbarCollapse">

        <form class="navbar-form navbar-right form-inline ml-auto" method="post">
            <div class="form-group">

                <input type="email" name="loginemail" placeholder="Email" class="form-control mr-2"
                       value="<?php echo addslashes($_POST['loginemail']); ?>"/>

                <input type="password" name="loginpassword" placeholder="Password" class="form-control mr-2"
                       value="<?php echo addslashes($_POST['loginpassword']); ?>"/>

                <input type="submit" name="submit" class="btn btn-success" value="Log In">
            </div>
        </form>

    </div>

</nav>

<div class="jumbotron heroImage text-center">

    <h1 class="display-4 text-light">West Games Club</h1>

    <p class="lead text-light">Your own board game records on-line, review your match records, and share your
        experiences with your friends.</p>

    <p class="lead text-light font-weight-bold">Interested? Sign Up Below!</p>

    <?php displayError(); ?>

    <div class="input-group">

        <form method="post" class="form-group col-md-5 mx-auto">

            <label for="email" class="lead text-light">Email Address</label>

            <input type="email" name="email" class="form-control" placeholder="Your email"
                   value="<?php echo addslashes($_POST['email']); ?>"/>

            <label for="password" class="lead text-light">Password</label>

            <input type="password" name="password" class="form-control" placeholder="Password"
                   value="<?php echo addslashes($_POST['password']); ?>"/>

            <label for="firstName" class="lead text-light">First Name</label>

            <input type="text" name="firstName" class="form-control" placeholder="Your First Name"
                   value="<?php echo addslashes($_POST['firstName']); ?>"/>

            <label for="lastName" class="lead text-light">Last Name</label>

            <input type="text" name="lastName" class="form-control mb-4" placeholder="Your Last Name"
                   value="<?php echo addslashes($_POST['lastName']); ?>"/>

            <input type="submit" name="submit" value="Sign Up" class="btn btn-success btn-lg marginTop">

        </form>

    </div>

</div>

<!--contents on page-->
<div class="jumbotron jumbotron-fluid text-center">

    <div class="container">

        <h1 class="display-4">Most Popular Board Games</h1>

        <div class="row">

            <table method="get" border="1" cellpadding="4" cellspacing="1"
                   class="table-group mx-auto table-bordered table-dark">
                <thead>
                <tr>
                    <td>Game Name</td>
                    <td>Game Rating</td>
                    <td>Number Players for play</td>
                    <td>Game Image</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM Games";

                $result = mysqli_query($link, $query);

                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row["gameName"]; ?></td>
                        <td><?php echo $row["gameRating"]; ?></td>
                        <td><?php echo $row["gameNumPlayer"]; ?></td>
                        <td><?php echo "<img style='width: 8rem;' src = 'images/" . $row['images'] . "'>"; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>

        <!--footer-->
        <div class="jumbotron text-center footer-height">
            <p>Copyright&nbsp;&copy; 2019 West Games Club</p>
        </div>
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