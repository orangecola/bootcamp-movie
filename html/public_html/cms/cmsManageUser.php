<?php 
    // Declare some variable for error message
    $error=false;
    $errorUName=null;
    $errorUPassword=null;
    $errorURole=null;
    $errorCUPassword=null;
    $errorCUDPassword=null;
    $errorUEmail = null;
    
    //echo '<script type="text/javascript">alert ("' . $_POST['fname'] . '")</script>';
    //Check if submit button is being pressed a not
    if (isset($_POST["submit"]))
    {
        $userName = trim($_POST['userName']);
        $userPassword = trim($_POST['userPassword']);
        $userRole = trim($_POST['userrole']);
        $userCPassword = trim($_POST['userCPassword']);
        $userEmail = trim($_POST['userEmail']);
        
        
        //Special Characters
        $illegal = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';
        
        if (empty($userName))
        {
            $errorUName = "Please enter User Name";
            $error = true;
        }
        
        if (!empty($userPassword) && empty($userCPassword))
        {
            $errorCUPassword = "Please enter Confirm Password";
            $error = true;
        }
        
        if (empty($userPassword) && !empty($userCPassword))
        {
            $errorUPassword = "Please enter Password";
            $error = true;
        }
        
        if (empty($userEmail))
        {
            $errorUEmail = "Please enter User Email";
            $error = true;
        }
        
        if ($_POST['userrole']=='--Please Select--')
        {
            $errorURole = "Please select at least one user role";
            $error = true;
        }
                
        //Check if string contain special Charcters Cinema Name
        if (preg_match($illegal, $userName)) {
            $errorUName = "Special character is not allowed in User name";
            $error = true;
        }
        
        //Check if string contain special Charcters Cinema Name
        if (preg_match($illegal, $userPassword)) {
            $errorUPassword = "Special character is not allowed in Password";
            $error = true;
        }
        
        if ($userPassword != $userCPassword)
        {
            $errorCUDPassword = "Confirm Password and Password are different";
            $error = true;
        }
        
        //Filter vaildate email is check email format
        if (!$_POST['userEmail'] || !filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL))
        {
            $errorUEmail = "Please enter a vaild email";
            $error = true;
        }
        
        
        if ($error == false) 
        {
            include_once ("../dbconnect.php");
            $uname = mysql_real_escape_string($_POST['userName']);
            if (empty($userPassword) && empty($userCPassword))
            {
                $uname = mysql_real_escape_string($_POST['userName']);   
                $upass = md5(mysql_real_escape_string($_POST['userCPassword']));
                $sql_query=$MySQLiconn->query("Update user_list set username='$uname', user_role='$_POST[userrole]', user_email='$_POST[userEmail]' where user_id =".$_GET['update_id']);
                mysql_query($sql_query);
    
                echo '<script language="javascript">';
                echo 'alert("Successfully Updated User"); location.href="cmsManageUser.php"';
                echo '</script>';
            }
            if (!empty($userPassword) && !empty($userCPassword))
            {
                $uname = mysql_real_escape_string($_POST['userName']);   
                $upass = md5(mysql_real_escape_string($_POST['userCPassword']));
                $sql_query=$MySQLiconn->query("Update user_list set username='$uname', user_password='$upass', user_role='$_POST[userrole]', user_email='$_POST[userEmail]' where user_id =".$_GET['update_id']);
                mysql_query($sql_query);
    
                echo '<script language="javascript">';
                echo 'alert("Successfully Updated User"); location.href="cmsManageUser.php"';
                echo '</script>';
            }
        }
    }
    
    elseif (isset($_POST["cancel"]))
    {
        header("Location: cmsManageUser.php");
    }
?>
<html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CMS Manage User</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../images/gv32x32.ico" rel="shortcut icon" />
        
        <script type="text/javascript">
            function delete_id(id)
            {
                if(confirm('Are you sure you want to delete this record ?'))
                {
                    window.location.href='cmsManageUser.php?delete_id='+id;
                }
            }
            
            function update_id(id)
            {
                document.getElementById("UserEditForm").style.display="block";
                window.location.href='cmsManageUser.php?update_id='+id;
            }
            
            function onload()
            {
                
                if (window.location.href.indexOf("update_id") > -1)
                {
                   document.getElementById("UserEditForm").style.display="block";
                }
                else 
                {
                    document.getElementById("UserEditForm").style.display="none";
                }
            }
            
        </script>
        
    </head>
    
    <body onload="onload()">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/scripts.js"></script>
        <?php
            session_start();
            if(!isset($_SESSION['user']))
            {
                header("Location: index.php");
            }
            include_once ("../dbconnect.php");
            $reclimit = 5; //Set Record Limit
     
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 1;
            }
 
            //Setting the page limit
            $start = (($page-1) * $reclimit);
            $sql = "SELECT * FROM user_list";
            $records = $MySQLiconn->query($sql);
            $total = $records->num_rows; //Display Num of Row
            $tpages = ceil($total / $reclimit);
            
            echo '<script language="javascript">';
            echo 'document.getElementById("UserEditForm").style.display="none"';
            echo '</script>';
            
            $rec = "SELECT user_id, username, user_email, user_role FROM user_list LIMIT $start, $reclimit";
            $records = $MySQLiconn->query($rec);
            
            //execute the SQL query and return records
            $resultUser = $MySQLiconn->query("SELECT * FROM user_list WHERE user_id=".$_SESSION['user']);
            $userRow = $resultUser->fetch_array();
            $resultCount = $MySQLiconn->query("select count(*) from user_list");   
            
            if(isset($_GET['delete_id']))
            {
                $sql_query=$MySQLiconn->query("DELETE FROM user_list WHERE user_id=".$_GET['delete_id']);
                mysql_query($sql_query);
                header("Location: cmsManageUser.php");
            }
            
            if(isset($_GET['update_id']))
            {
                echo '<script language="javascript">';
                echo 'document.getElementById("UserEditForm").style.display="block"';
                echo '</script>';

                $rec2 = "SELECT username, user_email, user_role from user_list where user_id =".$_GET['update_id'];
                $records2 = $MySQLiconn->query($rec2);
            }
        ?>
        
        <?php include 'cmsheader.inc';?>
        
        <h1>Cinema Page</h1>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <form method="post">
                    <table border="2" class="summary">
                        <thead>
                            <tr>
                                <th class="col-md-1"><h4>Action</h4></th>
                                <!-- <th class="col-md-2"><h4>Cinema ID</h4></th> -->
                                <th class="col-md-3"><h4>User Name</h4></th>
                                <th class="col-md-2"><h4>User Email</h4></th>
                                <th class="col-md-3"><h4>User Role</h4></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                                $row2 = mysqli_fetch_row($resultCount);
                                $num = $row2[0];
                            
                                if ($num == 0)
                                {
                                    echo 
                                    "<tr><td colspan='8'><p class='centerText'>No Result to display</p></td></tr>";
                                }
                                else 
                                {
                                    while($row = $records->fetch_array())
                                    {
                            ?>                 
                                        <tr class='success'>
                                            <td class='col-md-1'><a href='javascript:delete_id(<?php echo $row[0]; ?>)'>Delete</a><br /><br /><a href='javascript:update_id(<?php echo $row[0]; ?>)'>Update</a></td>
                                            <!-- <td class='col-md-2'><p><?php echo $row[0]; ?></p></td> Cinema ID -->
                                            <td class='col-md-3'><p><?php echo $row[1]; ?></p></td> <!-- Cinema Name -->
                                            <td class='col-md-2'><p><?php echo $row[2]; ?></p></td> <!-- Num Of Screen -->
                                            <td class='col-md-3'><p><?php echo $row[3]; ?></p></td> <!-- Cinema Address -->
                                        </tr>
                                    <?php
                                    }
                                }
                            ?>
                                
                            <tr>
                                <td colspan='10'>
                                    <!-- <button type="submit" name="delete" class="btn btn-primary" <?php if ($num <= 1) echo 'disabled="disabled"' ?>>delete</button> -->
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus-sign yellow">Add</span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            
            <!-- modal contact form -->
            <div id="myModal" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn btn-primary buttonTopClose" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title custom_align" id="Heading">Add New Users</h4>
                        </div>

                        <div class="modal-body">
                            <?php include("cmsAddUser.php");?>
                        </div> 
                    </div> <!-- /.modal-content --> 
                </div> <!-- /.modal-dialog --> 
            </div>
                
            <ul class="pagination">
            <?php
                for($i=1;$i<=$tpages;$i++) 
                {
                    echo "<li><a href=cmsManageUser.php?page=".$i.">".$i."</a></li>";
                }
            ?>
            </ul>
            
            <div><?php include 'cmsfooter.inc';?></div>
            
            <div class="col-md-12 col-sm-12">
                <form name="UserEditForm" id="UserEditForm" class="form-inline" enctype="multipart/form-data" method="POST">
                    <?php
                        while($row = $records2->fetch_array())
                        {
                    ?>
                    
                        <p>**NOTE: Updating an empty password will result in updating everything without password</p>
                        <div>
                            <?php if ($error) {echo "<p class='text-danger'>$errorUEmail</p>";} else echo "<p class='text-danger'></p>"?>
                            <?php if ($error) {echo "<p class='text-danger'>$errorUName</p>";} else echo "<p class='text-danger'></p>"?>
                            <?php if ($error) {echo "<p class='text-danger'>$errorURole</p>";} else echo "<p class='text-danger'></p>"?>
                            <?php if ($error) {echo "<p class='text-danger'>$errorCUDPassword</p>";} else echo "<p class='text-danger'></p>"?>
                        </div>
                    
                        <div class="form-group">
                        <p for="name">User Name: </p>
                        <input type="text" name="userName" class="form-control" id="userName" placeholder="Enter User Name"
                            value="<?php echo $row[0]; ?>">
                            
                    </div>
                    
                    <div class="form-group">
                        <p for="name">User Email: </p>
                        <input type="text" name="userEmail" class="form-control" id="userEmail" placeholder="Enter User Email"
                            value="<?php echo $row[1]; ?>">
                    </div>
                                    
                    <div class="form-group">
                        <p for="name">User Password: </p>
                        <input type="password" name="userPassword" class="form-control" id="userPassword" placeholder="Enter User Password"
                            value="<?php if ($error) echo $userPassword; ?>">
                    </div>
                    
                    <div class="form-group">
                        <p for="name">User Confirm Password: </p>
                        <input type="password" name="userCPassword" class="form-control" id="userCPassword" placeholder="Enter User Confirm Password"
                            value="<?php if ($error) echo $userCPassword; ?>">
                    </div>
                    
                    <div class="form-group">
                        <p for="name">User Role: </p>
                        
                        <?php
                            // Set a variable of the pre-selected option.  This can come from a database or a form submission, etc.
                            $item = '--Please Select--';
 
                            // Create the array of role
                            $userrole = array('--Please Select--', 'User', 'Admin');
 
                            //Now echo out a select tag and make sure to give it a name
                            echo '<select name="userrole" class="form-control">';
 
                            //Now we use a foreach loop and build the option tags
                            foreach($userrole as $r)
                            {
                                $sel= 'User'; // Set $sel to empty initially
                                $tag = 'selected="selected"';
                                $_POST['userrole'] = $row[2];
                                if(isset($_POST['userrole']) && $_POST['userrole'] == $r) // Here we check if the form has been posted so an error isn't thrown and then check it's value against $c
                                { 
                                    $sel = $tag; 
                                }
                                elseif(!isset($_POST['userrole']) && $item == $r) // So that the $item doesn't override the posted value we need to check to make sure the form has NOT been submitted also in the elseif()
                                { 
                                    $sel = $tag; 
                                }
	
                                echo '<option value="'.$r.'" '.$sel.'>'.$r.'</option>';
                            }   
                            //Echo the closing select tag
                            echo '</select>';
                        ?>
                        
                    </div>
                         
                    <?php
                        }
                    ?>
                    <br /><br />
                    <hr />
                    <div class="form-group">
                        <p>**NOTE: For security reason purpose, All data will be revel back once you click submit</p>
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <button type='cancel' name='cancel' class='btn btn-primary'>Cancel</button>
                    </div>
                </form>
            </div>
            
    </div>
       
</body>
</html>