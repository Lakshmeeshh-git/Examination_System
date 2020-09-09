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
<?php
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $branch_sub = test_input($_GET["branch_sub"]);
    $branch_sub=explode('|',$branch_sub);
    $branch=$branch_sub[0];
    $sub_code=$branch_sub[1];
    $rooms_selected_count = test_input($_GET["rooms_selected_count"]);
    $rooms_selected = test_input($_GET["rooms_selected"]);
    $rooms_oe=array();
    $rooms=explode('|',$rooms_selected);
    for($i=0;$i<$rooms_selected_count;$i++) {
        $rooms_oe[$i]=test_input($_GET[$rooms[$i]]);
    }
    for($i=0;$i<$rooms_selected_count;$i++) {
        $student_allocated_count=0;
        $students=mysqli_query($db_connection,"SELECT usn FROM student WHERE branch='$branch' AND sub_code='$sub_code' AND room_no='noroom';");
        if(mysqli_num_rows($students)>=1) {
            $room_availability=mysqli_query($db_connection,"SELECT $rooms_oe[$i]_available FROM room WHERE room_no='$rooms[$i]';");
            $room_availability=mysqli_fetch_array($room_availability);
            while($student=mysqli_fetch_array($students)) {
                if($room_availability[0]<=0) {
                    break;
                }
                $max_seat_no=0;
                if($rooms_oe[$i]=='even') {
                    $max_seat_no=0;
                    $get_oe_max_query=mysqli_query($db_connection,"SELECT MAX(seat_no) FROM student WHERE room_no='$rooms[$i]' AND seat_no%2=0;");
                    $max_seat_no_a=mysqli_fetch_array($get_oe_max_query);
                    $max_seat_no=(int)$max_seat_no_a[0]+2;
                }
                else {
                    $max_seat_no=1;
                    $get_oe_max_query=mysqli_query($db_connection,"SELECT MAX(seat_no) FROM student WHERE room_no='$rooms[$i]' AND seat_no%2!=0;");
                    $max_seat_no_a=mysqli_fetch_array($get_oe_max_query);
                    if($max_seat_no_a[0]!=null) {
                        $max_seat_no=(int)$max_seat_no_a[0]+2;
                    }
                }
                $student_alloted_query=mysqli_query($db_connection,"UPDATE student SET room_no='$rooms[$i]', seat_no='$max_seat_no' WHERE usn='$student[0]';");
                if(!$student_alloted_query) {
                    ?>
                    <script>alert('<?php echo("ERROR-"); ?>');</script>
                    <?php
                }
                else {
                    $update_available=mysqli_query($db_connection,"CALL update_$rooms_oe[$i]_available(1,'$rooms[$i]');");
                    $student_allocated_count=$student_allocated_count+1;
                }
                $room_availability=mysqli_query($db_connection,"SELECT $rooms_oe[$i]_available FROM room WHERE room_no='$rooms[$i]';");
                $room_availability=mysqli_fetch_array($room_availability);
            }
        }
        else {
            ?>
            <script>alert('<?php echo("All Students are alloted"); ?>');</script>
            <?php
        }
        ?>
        <script>alert('<?php echo("$student_allocated_count Students allocated to $rooms[$i]"); ?>');</script>
        <?php
    }
?>
<script>window.location.href="allotment.php";</script>
</head>
<body>
    
</body>
</html>
<?php
mysqli_close($db_connection);
?>

<?php
}
else{
	header("Location: login.php");
}
?>