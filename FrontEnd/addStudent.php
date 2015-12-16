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

    <title>Instructor Panel</title>
</head>
<body>
    <div class="header">
        <h1>Instructor Panel</h1>
    </div>
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 side-bar">
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
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div>
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="addStudent.php">Add Student</a></li>
                            <li><a href="updateStudent.php">Update Student</a></li>
                            <li><a href="deleteStudent.php">Delete Student</a></li>
                            <li><a href="viewStudent.php">View Students</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <div class="jumbotron">
                <div class="container">
                    <h2>Add New Student</h2>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                        <form class="form" name="myform" method="post">
                            <div class="form-group">
                                <label>Student ID</label>
                                <input type="text" class="form-control" placeholder="Enter Student's NU id" name="name">
                            </div>
                            <div class="form-group">
                                <label>Class ID</label>

                                <select class="form-control" name="class_id" id="class_id">
                                   <option> </option>
                                   <?php
                                   mysql_connect("localhost", "root","") or die(mysql_error());
                                   mysql_select_db("codemem") or die(mysql_error());

                                   $query = "SELECT id FROM class ORDER BY id";   
                                   $result = mysql_query($query) or die(mysql_error()."[".$query."]");
                                   while ($row = mysql_fetch_array($result))
                                   {
                                    echo "<option value='".$row['id']."'>".$row['id']."</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <input class="btn btn-primary btn-md" type="submit" name="submit" value="Add">
                        <?php

                        if(isset($_POST['submit'])){
                            $name=$_POST['name'];
                            $class_id=$_POST['class_id'];
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
                            $sql = "INSERT INTO student (id,class_id) VALUES ('$name','$class_id')";

                            if ($conn->query($sql) === TRUE) {
                                echo "Record added successfully";
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();
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