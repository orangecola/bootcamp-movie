
		<?php
		session_start();
		include_once '../dbconnect.php';
		$resultUser = $MySQLiconn->query("SELECT * FROM user_list WHERE user_id=".$_SESSION['user']);
		$userRow = $resultUser->fetch_array();
		include 'cmsheader.inc';
		?>
    <!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    -->
    <html>
        <head>
            <meta charset="UTF-8">
            <title>CMS Main</title>
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <link href="../css/style.css" rel="stylesheet">
            <link href="../images/gv32x32.ico" rel="shortcut icon" />


        </head>
        <body>
            <script src="../js/jquery.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/scripts.js"></script>
        <h1>Promotion Information Page</h1>
        <div class="promotiontable">
            <?php

            if (isset($_GET['id'])) {
                $delsql = "DELETE FROM promotioninfo WHERE promotionInfo_id=" . $_GET['id'] . "";
                $delresult = $MySQLiconn->query($delsql);
                $deletesql = "DELETE FROM promotion WHERE promotionInfo_id=" . $_GET['id'] . "";
                $deleteresult = $MySQLiconn->query($deletesql);
            };

            if (isset($_GET['page'])) {
                $page = $_GET['page'] - 1;

                $sql = "SELECT * FROM promotioninfo limit 15 offset $page  ";
                $result = $MySQLiconn->query($sql);
                echo"</br><table border='2' class='summary' align='right'><tr><th><h4>Action</h4></th><th><h4>Promotion Name</h4></th><th><h4>Promotion Detail</h4></th><th><h4>Promotion Image</h4></th></tr><tr class='success'>";
                $row = mysqli_fetch_array($result);
                echo "<td>";
                ?> <a onClick="return confirm('Are you sure you wish to delete this entry ?')"
                <?php
                echo"href='cmspromo.php?id=" . $row['0'] . "' >Delete</a></br></br><a href='cmspprocess.php?id=" . $row['0'] . "'>Update</a></td>"
                . "<td><p>" . $row['1'] . "</p></td>"
                . "<td><p>" . $row['3'] . "</p></td>"
                . "<td><img src='data:image/jpeg;base64," . base64_encode($row['2']) . "'></td>"
                ?>

                   <?php
                   echo"</td></tr><tr><td colspan='4'><a class='btn btn-primary' data-toggle='modal' data-target='#myModal'>Add New Promotion</a></td></tr>";

            echo "</table>"
                   ?>
                   <div class="container">


                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn btn-primary buttonTopClose" data-dismiss="modal" aria-hidden="true">X</button><!-- Makes the X -->
                                        <h4 class="modal-title">Add New Promotion</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                        <form method="POST" action="cmspprocess.php" enctype="multipart/form-data">
                                            <span style="margin-bottom:0; color: white; margin-right: 1%">Promotion Name :</span>
                                            </br>
                                            <input type='text' name='pname' style='width: 500px;' class='input'>
                                            </br>
                                            <span style="margin-bottom:0; color: white; margin-right: 1%">Image :</span>
                                            </br>
                                            <input type="file" name="ppict" id="ppict">
                                            </br>
                                            <span style="margin-bottom:0; color: white; margin-right: 1%">Promotion Description :</span>
                                            </br>
                                            <textarea name='pdesc' class='input' cols="75" rows='10'></textarea>
                                            </br>

                                            </br>

                                            <span style="margin-bottom:0; color: white; margin-right: 1%">Cinema Affected :</span>
                                            </br>
                                            <?php
                                            include_once '../dbconnect.php';
                                            $sql = "SELECT COUNT(*) FROM cinema";
                                            $result = $MySQLiconn->query($sql);
                                            $row = mysqli_fetch_array($result);

                                            $sqlc = "select * from cinema";
                                            $resultc = $MySQLiconn->query($sqlc);




                                            for ($x = 1; $x <= $row['0']; $x++) {
                                                $rowc = mysqli_fetch_array($resultc);
                                                echo"<input type='checkbox' name='cinema[]' value='" . $rowc['0'] . "'> " .'<span style="margin-bottom:0; color: white; margin-right: 1%">'. $rowc['1'] . "</span><br />";
                                            }


                                            ;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type='submit' value='Submit' class='btn btn-default'><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <ul class="pagination pagination-lg">
                    <?php
                    }

                    else{


                $sql = "SELECT * FROM promotioninfo limit 15 offset 0  ";
                $result = $MySQLiconn->query($sql);
                echo"</br><table border='2' class='summary' align='right'><tr><th><h4>Action</h4></th><th><h4>Promotion Name</h4></th><th><h4>Promotion Detail</h4></th><th><h4>Promotion Image</h4></th></tr><tr class='success'>";
                $row = mysqli_fetch_array($result);
                echo "<td>";
                ?> <a onClick="return confirm('Are you sure you wish to delete this entry ?')"
                <?php
                echo"href='cmspromo.php?id=" . $row['0'] . "' >Delete</a></br></br><a href='cmspprocess.php?id=" . $row['0'] . "'>Update</a></td>"
                . "<td><p>" . $row['1'] . "</p></td>"
                . "<td><p>" . $row['3'] . "</p></td>"
                . "<td><img src='data:image/jpeg;base64," . base64_encode($row['2']) . "'></td>"
                ?>

                   <?php
                   echo"</td></tr><tr><td colspan='4'><a class='btn btn-primary' data-toggle='modal' data-target='#myModal'>Add New Promotion</a></td></tr>";

            echo "</table>"
                   ?>
                   <div class="container" style="margin-left:0;">

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn btn-primary buttonTopClose" data-dismiss="modal" aria-hidden="true">X</button><!-- Makes the X -->
                                        <h4 class="modal-title">Add New Promotion</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="cmspprocess.php" enctype="multipart/form-data">
                                            <div class="container">
                                            <p style="margin-bottom:0;">Promotion Name:</p>
                                            <input type='text' name='pname' class="input" class='input'>

                                            <p style="margin-bottom:0;">Image :</p>

                                            <input type="file" name="ppict" id="ppict">

                                            <p style="margin-bottom:0;">Promotion Description :</p>

                                            <textarea name='pdesc' class="input" rows="10" cols="79"></textarea>


                                            </br>

                                            <p style="margin-bottom:0; padding-left:0;">Cinema Affected :</p>
                                            </br>
                                            <?php
                                            include_once '../dbconnect.php';
                                            $sql = "SELECT COUNT(*) FROM cinema";
                                            $result = $MySQLiconn->query($sql);
                                            $row = mysqli_fetch_array($result);

                                            $sqlc = "select * from cinema";
                                            $resultc = $MySQLiconn->query($sqlc);




                                            for ($x = 1; $x <= $row['0']; $x++) {
                                                $rowc = mysqli_fetch_array($resultc);
                                                echo"<input type='checkbox' name='cinema[]' value='" . $rowc['0'] . "'> " .'<span style="margin-bottom:0; color: white; margin-right: 1%">'. $rowc['1'] . "</span><br>";
                                            }


                                            ;
                                            ?>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type='submit' value='Submit' class='btn btn-default'><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>
					</div>
                    <ul class="pagination pagination-lg">
                    <?php
                    }



                    $num_results = "SELECT COUNT(*) FROM promotioninfo";
                    $result = $MySQLiconn->query($num_results);
                    $row = mysqli_fetch_array($result);

                    for ($i = 1; $i <= $row['0']; $i++) {

                        echo"<li><a href='?page=$i'>$i</a></li>";
                    };

                    ?>

                </ul>



                </body>
                </html>
