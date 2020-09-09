<?php

    session_start();
    $db_connection=mysqli_connect("localhost","root","","main_examination");
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
    branchRedirectToDelete=function(id)
    {
        result=confirm("Delete "+id+"?");
        if(result==true)
        {
            window.location.href="delete/delete_branch.php?id="+id;
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
                <?php echo($_SESSION['batch']); ?>
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
                    <li><a href="form_b.php">Form-B</a></li>
                    <li><a href="form_a.php">Form-A</a></li>
                    <li class="active"><a href="more.php">More</a></li>
                </ul>
            </div>
        </div>
        <br/>
        <div class="tab-content">
            <!-- MORE -->
            <div class="tab-pane active">
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4">
                        <a href="select_batch.php" class="btn btn-primary btn-block">Change Batch</a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4">
                    <form action="form/alloted_list.php" method="get">
                        <input type="hidden" name="batch" value="<?php echo($_SESSION['batch']); ?>">
                        <input type="submit" value="Print Alloted List" class="btn btn-info btn-block">
                    </form>
                        <!--<a href="form/alloted_list.php?batch=<?php echo($_SESSION['batch']); ?>" class="btn btn-primary btn-block">Print Alloted List</a>-->
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" href="#collapse1">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse1">Branch</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        
                                    <?php
                                        $branchs=mysqli_query($db_connection,"SELECT * FROM main_examination.branch;");
                                        if(mysqli_num_rows($branchs)>=1)
                                        {
                                    ?>
                                    <div class="row">	
                                        <div class="col-lg-offset-0 col-lg-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>BRANCH CODE</th>
                                                        <!--<th>NAME</th>-->
                                                        <th>SHORT FORM</th>
                                                        <th>FULL FORM</th>
                                                        <th>EDIT</th>
                                                        <th>DELETE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    while($branch=mysqli_fetch_array($branchs))
                                                    {
                                                ?>
                                                    <tr>
                                                        <!-- <form action="../contact1/login.php" method="get"> -->
                                                            <td><?php echo($branch['branch_code']); ?></td>
                                                            <td><?php echo($branch['short_form']); ?></td>
                                                            <td><?php echo($branch['full_name']); ?></td>
                                                            <td><center><a href="edit/editbranch.php?id=<?php echo($branch['branch_code']);?>"><span class="glyphicon glyphicon-pencil"></span></a></center></td>
                                                            <td><center><a onclick="branchRedirectToDelete('<?php echo($branch['branch_code']);?>')"><span class="glyphicon glyphicon-trash"></span></a></center></td>
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
                                    <div class="panel-footer">
                                        <a href="add/add_branch.php" class="btn btn-primary btn-block">ADD</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" href="#collapse2">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse2">FORM DETAILS</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        
                                        <?php
                                            $branchs=mysqli_query($db_connection,"SELECT * FROM main_examination.form_details;");
                                            $branch=mysqli_fetch_array($branchs);
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-offset-0 col-lg-12">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                                <td>COLLEGE :</td>
                                                                <td><?php echo($branch['college']); ?></td>
                                                        </tr>
                                                        <tr>
                                                                <td>EXAMINATION :</td>
                                                                <td><?php echo($branch['examination']); ?></td>
                                                        </tr>
                                                        <tr>
                                                                <td>COLLEGE CODE :</td>
                                                                <td><?php echo($branch['college_code']); ?></td>
                                                        </tr>
                                                        <tr>
                                                                <td>Deputy Chief Superintendent</td>
                                                                <td><?php echo($branch['deputy_chief_superintendent']); ?></td>
                                                        </tr>
                                                        <tr>
                                                                <td>Chief Superintendent</td>
                                                                <td><?php echo($branch['chief_superintendent']); ?></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <a href="edit/edit_form_details.php" class="btn btn-primary btn-block">EDIT</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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