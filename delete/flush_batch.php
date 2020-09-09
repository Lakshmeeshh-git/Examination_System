<?php 
	session_start();
	if(isset($_SESSION["user_name"]) && isset($_SESSION["batch"]))
	{
?>

<?php
    $server="localhost";
    $username="root";
    $password="";
    $batch=$_GET['id'];
    $db=$batch.'_examination';
    $db_connection=mysqli_connect($server,$username,$password,"$db");
?>

<?php
    $query=mysqli_query($db_connection,"DELETE FROM student;");
    $query1=mysqli_query($db_connection,"CALL reset_all_available();");
    $query2=mysqli_query($db_connection,"UPDATE main_examination.batch SET date='NULL',start_time='NULL',end_time='NULL',course='NULL' WHERE batch_no='$batch';");
    if($query==1 && $query1==1)
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
    window.location.href="../select_batch.php";
</script>

<?php
}
else{
	header("Location: ../login.php");
}
?>