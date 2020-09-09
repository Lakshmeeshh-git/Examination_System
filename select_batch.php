<?php 
session_start();
if(isset($_SESSION["user_name"]))
{
    $db_connection=mysqli_connect("localhost","root","","main_examination");
?>

<?php
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST' && isset($_POST['sel_batch']))
    {
        $batch=$_POST['batch'];
        $_SESSION["batch"] = $batch;
        header("Location: students.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Select Batch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

<script>
    batchRedirectToDelete=function(id)
    {
        result=confirm("Flush "+id+"?");
        if(result==true)
        {
            window.location.href="delete/flush_batch.php?id="+id;
        }

    }
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
    <div class="row">
        <div class="text-center">
            <h3 style="font-family: 'Times New Roman',Georgia, serif; color:#337ab7;">
                BATCH
            </h3>
        </div>
    </div>
    <br/>
    <?php
        $batch_query=mysqli_query($db_connection,"SELECT * FROM batch;");
        if(mysqli_num_rows($batch_query)>=1)
        {
    ?>
        <div class="row">
            <div class="col-lg-offset-2 col-lg-8" style="overflow:auto; height:400px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>BATCH NUMBER</th>
                            <th>DATE</th>
                            <th>START TIME</th>
                            <th>END TIME</th>
                            <!--<th>COURSE</th>-->
                            <th>EDIT</th>
                            <th>SELECT</th>
                            <th>FLUSH</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        while($batch=mysqli_fetch_array($batch_query))
                        {
                    ?>
                        <tr>
                            <td><b><?php echo($batch['batch_no']); ?></b></td>
                            <td><?php echo($batch['date']); ?></td>
                            <td><?php echo($batch['start_time']); ?></td>
                            <td><?php echo($batch['end_time']); ?></td>
                            <!--<td><?php echo($batch['course']); ?></td>-->
                            <td><center><a href="edit/editbatch.php?id=<?php echo($batch['batch_no']);?>" name="sel_batch"><span class="glyphicon glyphicon-pencil"></span></a></center></td>
                            <td><center>
                                <form action="select_batch.php" method="post">
                                    <input type="hidden" name="batch" value="<?php echo($batch['batch_no']);?>">
                                    <input type="submit" value="SELECT" name="sel_batch" class="btn btn-primary">
                                </form>
                            </center></td>
                            <td><center><a onclick="batchRedirectToDelete('<?php echo($batch['batch_no']);?>')" class="btn btn-danger">FLUSH</a></center></td>
                            
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