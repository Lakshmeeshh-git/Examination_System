<?php 
require "PHPExcel-1.8/Classes/PHPExcel/IOFactory.php";
	session_start();
	if(isset($_SESSION["user_name"]) && isset($_SESSION["batch"]))
	{
?>

<?php
    $server="localhost";
    $username="root";
    $password="";
    $batch=$_SESSION["batch"];
    $db=$batch.'_examination';
    $db_connection=mysqli_connect($server,$username,$password,"$db");
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
if(isset($_POST['upload'])) {
    $branch=$_POST['branch'];
    //print_r($_FILES);
    $inputfilename=$_FILES['file']['tmp_name'];
    $exceldata=array();

    try {
        $inputfiletype=PHPExcel_IOFactory::identify($inputfilename);
        $objreader=PHPExcel_IOFACTORY::createReader($inputfiletype);
        $objphpexcel=$objreader->load($inputfilename);
    }
    catch(Exception $e) {
        die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
    }

    $count_inserted=0;

    $sheet=$objphpexcel->getSheet(0);
    $highestrow=$sheet->getHighestRow();
    $highestcolumn=$sheet->getHighestColumn();
    for($row=0;$row<=$highestrow;$row++) {
        $rowdata=$sheet->rangeToArray('A'.$row.':'.$highestcolumn.$row,NULL,TRUE,FALSE);
		if(strlen($rowdata[0][1])==10) {
			$sql="INSERT INTO student(usn,name,sem,branch,sub_code,sub_name) VALUES('".$rowdata[0][1]."','".$rowdata[0][2]."','".$rowdata[0][5]."','".$branch."','".$rowdata[0][3]."','".$rowdata[0][4]."');";
		}
        if(mysqli_query($db_connection,$sql)) {
            //echo('inserted : '.$rowdata[0][1]);
            $count_inserted++;
        }
        else {
        ?>
            <script>
                alert("<?php echo('Error : $sql<br>'.mysqli_error($db_connection).'-->$rowdata[0][1]<br>'); ?>");
            </script>
        <?php
            echo("Error : ".$sql."<br>".mysqli_error($db_connection)."-->".$rowdata[0][1]."<br>");
        }
    }
}

?>
<script>
alert(<?php echo($count_inserted."Students Added"); ?>);
window.location.href="../students.php";
</script>
    
</body>
</html>
<?php
mysqli_close($db_connection);
?>

<?php
header("Location: ../students.php");
}
else{
	header("Location: ../login.php");
}
?>