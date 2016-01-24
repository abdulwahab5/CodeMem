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
                    <li><a href="upload.php">Upload Assignment</a></li>
                    <li class="active"><a href="updateAssignment.php">Update Assignment</a></li>
                    <li><a href="deleteAssignment.php">Delete Assignment</a></li>
                    <li><a href="viewAssignments.php">View Assignment</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>
</div>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <div class="jumbotron">
            <div class="container">
                <h2>Update Assignment</h2>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <form class="form" method="post" action="updateAssignment.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Assignment to be updated</label>
                             <div class="row">
                             <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            
                            <select class="form-control" name="class_id" id="assignment_id" required>
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
                        <input class="btn btn-primary btn-md" type="submit" name="search" value="Search" id="search">
           
                        
                                     
                        
                        <div class="form-group">
                            <label>Write Code</label>
                            <style type="text/css">
                                #editor {
                                    width: 600px;
                                    height: 300px;
                                }
                            </style>
<pre id="editor">#include &lt;iostream&gt;
        using namespace std;
        int main()
        {
        cout<<"Hello World";
         return 0;
        }
</pre>

                            <script src="src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
                            <script>
                                var editor = ace.edit("editor");
                                editor.setTheme("ace/theme/tomorrow_night_bright");
                                editor.session.setMode("ace/mode/c_cpp");
                                var file = editor.getValue();

                            </script>
                        </div>
                            <div class="form-group">
                            <label>Select Class</label>
                             <div class="row">
                             <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <select class="form-control" name="class_id" id="class_id">
                                <?php
                                mysql_connect("localhost", "root", "") or die(mysql_error());
                                mysql_select_db("codemem") or die(mysql_error());

                                $query = "SELECT id FROM class ORDER BY id";
                                $result = mysql_query($query) or die(mysql_error() . "[" . $query . "]");
                                while ($row = mysql_fetch_array($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                                }
                                ?>
                            </select>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Assignment Name</label>
                            <input class="form-control" placeholder="Enter Assignment name"
                                   name="assignment_no" id="assignment" required>
                        </div>
                        <div class="form-group">
                            <label>Select Due Date</label>
                       <input type="date" id="datepicker" class="form-control" placeholder="Format YYYY-MM-DD" name="due_date" min=<?php echo date("Y-m-d");?> required>
</div>
                        
                        <div class="form-group">
                            <label>Browse</label>
                            <input type="file" class="form-control" name="file" id="file">
                        </div>
                        <input class="btn btn-primary btn-md" type="submit" name="submit">
                    
                       </form>
                </div>
                                <script type="application/javascript">
     $( "#search" ).click(function() {
                       var fd = new FormData();
                        fd.append('assignment_id', $("#assignment_id").val())
                        event.preventDefault();
                        $.ajax({
                            url: 'process2.php',
                            type: 'POST',
                            data: {
                                assignment_id: $("#assignment_id").val(),
                                
                            },
                            success: function(res){
                                editor.setValue(res);
                            },

                        });

                    });

                </script>

                <script type="text/javascript">
                    var code;
                    function readSingleFile(evt) {
                        //Retrieve the first (and only!) File from the FileList object
                        var f = evt.target.files[0];

                        if (f) {
                            var r = new FileReader();
                            r.onload = function(e) {
                                var contents = e.target.result;
                                editor.setValue(contents.substr(1,contents.length));
                            }
                            r.readAsText(f);
                        } else {
                            alert("Failed to load file");
                        }
                    }
                    document.getElementById('file').addEventListener('change', readSingleFile, false);
                </script>
                 <script type="application/javascript">
                    $('form').submit(function (event) {
                        var fd = new FormData();
                        fd.append('assignment_id', $("#assignment_id").val());
                        fd.append('class_id', $("#class_id").val())
                        code = editor.getValue();
                        event.preventDefault();
                        $.ajax({
                            url: 'process1.php',
                            type: 'POST',
                            data: {
                                assignment_id: $('#assignment_id').val(),
                                class_id: $("#class_id").val(),
                                assignment: $("#assignment").val(),
                                date: $("#datepicker").val(),
                                code: code,

                            },
                            success: function(res){
                                alert(res);
                                
                            },

                        });

                    });

                </script>
               

            </div>
        </div>
    </div>
</div>
</body>
</html>