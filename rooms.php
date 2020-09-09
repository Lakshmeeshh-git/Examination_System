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
    roomRedirectToDelete=function(id)
    {
        result=confirm("Delete "+id+"?");
        if(result==true)
        {
            window.location.href="delete/deleteroom.php?id="+id;
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
                    <li><a href="students.php">Student</a></li>
                    <li><a href="subjects.php">Subject</a></li>
                    <li class="active"><a href="rooms.php">Class</a></li>
                    <li><a href="allotment.php">Allotment</a></li>
                    <li><a href="form_b.php">Form-B</a></li>
                    <li><a href="form_a.php">Form-A</a></li>
                    <li><a href="more.php">More</a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <!-- CLASS -->
            <div class="tab-pane active" id="Class">
                <br/>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                            <div class="btn-group btn-group-justified">
                                <!--<a href="add/selectroom.php" class="btn btn-primary">Select Rooms</a>-->
                                <a href="add/add1room.php" class="btn btn-primary">Add Room</a>
                            </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="r_search" value="" placeholder="Search By Room no" class="form-control" required>
                                <div class="input-group-btn">
                                    <button type="submit" name="r_submit" class="btn btn-primary btn-md">
                                        <span class="glyphicon glyphicon-search"></span> 
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br/>
                <?php
                    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['r_submit'])) {
                        $room_no=$_POST['r_search'];
                        $rooms=mysqli_query($db_connection,"SELECT room_no,capacity,odd_available,even_available FROM room WHERE room_no='$room_no';");
                    }
                    else {
                        $rooms=mysqli_query($db_connection,"SELECT room_no,capacity,odd_available,even_available FROM room;");
                    }
                    if(mysqli_num_rows($rooms)>=1)
                    {
                ?>
                <div class="row">
                    <div class="col-lg-offset-2 col-lg-8" style="overflow:auto; height:300px;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ROOM NUMBER</th>
                                    <th>CAPACITY</th>
                                    <th>ODD AVAILABLE</th>
                                    <th>EVEN AVAILABLE</th>
                                    <!--<th>EDIT</th>-->
                                    <th>DELETE</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while($room=mysqli_fetch_array($rooms))
                                {
                            ?>
                                <tr>
                                    <td><?php echo($room['room_no']); ?></td>
                                    <td><?php echo($room['capacity']); ?></td>
                                    <td><?php echo($room['odd_available']); ?></td>
                                    <td><?php echo($room['even_available']); ?></td>
                                   <!-- <td><center><a href="edit/editroom.php?id=<?php echo($room['room_no']);?>"><span class="glyphicon glyphicon-pencil"></span></a></center></td>-->
                                   <td><center><a onclick="roomRedirectToDelete('<?php echo($room['room_no']);?>')"><span class="glyphicon glyphicon-trash"></span></a></center></td>
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

        <!-- end of tab pane -->
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