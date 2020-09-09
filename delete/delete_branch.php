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
    $db='main_examination';
    $db_connection=mysqli_connect($server,$username,$password,"$db");
?>

<?php
    $branch_code=$_GET['id'];
    $query=mysqli_query($db_connection,"DELETE FROM branch WHERE branch_code='$branch_code';");
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
    window.location.href="../more.php";
</script>

<?php
}
else{
	header("Location: ../login.php");
}
?>