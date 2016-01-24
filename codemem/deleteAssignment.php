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
                <li><a href="addStudent.php">Manage Students</a></li>
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
                    <li><a href="upload.php">Upload Assignment</a></li>
                    <li><a href="updateAssignment.php">Update Assignment</a></li>
                    <li class="active"><a href="deleteAssignment.php">Delete Assignment</a></li>
                    <li><a href="viewAssignments.php">View Assignment</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>
</div>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="jumbotron">
            <div class="container">
                <h2>Delete Assignment</h2>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-5">
                    <form class="form" method="post" action="deleteAssignment.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Select Assignment</label>
                            <div class="row">
                             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                             
                            <select class="form-control" name="class_id" id="class">
                                <?php
                                mysql_connect("localhost", "root", "") or die(mysql_error());
                                mysql_select_db("codemem") or die(mysql_error());

                                $query = "SELECT assignment_no,class_id FROM assignment ORDER BY id";
                                $result = mysql_query($query) or die(mysql_error() . "[" . $query . "]");
                                 while ($row = mysql_fetch_array($result))
                            {
                              echo "<option value='".$row['assignment_no']."-".$row['class_id']."'>".$row['assignment_no']."-".$row['class_id']."</option>";
                          }
                                ?>
                            </select>
                        </div>
                        </div>
                        </div>
          
                  <input class="btn btn-primary btn-md" type="submit" name="submit" value="Delete">
                  <?php
                  if(isset($_POST['submit'])){
                    $id=$_POST['class_id'];
                    $value=explode("-",$id);
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
                    $sql = "Delete from assignment where assignment_no='$value[0]' AND class_id='$value[1]'";

                    if ($conn->query($sql) === TRUE) {
                        echo "<br>Record deleted successfully";
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