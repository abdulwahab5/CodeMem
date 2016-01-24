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
                      <li><a href="addStudent.php">Add Student</a></li>
                      <li  class="active"><a href="updatestudent.php">Update Student</a></li>
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
            <h2>Update Student</h2>

            <?php
            mysql_connect("localhost", "root","") or die(mysql_error());
            mysql_select_db("codemem") or die(mysql_error());

            $query = "SELECT id FROM student ORDER BY id";
            $result = mysql_query($query) or die(mysql_error()."[".$query."]");
            ?>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                <form class="form" name="myform"  method="post">
                    <div class="form-group" >
                        <label>Student ID</label>
                        <select class="form-control" name="id" required>
                            <?php
                            while ($row = mysql_fetch_array($result))
                            {
                              echo "<option value='".$row['id']."'>".$row['id']."</option>";
                          }
                          ?>        
                      </select>
                  </div>
                  
                  <?php
                  mysql_connect("localhost", "root","") or die(mysql_error());
                  mysql_select_db("codemem") or die(mysql_error());

                  $query = "SELECT id FROM class ORDER BY id";
                  $result = mysql_query($query) or die(mysql_error()."[".$query."]");
                  ?>
                  <div class="form-group" >
                    <label>Class ID</label>
                    <select class="form-control" name="c_ID" placeholder="Select Class ID" required>
                        <?php
                        while ($row = mysql_fetch_array($result))
                        {
                          echo "<option value='".$row['id']."'>".$row['id']."</option>";
                      }
                      ?>        
                  </select>
              </div>

              <input class="btn btn-primary btn-md" type="submit" name="submit" value="Update">
              <?php
              if(isset($_POST['submit'])){
                $id=$_POST['id'];
                $c_id=$_POST['c_id'];
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
                $sql = "Update student SET class_id='$c_id' WHERE id='id'";

                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
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