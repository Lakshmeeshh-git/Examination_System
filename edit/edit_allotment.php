<?php 
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
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if(isset($_GET['deallote'])) {
    $rooms_selected_count = test_input($_GET["rooms_selected_count"]);
    $rooms_selected = test_input($_GET["rooms_selected"]);
    $rooms=explode('|',$rooms_selected);

    for($i=0;$i<$rooms_selected_count;$i++) {
        $student_alloted_count_query=mysqli_query($db_connection,"SELECT COUNT(usn) FROM student WHERE room_no='$rooms[$i]';");
        $student_alloted_count=mysqli_fetch_array($student_alloted_count_query);
        $student_dealloted_query=mysqli_query($db_connection,"UPDATE student SET room_no='noroom',seat_no=0 WHERE room_no='$rooms[$i]'");

        if(!$student_dealloted_query) {
    ?>
            <script>
                alert("<?php echo('Error : '.mysqli_error($db_connection)); ?>");
            </script>
    <?php
        }
        else {
            $update_available=mysqli_query($db_connection,"CALL reset_available('$rooms[$i]');");
    ?>
            <script>
                alert("<?php echo($student_alloted_count[0].' Students Deallocated From '.$rooms[$i]); ?>");
            </script>
    <?php

        }
    }
}
if(isset($_GET['deallote_all'])) {
    $student_alloted_count_query=mysqli_query($db_connection,"SELECT COUNT(usn) FROM student WHERE room_no NOT IN ('noroom');");
    $student_alloted_count=mysqli_fetch_array($student_alloted_count_query);
    $student_dealloted_query=mysqli_query($db_connection,"UPDATE student SET room_no='noroom',seat_no=0;");
    $update_available=mysqli_query($db_connection,"CALL reset_all_available();");
    if(!$student_dealloted_query) {
    ?>
        <script>
            alert("<?php echo('Error : '.mysqli_error($db_connection)); ?>");
        </script>
    <?php
    }
    else {
    ?>
        <script>
            alert("<?php echo($student_alloted_count[0].' Students Deallocated'); ?>");
        </script>
    <?php

    }
}

mysqli_close($db_connection);
?>
<script>window.location.href="../students.php";</script>
    
</body>
</html>
<?php
}
else{
	header("Location: login.php");
}