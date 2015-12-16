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
        <li  class="active"><a href="updateClass.php">Update Class</a></li>
        <li><a href="deleteClass.php">Delete Class</a></li>
        <li><a href="viewClasses.php">View Classes</a></li>
      
      </ul>
    </div>
  </div>
</nav>
</div>

    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="jumbotron">
            <div class="container">
                <h2>Update Class</h2>

<?php
mysql_connect("localhost", "root","") or die(mysql_error());
mysql_select_db("codemem") or die(mysql_error());

$query = "SELECT id FROM class ORDER BY id";
$result = mysql_query($query) or die(mysql_error()."[".$query."]");
?>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-2">
                    <form class="form" name="myform" action="updateClass.php" method="post">
                        <div class="form-group" >
                            <label>Class ID</label>
<select class="form-control" name="c_ID" >
<?php
while ($row = mysql_fetch_array($result))
{
  echo "<option value='".$row['id']."'>".$row['id']."</option>";
}
?>        
</select>
                        </div>
                                   <div class="form-group">
                                <label>BATCH</label>
                                <select class="form-control" name="batch" id="batch">
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                                <option>16</option>
                                </select>
                                <label>SECTION</label>
                                <select class="form-control" name="section" id="section">
                                <option>A</option>
                                <option>B</option>
                                <option>C</option>
                                <option>D</option>
                                </select>
                        </div>
                        <input class="btn btn-primary btn-md" type="submit" name="submit" value="Update">
                        <?php
                        if(isset($_POST['submit'])){                       
                        session_start();
                        $teacher_id = $_SESSION['username'];
                            $p_class_id=$_POST['c_ID'];
                            $batch=$_POST['batch'];
                            $section=$_POST['section'];
                            $class_id=$batch.$section;
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
                            $sql = "UPDATE class SET id='$class_id' WHERE id='$p_class_id'";

                            if ($conn->query($sql) === TRUE) {
                                echo "<br>Record updated successfully";
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