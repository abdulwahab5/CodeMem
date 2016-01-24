<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="js/jquery-1.11.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/highlight.min.js"></script>

    <title>Change Password</title>
</head>
<body>
    <div class="header">
        <h2>Instructor Panel</h2>
    </div>
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 side-bar">
            <div class="logo">
                <img class="img-responsive" src="img/logo.png"/>
            </div>
            <ul class="sidebar-nav">
                <li><a href="panel.html">Home</a></li>
                <li><a href="addclass.php">Manage Classes</a></li>
                <li><a href="addstudent.php">Manage Students</a></li>
                <li><a href="upload.php">Upload Assignment</a></li>
                <li><a href="viewclass.php">View Grades</a></li>
                <li><a href="changepassword.php">Change Password</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <div class="jumbotron">
                <div class="container">
                    <h2>Change Password</h2>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <form class="form" method="post" action="changepassword.php">
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="text" class="form-control" placeholder="Current Password" name="curr" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input id="text" class="form-control" placeholder="New Password" name="new" required>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="text" class="form-control" placeholder="Confirm Password" name="c_new" required>
                            </div>

                            <input class="btn btn-primary btn-md" type="submit" value="Change Password" name="change" id="change">
                                                    <?php
                        if(isset($_POST['change'])){                       
                        session_start();
                        $teacher_id = $_SESSION['username'];
                        $old=$_SESSION['password'];
                        $curr=$_POST['curr'];
                        $new=$_POST['new'];
                        $c_new=$_POST['c_new'];
                        if($old==$curr)
                        {
                            if($new==$c_new){
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "codemem";

// Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            } 
                            $sql = "UPDATE instructor SET pass='$new' WHERE id='$teacher_id'";

                            if ($conn->query($sql) === TRUE) {
                                echo "Password changed successfully";
                                $_SESSION['password']=$new;
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();    
                            }
                            else
                            {
                                echo "<font color=red><br>New password and Confirm password do not match</font>";
                            }}
                            else{
                                echo "<font color=red>Invalid current password Try Again</font>";
                            }

                            }
                        
                        ?>




                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>