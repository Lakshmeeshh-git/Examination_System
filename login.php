<?php
session_start();
$method=$_SERVER['REQUEST_METHOD'];
if($method=='POST')
{
	$db=mysqli_connect("localhost","root","","main_examination");
	$username=$_POST["u_name"];
	$user_password=$_POST["u_password"];

	$user="SELECT password FROM user WHERE user_name='$username';";
	$user_entry=mysqli_query($db,$user);
	$up=mysqli_fetch_array($user_entry);
	if($user_password==$up[0])
	{

		$_SESSION["user_name"] = $username[0];
		header("Location: select_batch.php");
	}
	mysqli_close($db);
}
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

.jumbotron
{
background-color:#337ab7;
}

</style>
<script src="bootstrap.js">
</script>

</head>

<body>

<div class="container">
<form method="post" action="login.php">
	<div class="form-group">
<br/>
<br/>
<br/>
<br/>
<br/>

		<div class="row">
			<div class="col-sm-offset-4 col-sm-4 well">
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="text-center">
							<h3 style="font-family: 'Times New Roman', Times, serif; color:#337ab7;">
							EXAMINATION SYSTEM
							</h3>
						</div>
						<hr>
						<div class="form-group">
							<label for="username">USER NAME</label>
							<input type="text" name="u_name" value="" id="username" class="form-control" placeholder="Enter User name" required />
						</div>	
					</div>	
				</div>
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="form-group">
							<label for="user_password">PASSWORD</label>
							<input type="password" name="u_password" value="" id="user_password" class="form-control" placeholder="Enter Password" required />
						</div>	
					</div>
				</div>
<br/>				
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6">
						<div class="form-group">
							<input type="submit" value="LOG IN" class="btn btn-primary"/>
							<input type="reset" value="CLEAR" class="btn btn-primary"/>
						</div>
					</div>	
				</div>
				<?php
					$method=$_SERVER['REQUEST_METHOD'];
					if($method=='POST')
					{
						echo'<div class="well" style="color:red;">THE PASSWORD OR USER NAME YOU HAVE ENTARED IS INCORRECT</div>	';
					}
				?>
			</div>	
		</div>		
	</div>
</form>
</div>

</body>

</html>

<?php

?>
