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
<script>
    studentRedirectToDelete=function(id)
    {
        result=confirm("Delete "+id+"?");
        if(result==true)
        {
            window.location.href="delete/deletestudent.php?id="+id;
        }

    }
</script>

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
                    <li class="active"><a href="students.php">Student</a></li>
                    <li><a href="subjects.php">Subject</a></li>
                    <li><a href="rooms.php">Class</a></li>
                    <li><a href="allotment.php">Allotment</a></li>
                    <li><a href="form_b.php">Form-B</a></li>
                    <li><a href="form_a.php">Form-A</a></li>
                    <li><a href="more.php">More</a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <!-- STUDENT -->
            <div class="tab-pane active" id="Student">
                <br/>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                            <div class="btn-group btn-group-justified">
                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#student_file_modal">Add Students' file</a>
                                <!--<a href="add/add1student.php" class="btn btn-primary">Add 1 Student</a>-->
                            </div>
                    </div>
                </div>
                <br/>
                <?php
                    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['s_submit'])) {
                        $usn=$_POST['s_search'];
                        $students=mysqli_query($db_connection,"SELECT * FROM student WHERE usn='$usn' OR name='$usn' ORDER BY branch,usn;");    
                    }
                    else {
                        $students=mysqli_query($db_connection,"SELECT * FROM student ORDER BY branch,usn;");
                    }
                    if(mysqli_num_rows($students)>=1)
                    {
                ?>
                
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="s_search" value="" placeholder="Search By USN/Name" class="form-control" required>
                                <div class="input-group-btn">
                                    <button type="submit" name="s_submit" class="btn btn-primary btn-md">
                                        <span class="glyphicon glyphicon-search"></span> 
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-offset-2 col-sm-2 text-right">
                        <span><b>COUNT : <?php echo(mysqli_num_rows($students)); ?></b></span>
                    </div>
                </div>
                <br/>
                <div class="row">	
                    <div class="col-lg-offset-0 col-lg-12" style="overflow:auto; height:320px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>USN</th>
                                    <!--<th>NAME</th>-->
                                    <th>BRANCH</th>
                                    <th>SEM</th>
                                    <th>SUBJECT</th>
                                    <th>ROOM NO</th>
                                    <th>SEAT NO</th>
                                    <th>P/A</th>
                                    <th>EDIT</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while($student=mysqli_fetch_array($students))
                                {
                            ?>
                                <tr>
                                    <!-- <form action="../contact1/login.php" method="get"> -->
                                        <td><?php echo($student['usn']); ?></td>
                                        <td><?php echo($student['branch']); ?></td>
                                        <td><?php echo($student['sem']); ?></td>
                                        <td><?php echo($student['sub_code']); ?></td>
                                        <td><?php echo($student['room_no']); ?></td>
                                        <td><?php echo($student['seat_no']); ?></td>
                                        <td><?php if($student['present']==0){echo('ABSENT');}else if($student['present']==1){echo('PRESENT');}else{echo('MPC');} ?></td>
                                        <td><center><a href="edit/editstudent.php?id=<?php echo($student['usn']);?>"><span class="glyphicon glyphicon-pencil"></span></a></center></td>
                                        <!--<td><center><a onclick="studentRedirectToDelete('<?php echo($student['usn']);?>')"><span class="glyphicon glyphicon-trash"></span></a></center></td>-->
                                    <!-- </form> -->
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
            <br/>
            
    	</div>
        <div class="modal fade" id="student_file_modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Select Excel File Containing</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                            <form class="form-horizontal" action="add/add_from_file.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="pwd">Select Branch:</label>
                                    <div class="col-sm-4">          
                                        <?php 
                                            echo("<div class='form-group'>");
                                            echo("<select name='branch' class='form-control'>");
                                            $branch_query=mysqli_query($db_connection,"SELECT branch_code FROM main_examination.branch;");
                                            while($branch=mysqli_fetch_array($branch_query))
                                            {
                                                echo("<option value='$branch[0]'>$branch[0]</option>");
                                            }
                                            echo("</select>");
                                            echo("</div>"); 
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="stu_file">Select File:</label>
                                    <div class="col-sm-4">
                                        <input type="file" id="#stu_file" name="file" required>
                                    </div>
                                </div>
                                <div class="form-group">        
                                    <div class="text-center">
                                        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
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