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
    redirectToDeallocate=function()
    {
        result=confirm("Deallocet all Students");
        if(result==true)
        {
            window.location.href="edit/edit_allotment.php?deallote_all=True";
        }

    }
</script>
    

    <style>

        .header
        {
        background-color:#FFFFFF;
        }

    </style>

<script>
$(document).ready(function(){
	$("input[name=check]").click(function(){
		if ($(this).is(':checked')) 
		{
			x=this.value;
			z=$("#rooms_selected_id").val($("#rooms_selected_id").val()+x);
            m=document.getElementById(x);
            m.checked=true;
            z1=$("#rooms_selected_id_count").val(parseInt($("#rooms_selected_id_count").val())+1);
            
		}
		else
		{
			y=this.value;
			z=$("#rooms_selected_id").val();
			k=z.replace(y,"");
			$("#rooms_selected_id").val(k);
            m=document.getElementById(x);
            m.checked=false;
            z1=$("#rooms_selected_id_count").val($("#rooms_selected_id_count").val()-1);
		}
		
	});

	$('input[name=check_modal]').click(function(){
        if ($(this).is(':checked')) 
		{
			x=this.value;
			z=$("#rooms_selected_id_modal").val($("#rooms_selected_id_modal").val()+x);
            //m=document.getElementById(x);
            //m.checked=true;
            z1=$("#rooms_selected_id_count_modal").val(parseInt($("#rooms_selected_id_count_modal").val())+1);
            
		}
		else
		{
			y=this.value;
			z=$("#rooms_selected_id_modal").val();
			k=z.replace(y,"");
			$("#rooms_selected_id_modal").val(k);
            //m=document.getElementById(x);
            //m.checked=false;
            z1=$("#rooms_selected_id_count_modal").val($("#rooms_selected_id_count_modal").val()-1);
		}

    });
	
});
</script>

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
                    <li><a href="rooms.php">Class</a></li>
                    <li class="active"><a href="allotment.php">Allotment</a></li>
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
                                <a class="btn btn-primary" data-toggle="modal" data-target="#student_file_modal">Edit Alloted</a>
                                <a class="btn btn-danger" onclick="redirectToDeallocate()">Flush all alloted</a>
                            </div>
                    </div>
                </div>
                <br/>
                <form action="allote.php" method="get">
                    <div class="row">
                        <div class="col-lg-offset-4 col-lg-4">
                            <div class="form-group">
                                <?php 
                                    echo("<label for='branch'>Select Branch:</label>");
                                    echo("<select name='branch_sub' class='form-control'>");
                                    $branch_query=mysqli_query($db_connection,"SELECT branch,sub_code FROM student WHERE room_no='noroom' GROUP BY branch,sub_code;");
                                    if(mysqli_num_rows($branch_query)>0){
                                        while($branch=mysqli_fetch_array($branch_query))
                                        {
                                            $branch_not_alloted_query=mysqli_query($db_connection,"SELECT COUNT(usn) FROM student WHERE room_no='noroom' AND branch='$branch[0]' AND sub_code='$branch[1]';");
                                            $branch_not_alloted=mysqli_fetch_array($branch_not_alloted_query);
                                            echo("<option value='$branch[0]|$branch[1]'>$branch[0] | $branch[1] | <span class='text-right'>$branch_not_alloted[0]</span></option>");
                                        }
                                    }
                                    else {
                                        echo("<option value='null'>All Students Are Alloted</option>");
                                    }
                                    echo("</select>");
                                ?>
                                <br>
                                <input type="hidden" name="rooms_selected" value="" id="rooms_selected_id" readonly/>
                                <input type="hidden" name="rooms_selected_count" value="0" id="rooms_selected_id_count" readonly/>
                                
                            </div>
                        </div>
                    </div>
                <?php
                    $rooms=mysqli_query($db_connection,"SELECT room_no,capacity,odd_available,even_available FROM room;");
                    if(mysqli_num_rows($rooms)>=1)
                    {
                ?>
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8" style="overflow:auto; height:250px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ROOM NUMBER</th>
                                        <th>CAPACITY</th>
                                        <th>ODD AVAILABLE</th>
                                        <th>EVEN AVAILABLE</th>
                                        <th>SELECT</th>
                                        <th>ODD</th>
                                        <th>EVEN</th>
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
                                        <td><center>
                                        <?php
                                            if($room['odd_available']>0 || $room['even_available']>0) {
                                        ?>
                                            <input type="checkbox" name="check" value="<?php echo $room['room_no'],'|'; ?>">
                                        <?php
                                            }
                                            else {
                                        ?>
                                            <input type="checkbox" name="check" value="<?php echo $room['room_no'],'|'; ?>" disabled>
                                        <?php
                                            }
                                        ?>
                                        </center></td>
                                        <td><center>
                                        <?php
                                            if($room['odd_available']>0) {
                                        ?>
                                            <input type="radio" name="<?php echo $room['room_no']; ?>" value="odd" id="<?php echo $room['room_no'],'|'; ?>">
                                        <?php
                                            }
                                            else {
                                        ?>
                                            <input type="radio" name="<?php echo $room['room_no']; ?>" value="odd" id="<?php echo $room['room_no'],'|disabbled'; ?>" disabled>
                                        <?php
                                            }
                                        ?>
                                        </center></td>
                                        <td><center>
                                        <?php
                                            if($room['even_available']>0) {
                                        ?>
                                            <input type="radio" name="<?php echo $room['room_no']; ?>" value="even" id="<?php echo $room['room_no'],'|'; ?>">
                                        <?php
                                            }
                                            else {
                                        ?>
                                            <input type="radio" name="<?php echo $room['room_no']; ?>" value="even" id="<?php echo $room['room_no'],'|disabled'; ?>" disabled>
                                        <?php
                                            }
                                        ?>
                                        </center></td>
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
                    <br />
                    <div class="row">
                        <div class="col-lg-offset-4 col-lg-4 text-center">
                            <input type="submit" name="allot" value="Allot" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
                
            </div>

        <!-- end of tab pane -->
    	</div>

        <div class="modal fade" id="student_file_modal" role="dialog">
            <form action="edit/edit_allotment.php" method="get">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Select Rooms To Deallocate</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="rooms_selected" value="" id="rooms_selected_id_modal" readonly/>
                            <input type="hidden" name="rooms_selected_count" value="0" id="rooms_selected_id_count_modal" readonly/>
                                
                            <?php
                                $rooms=mysqli_query($db_connection,"SELECT room_no,capacity,odd_available,even_available FROM room;");
                                if(mysqli_num_rows($rooms)>=1)
                                {
                            ?>
                            <div class="row">
                                <div class="col-lg-offset-0 col-lg-12" style="overflow:auto; height:250px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ROOM NUMBER</th>
                                                <th>CAPACITY</th>
                                                <th>ODD AVAILABLE</th>
                                                <th>EVEN AVAILABLE</th>
                                                <th>SELECT</th>
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
                                                <td><center><input type="checkbox" name="check_modal" value="<?php echo $room['room_no'],'|'; ?>"></center></td>
                                                <!--<td><center><input type="radio" name="<?php echo $room['room_no']; ?>" value="odd"></center></td>
                                                <td><center><input type="radio" name="<?php echo $room['room_no']; ?>" value="even"></center></td>-->
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

                        <div class="modal-footer">
                            <input type="submit" name="deallote" value="Deallot" class="btn btn-primary"/>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    
                </div>
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
	header("Location: login.php");
}
?>