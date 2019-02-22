<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CMS Movie</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link href="../images/gv32x32.ico" rel="shortcut icon" />
</head>
<body>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<?php 
session_start();
include_once ("../dbconnect.php");
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <?php include 'cmsheader.inc';?>
            <div class="jumbotron">
                <div class="container">
                    <?php
                    $poster = file_get_contents($_FILES['movie_poster']['tmp_name']);
                    $poster = mysql_real_escape_string($poster);
                    $sql1 = "INSERT INTO movie (movie_name, movie_type, movie_cast, movie_director, movie_genre, movie_release, movie_runningTime, movie_distributor, movie_language, movie_synopsis, movie_TNC, movie_trailerLink, movie_websiteLink, movie_poster, movie_carousel) VALUES ";
                    $sql2 = "('" . $_POST['movie_name'] . "', '" . $_POST['movie_type'] . "', '" 
                        . $_POST['movie_cast'] . "', '" . $_POST['movie_director'] . "', '" 
                        . $_POST['movie_genre'] . "', '" . $_POST['movie_release'] . "', '" 
                        . $_POST['movie_runningTime'] . "', '" . $_POST['movie_distributor'] . "', '" 
                        . $_POST['movie_language'] . "', '" . $_POST['movie_synopsis'] . "', '" 
                        . $_POST['movie_TNC'] . "', '" . $_POST['movie_trailerLink'] . "', '" 
                        . $_POST['movie_websiteLink'] . "', '$poster'";

                    if ($_FILES['movie_carousel']['size'] != 0) {
                        $carousel = file_get_contents($_FILES['movie_carousel']['tmp_name2']);
                        $carousel = mysql_real_escape_string($carousel);
                        $sql3 = ", '$carousel'";
                    }
                    else {
                        $sql3 = ", ''";
                        }

                    $sql4 = ");";

                    $query = $sql1.$sql2.$sql3.$sql4;
                    if ($MySQLiconn->query($query)) {
                        echo "<h1>Added successfully</h1>";   
                    }
                    else {
                        echo "<h1>Failed to add</h1>";
                    }

                    ?>
                    <br />
                    <a href="cmsmovie.php"><button class="btn btn-default">Back</button></a>
                </div>
            </div>
            
            

        <?php include 'cmsfooter.inc';?>    
		</div>
	</div>
</div>

</body>
</html>