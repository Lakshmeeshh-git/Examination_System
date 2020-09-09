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
if($method=='POST' && isset($_POST['addok']))
{
    $sub_code=$_POST['sub_code'];
    $subject_name=$_POST['subject_name'];
    $sem=$_POST['sem'];
    $branch=$_POST['branch'];
    $query="INSERT INTO subject(sub_code,sub_name,sem,branch) VALUES('$sub_code','$subject_name','$sem','$branch');";
    $result=mysqli_query($db_connection,$query);
    if($result) {
?>
        <script>alert("Added successfully");window.location.href="../subjects.php";</script>
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
    <title>Add Subject</title>
    
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
                ADD SUBJECT
            </h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
                <a href="../subjects.php">back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <form action="#" method="post" class="form-inline">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SUBJECT CODE</th>
                            <th>SUBJECT NAME</th>
                            <th>SEM</th>
                            <th>BRANCH</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td><input type='text' name='sub_code' value='' class='form-control' placeholder='subject code' required></td>
                                <td><input type='text' name='subject_name' value='' class='form-control' placeholder='subject name' required></td>
                                <td>
                                    <div class='form-group'>
                                        <select name='sem' class='form-control'>
                                            <option value='1'>1</option>
                                            <option value='2'>2</option>
                                            <option value='3'>3</option>
                                            <option value='4'>4</option>
                                            <option value='5'>5</option>
                                            <option value='6'>6</option>
                                            <option value='7'>7</option>
                                            <option value='8'>8</option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        echo("<div class='form-group'>");
                                        echo("<select name='branch' class='form-control'>");
                                        $branch_query=mysqli_query($db_connection,"SELECT branch_code FROM branch;");
                                        while($branch=mysqli_fetch_array($branch_query))
                                        {
                                            echo("<option value='$branch[0]'>$branch[0]</option>");
                                        }
                                        echo("</select>");
                                        echo("</div>"); 
                                    ?>
                                </td>
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