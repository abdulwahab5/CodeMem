<?php
$assignmentid=$_POST['assignment_id'];
$value=explode("-",$assignmentid);
$assignment_no=$value[0];
$class_id=$value[1];
   mysql_connect("localhost", "root", "") or die(mysql_error());
                                mysql_select_db("codemem") or die(mysql_error());

                                $query = "SELECT * FROM assignment WHERE assignment_no='$assignment_no' AND class_id='$class_id'";
                                $result = mysql_query($query) or die(mysql_error() . "[" . $query . "]");
                                 while ($row = mysql_fetch_array($result))
                            {
                            	$due_date=$row['due_date'];
                            	$upload_date=$row['upload_date'];
                            	$assignment_path=$row['assignment_path'];
                          }
                          $myfile = fopen($assignment_path, "r") or die("Unable to open file!");
$code= fread($myfile,filesize($assignment_path));
fclose($myfile);
echo $code;
?>