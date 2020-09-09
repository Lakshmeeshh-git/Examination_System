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
$method=$_SERVER['REQUEST_METHOD'];
if($method=='POST' && isset($_POST['addok']))
{
    $branch_code=$_POST['branch_code'];
    $short_form=$_POST['short_form'];
    $full_name=$_POST['full_name'];
    $query="INSERT INTO branch VALUES('$branch_code','$short_form','$full_name');";
    $result=mysqli_query($db_connection,$query);
    if($result) {
?>
        <script>alert("Added successfully");window.location.href="../more.php";</script>
<?php
    }
    else {
?>
        <script>alert("Addition Failed");</script>
<?php
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Branch</title>
    
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
                ADD BRANCH
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
        <div class="col-sm-offset-3 col-sm-6">
            <form action="#" method="post" class="form-inline">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>BRANCH CODE</th>
                            <th>SHORT FORM</th>
                            <th>FULL FORM</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td><input type='text' name='branch_code' value='' class='form-control' placeholder='BRANCH CODE' required></td>
                                <td><input type='text' name='short_form' value='' class='form-control' placeholder='Short form' required></td>
                                <td><input type='text' name='full_name' value='' class='form-control' placeholder='Full form' required></td>
                                
                            </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-center">
                                <input type="reset" value="CLEAR" class="btn btn-primary">
                                <input type="submit" value="ADD" name="addok" class="btn btn-primary">
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
mysqli_close($db_connection);
?>

<?php
}
else{
	header("Location: ../login.php");
}
?>