<?php
include_once 'connect_db.php';
if(isset($_POST['submit'])){
$username=$_POST['username'];
$password=$_POST['password'];
$result=mysql_query("SELECT id, pass FROM instructor WHERE id='$username' AND pass='$password'");
$row=mysql_fetch_array($result);
if($row>0){
session_start();
$_SESSION['username']=$row[0];
$_SESSION['password']=$row[1];
header("location:http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/panel.html");
}else{
$message="<font color=red>Invalid login Try Again</font>";
echo $message;
}
}
echo <<<LOGIN
<!DOCTYPE html>
<html>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">

    <script src="js/jquery-1.11.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <title>CODEMEM LOGIN</title>

</head>
<body>
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse navbar-inverse-collapse">
        <ul class="nav navbar-nav navbar-right">
            <li><a target="_blank" href="#">Developed by Team CodeMem</a></li>
        </ul>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col-md-4">
            <h1>CODEMEM</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-md-offset-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-lock"></span> Employee Login
                </div>
                <div class="panel-body">
<form method="post" action="index.php" class="form">
            <label for="inputEmail3" class="col-sm-3 control-label">
                                Username</label>
            <p><input type="text" class="form-control" name="username" value="" placeholder="Username"></p>
            <label for="inputPassword3" class="col-sm-3 control-label">
                                Password</label>

        
            <p><input type="password" class="form-control" name="password" value="" placeholder="Password"></p>
                <p class="submit"><input class="btn btn-primary btn-md" type="submit" name="submit" value="Login"></p>
            
      </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script type="application/javascript">
    var url = "{{url()}}";
</script>
</html>

LOGIN;
?>