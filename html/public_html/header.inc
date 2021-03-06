<?php
include_once 'dbconnect.php';
$directoryURI =basename($_SERVER['SCRIPT_NAME']);
$result = mysqli_query($MySQLiconn, "select * from cinema");
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Golden Village</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="images/gv32x32.ico" rel="shortcut icon" />

    </head>
    <body>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">
                Golden Village
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav">
                <li <?php if (strpos($directoryURI,'index.php') !== false) {echo 'class="active"';}?>><a href="index.php"><span class="glyphicon glyphicon-home blue"></span>Home</a></li>
                <li <?php if (strpos($directoryURI,'MainMovie.php') !== false) {echo 'class="active"';}?>><a href="MainMovie.php"><span class="glyphicon glyphicon-film"></span>Movie</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"><span class="glyphicon glyphicon-facetime-video"></span>Cinemas <span class="caret"></span></a>
                    <ul class="dropdown-menu inverse">
                        <li <?php if (strpos($directoryURI,'MainCinema.php') !== false) {echo 'class="active"';} ?>><a href="MainCinema.php">Cinema List</a></li>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            if (strpos($directoryURI,'cinema.php') !== false) {
                                if (strpos($_GET['q'], $row['cinema_id']) !== false) {
                                        echo '<li class="active"><a href="cinema.php?q='.$row['cinema_id'].'">'.$row['cinema_name'].'</a></li>';
                                    }
                                    else {
                                        echo '<li><a href="cinema.php?q='.$row['cinema_id'].'">'.$row['cinema_name'].'</a></li>';
                                    }
                                }
                            else {
                                echo '<li><a href="cinema.php?q='.$row['cinema_id'].'">'.$row['cinema_name'].'</a></li>';
                            }
                        }
?>
                    </ul>
                </li>
                <li <?php if (strpos($directoryURI,'MainPromotion.php') !== false) {echo 'class="active"';}?>><a href="MainPromotion.php"><span class="glyphicon glyphicon-usd"></span>Promotions</a></li>
            </ul>
            <?php
            if(isset($_SESSION['name'])!= '') {
                echo '<ul class="nav navbar-nav navbar-right"><li><p class="navbar-text">Welcome, '.$_SESSION['name'].' | <a href="logout.php?logout">Logout</a></p></li></ul>';
            }
            else {
                echo '
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown" id="menuLogin">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Login</a>
                        <div class="dropdown-menu" >
                            <form class="form" method="post" action="login.php">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="pwd" placeholder="Password" required>
                                </div>
                                <button name="submit" type="submit" class="btn btn-primary">Sign In</button>
                                <p><a href="register.php">Register</a></p>
                            </form>

                        </div>
                    </li>
                </ul>
                ';
            }
?>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
