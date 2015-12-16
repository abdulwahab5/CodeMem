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
                    <li class="active"><a href="viewclass.php">View by Class</a></li>
                    <li><a href="viewByassignment.php">View By Assignment</a></li>
                    <li><a href="viewByStudent.php">View By Student</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>
</div>


<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
    <div class="jumbotron">
        <div class="container">
            <h2>View Grade</h2>
            <?php
            mysql_connect("localhost", "root","") or die(mysql_error());
            mysql_select_db("codemem") or die(mysql_error());

            $query = "SELECT id FROM class ORDER BY id";
            $result = mysql_query($query) or die(mysql_error()."[".$query."]");
            ?>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2">
                <form class="form" method="post" action="#">
                    <div class="form-group">
                        <label>Class Name</label>

                        <select class="form-control" name="class_id">
                            <option> </option>
                            <?php 

                            while ($row = mysql_fetch_array($result))
                            {
                              echo "<option value='".$row['id']."'>".$row['id']."</option>";
                          }
                          ?>        
                      </select>
                  </div>
                  <input class="btn btn-primary btn-md" type="submit" value="Show" name="submit">
              </form>
          </div>
          <div class="clearfix"></div>
          <table class="table table-stripped">
            <tr><th>Student ID</th><th>Assignment_no</th><th>Marks</th><th>Class ID</th></tr>
            <?php
            if(isset($_POST['submit'])){
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "codemem";
                $id=$_POST['class_id'];

// Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                $sql = "SELECT grades.student_id, assignment.assignment_no, grades.marks,assignment.class_id
                FROM grades,assignment WHERE grades.assignment_id=assignment.id AND assignment.class_id='$id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    
    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["student_id"]."</td><td>".$row["marks"]."</td><td>".$row["assignment_no"]."</td><td>".$row["class_id"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                $conn->close();
            }
            ?>            </div>
        </div>
    </div>
</div>
</body>
</html>