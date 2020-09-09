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
    $usn=$_POST['usn'];
    $name=$_POST['name'];
    $sem=$_POST['sem'];
    $branch=$_POST['branch'];
    $subject_code=$_POST['subject_code'];
    $subject_name=$_POST['subject_name'];
    $present=$_POST['present'];
    //echo("$usn|$name|$sem|$branch|$subject_code|$room_no|$seat_no|$present");
    $query="UPDATE student SET name='$name',sem='$sem',branch='$branch',sub_code='$subject_code',sub_name='$subject_name',present='$present' WHERE usn='$usn';";
    $result=mysqli_query($db_connection,$query);
    if($result) {
?>
        <script>alert("Edited successfully");window.location.href="../students.php";</script>
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
    <title>Edit Student</title>
    
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
                EDIT STUDENT
            </h3>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-10 col-sm-1">
                <a href="../students.php">back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10">
            <form action="#" method="post" class="form-inline">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>USN</th>
                            <th>NAME</th>
                            <th>SEM</th>
                            <th>BRANCH</th>
                            <th>SUBJECT CODE</th>
                            <th>SUBJECT NAME</th>
                            <th>PRESENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $value_query=mysqli_query($db_connection,"select * from student where usn='$id';");
                            while($value=mysqli_fetch_array($value_query))
                            {
                        ?>
                            <tr>
                                <td><input type="text" name="usn" value="<?php echo($value['usn']); ?>" class="form-control" placeholder="USN" readonly></td>
                                <td><input type="text" name="name" value="<?php echo($value['name']); ?>" class="form-control" placeholder="NAME" required></td>
                                <td>
                                <?php echo("<div class='form-group'>
                                                <select name='sem' class='form-control'>");
                                                switch ($value['sem']) {
                                                    case '3':
                                                        echo("<option value='3' selected>3</option>
                                                        <option value='4'>4</option>
                                                        <option value='5'>5</option>
                                                        <option value='6'>6</option>
                                                        <option value='7'>7</option>
                                                        <option value='8'>8</option>");
                                                        break;
                                                    case '4':
                                                        echo("<option value='3'>3</option>
                                                        <option value='4' selected>4</option>
                                                        <option value='5'>5</option>
                                                        <option value='6'>6</option>
                                                        <option value='7'>7</option>
                                                        <option value='8'>8</option>");
                                                        break;
                                                    case '5':
                                                        echo("<option value='3'>3</option>
                                                        <option value='4'>4</option>
                                                        <option value='5' selected>5</option>
                                                        <option value='6'>6</option>
                                                        <option value='7'>7</option>
                                                        <option value='8'>8</option>");
                                                        break;
                                                    case '6':
                                                        echo("<option value='3'>3</option>
                                                        <option value='4'>4</option>
                                                        <option value='5'>5</option>
                                                        <option value='6' selected>6</option>
                                                        <option value='7'>7</option>
                                                        <option value='8'>8</option>");
                                                        break;
                                                    case '7':
                                                        echo("<option value='3'>3</option>
                                                        <option value='4'>4</option>
                                                        <option value='5'>5</option>
                                                        <option value='6'>6</option>
                                                        <option value='7' selected>7</option>
                                                        <option value='8'>8</option>");
                                                        break;
                                                    case '8':
                                                        echo("<option value='3'>3</option>
                                                        <option value='4'>4</option>
                                                        <option value='5'>5</option>
                                                        <option value='6'>6</option>
                                                        <option value='7'>7</option>
                                                        <option value='8' selected>8</option>");
                                                    break;
                                                
                                                }
                                            echo("</select>
                                                </div>"); 
                                    ?>
                                </td>
                                <td>
                                <?php 
                                        echo("<select name='branch' class='form-control'>");
                                        $branch_query=mysqli_query($db_connection,"select branch_code from main_examination.branch;");
                                        while($branch=mysqli_fetch_array($branch_query))
                                        {
                                            if(strcmp($value['branch'],$branch[0])==0)
                                            {
                                                echo("<option value='$branch[0]' selected>$branch[0]</option>");
                                            }
                                            else
                                            {
                                                echo("<option value='$branch[0]'>$branch[0]</option>");
                                            }
                                        }
                                        echo("</select>");
                                    ?>
                                </td>
                                <td><input type="text" name="subject_code" value="<?php echo($value['sub_code']); ?>" class="form-control" placeholder="SUBJECT CODE"></td>
                                <td><input type="text" name="subject_name" value="<?php echo($value['sub_name']); ?>" class="form-control" placeholder="SUBJECT NAME"></td>
                                <td>
                                <?php echo("<div class='form-group'>
                                                <select name='present' class='form-control'>");
                                                switch ($value['present']) {
                                                    case '1':
                                                        echo("<option value='1' selected>Present</option>
                                                        <option value='0'>Absent</option>);
                                                        <option value='2'>MPC</option>");
                                                        break;
                                                    case '0':
                                                        echo("<option value='1'>Present</option>
                                                        <option value='0' selected>Absent</option>);
                                                        <option value='2'>MPC</option>");
                                                        break;
                                                    case '2':
                                                        echo("<option value='1'>Present</option>
                                                        <option value='0'>Absent</option>);
                                                        <option value='2' selected>MPC</option>");
                                                        break;
                                                    
                                                }
                                            echo("</select>
                                                </div>"); 
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
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