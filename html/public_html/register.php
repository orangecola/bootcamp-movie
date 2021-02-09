<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("Location: index.php");
}
include_once 'dbconnect.php';
$nameErr = $emailErr = $passwordErr = $confirmPwdErr = "";
if (isset($_POST['submit'])) {
    $okay = True;
    if (empty($_POST["name"])) {
        $firstnameErr = "Name is required";
        $okay = False;
    }
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $okay = False;
    }
    if (strlen($_POST["pwd"]) < 8) {
        $pwdErr = "Password must be longer than 8 characters";
        $okay = False;
    }
    if ($_POST["confirmpwd"] != $_POST["pwd"]) {
        $confirmPwdErr = "Passwords must match";
        $okay = False;
    }
    $email = mysqli_real_escape_string($MySQLiconn, $_POST['email']);
    $result = mysqli_query($MySQLiconn, "SELECT COUNT(*) As RegisteredEmail FROM user_list where user_email='".$email."'");
    $row = mysqli_fetch_array($result);
    if ($row['RegisteredEmail' != 0]) {
        $emailErr = "Email Already Registered";
        $okay = False;
    }
    //if (mysqli_query("SELECT COUNT(* "))
    if ($okay) {
        $uname = mysqli_real_escape_string($MySQLiconn, $_POST['name']);
        $upass = md5(mysqli_real_escape_string($MySQLiconn, $_POST['pwd']));
        $hash = md5(rand(0,1000));
        if (mysqli_query($MySQLiconn, "INSERT INTO user_list(username,user_email,password,user_role) VALUES('$uname','$email','$upass','User')")) {
            header("Location: index.php");
        } else {
            ?>
            <script>alert('error while registering you...');</script>
            <?php
        }
    }
}
?>
        <?php include "header.inc" ?>
            <div class="container">
                <div class="row">
                    <h1>Register</h1>
                    <form class="form-horizontal" role ="form" method = "post" action="">
                        <div class="form-group">
                            <label class="control-label col-md-3" for="firstname"><p>Name:</p></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name ="name" >
                                <span class="text-danger"><?php echo $nameErr; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="email" name="email"><p>Email:</p></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="email" required>
                                <span class="text-danger"><?php echo $emailErr; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="pwd" name="pwd"><p>Password:</p></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="pwd" required>
                                <span class="text-danger"><?php echo $passwordErr; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="pwd"><p>Password Confirm:</p></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="confirmpwd">
                                <span class="text-danger"><?php echo $confirmPwdErr; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php include "footer.inc" ?>
    </body>
</html>
