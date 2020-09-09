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

<!doctype html>
<html>
<head>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <style>

        .header
        {
        background-color:#FFFFFF;
        }

    </style>
</head>

<body>
    <header>
        <div class="header">
            <div class="text-center">
                <h2 style="font-family: 'Times New Roman', Times, serif; color:#337ab7;">
                EXAMINATION SYSTEM
                </h2>
            </div>
        </div>
    </header>


    <div class="row" style="margin-right: 0px;">
        <div class="text-center">
            <h4 style="font-family: 'Times New Roman',Georgia, serif; color:#337ab7;">
                <?php echo($batch); ?>
            </h4>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="students.php">Student</a></li>
                    <li class="active"><a href="subjects.php">Subject</a></li>
                    <li><a href="rooms.php">Class</a></li>
                    <li><a href="allotment.php">Allotment</a></li>
                    <li><a href="form_b.php">Form-B</a></li>
                    <li><a href="form_a.php">Form-A</a></li>
                    <li><a href="more.php">More</a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <!-- SUBJECT -->
            <div class="tab-pane active" id="Subject">
                <br/>
                
                <br/>
                <?php
                    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['s_submit'])) {
                        $sub_code=$_POST['s_search'];
                        $subjects=mysqli_query($db_connection,"SELECT DISTINCT(sub_code),sub_name,branch FROM student WHERE sub_code='$sub_code';");
                    }
                    else {
                        $subjects=mysqli_query($db_connection,"SELECT DISTINCT(sub_code),sub_name,branch FROM student;");
                    }
                    if(mysqli_num_rows($subjects)>=1)
                    {
                ?>
                <div class="row">	
                    <div class="col-lg-offset-2 col-lg-8" style="overflow:auto; height:200px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SUBJECT CODE</th>
                                    <th>SUBJECT NAME</th>
                                    <th>BRANCH</th>
                                    <!--<th>EDIT</th>
                                    <th>DELETE</th>-->
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while($subject=mysqli_fetch_array($subjects))
                                {
                            ?>
                                <tr>
                                    <td><?php echo($subject['sub_code']); ?></td>
                                    <td><?php echo($subject['sub_name']); ?></td>
                                    <td><?php echo($subject['branch']); ?></td>
                                    <!--<td><center><a href="edit/editsubject.php?id=<?php echo($subject['sub_code']);?>"><span class="glyphicon glyphicon-pencil"></span></a></center></td>
                                   <td><center><a onclick="subjectRedirectToDelete('<?php echo($subject['sub_code']);?>')"><span class="glyphicon glyphicon-trash"></span></a></center></td>-->
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
                    }
                    else {
                ?>
                <div class="row">    
                    <div class="well col-lg-offset-4 col-lg-4 text-center" style="color:red;">
                    <h4>
                        No Records Found
                    </h4>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>

            
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
	header("Location: login.php");
}
?>