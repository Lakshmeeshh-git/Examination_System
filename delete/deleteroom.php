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

<?php
    $room_no=$_GET['id'];
    $query=mysqli_query($db_connection,"DELETE FROM room WHERE room_no='$room_no';");
    $query2=mysqli_query($db_connection,"UPDATE student SET room_no='noroom',seat_no=0 WHERE room_no='$room_no';");
    if($query==1)
    {
?>
        <!DOCTYPE html>
        <html>
        <head>
            
            <script>
                alert("deletion successfull");
            </script>
        </head>
        <body>
            
        </body>
        </html>

<?php    
    }
    mysqli_close($db_connection);
?>
<script>
    window.location.href="../rooms.php";
</script>

<?php
}
else{
	header("Location: ../login.php");
}
?>