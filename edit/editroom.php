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
$method=$_SERVER['REQUEST_METHOD'];
if($method=='POST' && isset($_POST['editok']))
{
    $room_no=$_POST['room_no'];
    $capacity=$_POST['capacity'];
    $odd_available=$_POST['odd_available'];
    $even_available=$_POST['even_available'];
    $query="UPDATE room SET capacity='$capacity',odd_available='$odd_available',even_available='$even_available' WHERE room_no='$room_no';";
    $result=mysqli_query($db_connection,$query);
    if($result) {
?>
        <script>alert("Edited successfully");window.location.href="../rooms.php";</script>
<?php
    }
    else {
?>
        <script>alert("Editing Failed");</script>
<?php
    }
}
if($method=='GET') {
    $id=$_GET["id"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>
<body>
    <header>
        <div class="header">
            <div class="text-center">
                <h2 style="font-family: 'Times New Roman',Georgia, serif; color:#337ab7;">
                EXAMINATION SYSTEM
                </h2>
            </div>
        </div>
    </header>
    <div class="row">
        <div class="text-center">
            <h3 style="font-family: 'Times New Roman',Georgia, serif; color:#337ab7;">
                EDIT ROOM
            </h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
                <a href="../rooms.php">back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            <form action="#" method="post" class="form-inline">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ROOM NO</th>
                            <th>CAPACITY</th>
                            <th>ODD AVAILABLE</th>
                            <th>EVEN AVAILABLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $value_query=mysqli_query($db_connection,"select * from room where room_no='$id';");
                            while($value=mysqli_fetch_array($value_query))
                            {
                        ?>
                            <tr>
                                <td><input type="text" name="room_no" value="<?php echo($value['room_no']); ?>" class="form-control" readonly></td>
                                <td><input type="number" name="capacity" value="<?php echo($value['capacity']); ?>" class="form-control" required></td>
                                <td><input type="number" name="odd_available" value="<?php echo($value['odd_available']); ?>" class="form-control" required></td>
                                <td><input type="number" name="even_available" value="<?php echo($value['even_available']); ?>" class="form-control" required></td>
                            </tr>
                            <?php
                            }
                            ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-center">
                                <input type="reset" value="CLEAR" class="btn btn-primary">
                                <input type="submit" value="EDIT" name="editok" class="btn btn-primary">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
<?php
}
mysqli_close($db_connection);
?>
<?php
}
else{
	header("Location: ../login.php");
}