<?php 
	session_start();
	if(isset($_SESSION["user_name"]))
	{
?>

<?php
    $server="localhost";
    $username="root";
    $password="";
    $db='main_examination';
    $db_connection=mysqli_connect($server,$username,$password,"$db");
?>

<?php
$method=$_SERVER['REQUEST_METHOD'];
if($method=='POST' && isset($_POST['editok']))
{
    $batch_no=$_POST['batch_no'];
    $date=$_POST['date'];
    $start_time=$_POST['start_time'];
    $end_time=$_POST['end_time'];
    $course=$_POST['course'];
    
    $query="UPDATE batch SET date='$date',start_time='$start_time',end_time='$end_time',course='$course' WHERE batch_no='$batch_no';";
    $result=mysqli_query($db_connection,$query);
    if($result) {
?>
        <script>alert("Edited successfully");window.location.href="../select_batch.php";</script>
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
    <title>Edit Batch</title>
    
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
                EDIT BATCH
            </h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
                <a href="../select_batch.php">back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            <form action="#" method="post" class="form-inline">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>BATCH NUMBER</th>
                            <th>DATE</th>
                            <th>START TIME</th>
                            <th>END TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $value_query=mysqli_query($db_connection,"select * from batch where batch_no='$id';");
                            while($value=mysqli_fetch_array($value_query))
                            {
                        ?>
                            <tr>
                                <td><input type="text" name="batch_no" value="<?php echo($value['batch_no']); ?>" class="form-control" placeholder="USN" readonly></td>
                                <td><input type="text" name="date" value="<?php echo($value['date']); ?>" class="form-control" placeholder="NAME" required></td>
                                <td><input type="text" name="start_time" value="<?php echo($value['start_time']); ?>" class="form-control" placeholder="NAME" required></td>
                                <td><input type="text" name="end_time" value="<?php echo($value['end_time']); ?>" class="form-control" placeholder="NAME" required></td>
                                <!--<td><input type="text" name="course" value="<?php echo($value['course']); ?>" class="form-control" placeholder="NAME" required></td>-->
                                <!--<td>
									<div class='form-group'>
                                                <select name='course' class='form-control'>
												<option value='BE' selected>BE</option>
                                                <option value='MBA'>MBA</option>
                                                <option value='MCA'>MCA</option>
										<select>
									</div>
								</td>-->
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