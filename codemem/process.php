<?php
require "SphereEngineAPI.php";
    $SE1 = new SphereEngineAPI('852887ecd7907d011b467a7c8514f549',"http://api.compilers.sphere-engine.com/api/3/");
    $submit = $SE1->compilers->sendSubmission($_POST['code'],'44');
    
    $check = $SE1->compilers->getSubmission($submit['id']);
    while($check['status']!=0)
    {
    $check = $SE1->compilers->getSubmission($submit['id']);
    }
    if($check['result']==15){
    
$class_id = $_POST['class_id'];
                    $assignment_no = $_POST['assignment'];
                    $due_date = $_POST['date'];
                    $code= $_POST['code'];
                    $target_dir = "uploads/";
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "codemem";
                    $file_name=$assignment_no."-".$class_id.".txt";
                    $assignment_path=$target_dir.$file_name;
                    $solution_path="symbolTables/".$file_name;
                    $JAVA_HOME = "C:\Program Files\Java\jdk1.8.0_60";
        
                    $myfile = fopen($assignment_path, "w") or die("Unable to open file!");
                    fwrite($myfile, $code);
                    fclose($myfile);
        $PATH = "C:\Program Files\Java\jdk1.8.0_60\bin";
        
        putenv("JAVA_HOME=$JAVA_HOME");
        putenv("PATH=$PATH");
        
        // Show The Java Version After Setting Environmental Variable
        
        $output = shell_exec("java -jar symbolTable.jar ".$file_name." ".$file_name." 2>&1");
        

                            $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $sql = "INSERT INTO assignment (id,assignment_no,due_date,upload_date,assignment_path,solution_path,class_id) VALUES (NULL,'$assignment_no','$due_date',CURDATE(),'$assignment_path','$solution_path','$class_id')";

                            if ($conn->query($sql) === TRUE) {
                                echo "Record added successfully";
                            }
                            else {
                                echo "Error updating record: " . $conn->error;
                            }

                            $conn->close();
}
else
{
    if($check['result']==11){
    echo "compilation error – the program could not be executed due to compilation error";
}
   elseif($check['result']==12){
    echo "runtime error – the program finished because of the runtime error, for example: division by zero, array index out of bounds, uncaught exception";
}
  elseif($check['result']==13){
    echo "time limit exceeded – the program didn't stop before the time limit";
}
  elseif($check['result']==17){
    echo "memory limit exceeded – the program tried to use more memory than it is allowed to";
}
elseif ($check['result']==19) {
    echo "illegal system call – the program tried to call illegal system function";
}

elseif ($check['result']==20) {
    echo "internal error – some problem occurred on Sphere Engine; try to submit the program again and if that fails too, then please contact us";
}
 }                        
?>