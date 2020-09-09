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
$(document).ready(function(){
	$("input:checkbox").click(function(){
		if ($(this).is(':checked')) 
		{
			x=this.value;
			z=$("#rooms_selected_id").val($("#rooms_selected_id").val()+x);
            z1=$("#rooms_selected_id_count").val(parseInt($("#rooms_selected_id_count").val())+1);
            
		}
		else
		{
			y=this.value;
			z=$("#rooms_selected_id").val();
			k=z.replace(y,"");
			$("#rooms_selected_id").val(k);
            z1=$("#rooms_selected_id_count").val($("#rooms_selected_id_count").val()-1);
		}
		
	});
	
	$( "select" ).change(function() {
        if($("option").is(":selected")) {
            var b=this.value;
            //alert(this.value);
            //var totalCheckboxes = $('input:checkbox').length;
            $('input[type="checkbox"]').each(function(){
                //alert($(this).attr('class'));
                //alert($(this).hasClass(b));
                
                //a=$(this).attr('class')
                if($(this).hasClass(b)) {
                    $(this).prop("checked", false);
                    $(this).attr('disabled',false);
                }
                else {
                    $(this).prop("checked", false);
                    $(this).attr('disabled',true);
                }
                $("#rooms_selected_id_count").val(0);
                $("#rooms_selected_id").val('');
            });
            //if($("option").attr('class'))
            //alert(cn);
        }
    });
});
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
                    <li><a href="rooms.php">Class</a></li>
                    <li><a href="allotment.php">Allotment</a></li>
                    <li class="active"><a href="form_b.php">Form-B</a></li>
                    <li><a href="form_a.php">Form-A</a></li>
                    <li><a href="more.php">More</a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <!-- CLASS -->
            <div class="tab-pane active" id="Class">
                <br/>
                <form action="form/b_form.php" method="get">
                    <input type="hidden" name="rooms_selected" value="" id="rooms_selected_id" readonly/>
                    <input type="hidden" name="rooms_selected_count" value="0" id="rooms_selected_id_count" readonly/>
                    <input type="hidden" name="batch" value="<?php echo($_SESSION['batch']); ?>" readonly>
                    <div class="row">
                        <div class="col-lg-offset-4 col-lg-4">
                            <?php 
                                echo("<div class='form-group'>");
                                echo("<label for='branch'>Select Branch:</label>");
                                echo("<select name='branch_sub' class='form-control'>");
                                $branch_query=mysqli_query($db_connection,"SELECT branch,sub_code FROM student GROUP BY branch,sub_code;");
                                echo("<option value='all'>-</option>");
                                while($branch=mysqli_fetch_array($branch_query))
                                {
                                    echo("<option value='$branch[0]|$branch[1]'>$branch[0] | $branch[1]</option>");
                                }
                                echo("</select>");
                                echo("</div>"); 
                            ?>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-lg-offset-4 col-lg-4" style="overflow:auto; height:270px;">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Room no</th>
                                        <th class="text-center">Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $rooms_query=mysqli_query($db_connection,"SELECT room_no FROM room;");
                                    while($rooms=mysqli_fetch_array($rooms_query))
                                    {
                                        $rooms_branch_query=mysqli_query($db_connection,"SELECT DISTINCT(branch),sub_code FROM student WHERE room_no='$rooms[0]';");

                                ?>
                                    <tr>
                                        <td><?php echo("$rooms[0]"); ?></td>
                                        <?php
                                        echo('<td><center><input type="checkbox" name="" class=\'');
                                            
                                            while($rooms_branch=mysqli_fetch_array($rooms_branch_query)) {
                                                echo("$rooms_branch[0]|$rooms_branch[1] ");
                                            }
                                            
                                        echo("'value=\"$rooms[0]|\" disabled></center></td>");
                                        ?>
                                    </tr>
                                <?php
                                    }
                                ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-offset-4 col-lg-4 text-center">
                            <input type="submit" value="Print" class="btn btn-primary">
                        </div>
                    </div>
                </form>
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