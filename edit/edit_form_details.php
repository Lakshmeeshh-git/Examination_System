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
    $old_college=$_POST['old_college'];
    $college=$_POST['college'];
    $examination=$_POST['examination'];
    $college_code=$_POST['college_code'];
    $deputy_chief_superintendent=$_POST['deputy_chief_superintendent'];
    $chief_superintendent=$_POST['chief_superintendent'];
    
    $query="UPDATE form_details SET college='$college',examination='$examination',college_code='$college_code',deputy_chief_superintendent='$deputy_chief_superintendent',chief_superintendent='$chief_superintendent' WHERE college='$old_college';";
    $result=mysqli_query($db_connection,$query);
    if($result) {
?>
        <script>alert("Edited successfully");window.location.href="../more.php";</script>
<?php
    }
    else {
?>
        <script>alert("Editing Failed");</script>
<?php
    }
}
if($method=='GET') {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Form Details</title>
    
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
                EDIT FORM DETAILS
            </h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
                <a href="../more.php">back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            <form action="#" method="post" class="form-inline">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>COLLEGE</th>
                            <th>EXAMINATION</th>
                            <th>COLLEGE CODE</th>
                            <th>DEPUTY CHIEF SUPERINTENDENT</th>
                            <th>CHIEF SUPERINTENDENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $value_query=mysqli_query($db_connection,"select * from form_details;");
                            $value=mysqli_fetch_array($value_query);
                        ?>
						<input type="hidden" name="old_college" value="<?php echo($value['college']); ?>" class="form-control" placeholder="USN">
                            <tr>
							    
                                <td><input type="text" name="college" value="<?php echo($value['college']); ?>" class="form-control" placeholder="USN"></td>
                                <td><input type="text" name="examination" value="<?php echo($value['examination']); ?>" class="form-control" placeholder="NAME" required></td>
                                <td><input type="text" name="college_code" value="<?php echo($value['college_code']); ?>" class="form-control" placeholder="NAME" required></td>
                                <td><input type="text" name="deputy_chief_superintendent" value="<?php echo($value['deputy_chief_superintendent']); ?>" class="form-control" placeholder="NAME" required></td>
                                <td><input type="text" name="chief_superintendent" value="<?php echo($value['chief_superintendent']); ?>" class="form-control" placeholder="NAME" required></td>
                                
                            </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9" class="text-center">
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