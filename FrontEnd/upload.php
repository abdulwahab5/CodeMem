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
        <div class="jumbotron">
            <div class="container">
                <h1>Upload Assignment</h1>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                    <form class="form" method="post" action="upload.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Select Class</label>
                            <select class="form-control" name="class_id">
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
                        <div class="form-group">
                            <label>Select Assignment Name</label>
                            <input id="text" class="form-control"  placeholder="Enter Assignment name" name="assignment_no">
                        </div>
                        <div class="form-group">
                            <label>Select Due Date</label>
                            <input id="datepicker" class="form-control"  placeholder="Format YYYY-MM-DD" name="due_date">
                        </div>
                        <a id="myLink" name=""></a>
                        <div class="form-group">
                            <label>Write Code</label>
<style type="text/css">
     #editor {
        width: 600px;
        height: 300px;
    }
</style>
<pre id="editor">
    #include<iostream>
using namespace std;
int main()
{
cout<<"Hello World";
}
</pre>

<script src="src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/tomorrow_night_bright");
    editor.session.setMode("ace/mode/c_cpp");
    var file =editor.getValue();
    document.Write(file);
    document.getElementById("myLink").innerHTML=file;
</script>
                    </div>
                        <div class="form-group">
                            <label>Browse</label>
                            <input type="file" class="form-control" name="file" id="file">
                        </div>
                        <input class="btn btn-primary btn-md" type="submit" name="submit">
                    </form>
                </div>
<?php
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
$class_id=$_POST['class_id'];
$assignment_no=$_POST['assignment_no'];
$due_date=$_POST['due_date'];
$target_dir = "uploads/";
 $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "codemem";

$target_file =$target_dir.basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file already exists
if (file_exists($target_file)) {
    echo "<br>Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 500000) {
    echo "<br>Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "cpp"  ) {
    echo "<br>Sorry, only cpp are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<br>Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
 $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }  $sql = "INSERT INTO assignment (id,assignment_no,due_date,upload_date,file,class_id) VALUES (NULL,'$assignment_no','$due_date',CURDATE(),'$target_file','$class_id')";

                            if ($conn->query($sql) === TRUE) {
                                echo "Record added successfully";
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();
    } else {
        echo "<br>Sorry, there was an error uploading your file.";
    }
}
            }
?>
            </div>
        </div>
    </div>
</div>
</body>
</html>