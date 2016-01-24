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
        <h2>Instructor Panel</h2>
    </div>
    <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 side-bar">
            <div class="logo">
                <img class="img-responsive" src="img/logo.png" />
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
                        <li><a href="addClass.php">Add Class</a></li>
                            <li><a href="updateClass.php">Update Class</a></li>
                            <li><a href="deleteClass.php">Delete Class</a></li>
                            <li class="active"><a href="viewClasses.php">View Classes</a></li>
                        </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="jumbotron">
            <div class="container">
                <h2>View Classes</h2>
                <div class="clearfix"></div>
                <table class="table table-stripped">
                    <tr><th>Class ID</th><th>Instructor ID</th></tr>
                    <?php

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

                    $sql = "SELECT * FROM Class order by id,instructor_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

    // output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>".$row["id"]."</td><td>".$row["instructor_id"]."</td></tr>";
                        }
                        echo "</table>";

                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>                                </div>

                </div>
            </div>
        </div>
    </div>
</body>
</html>