<!DOCTYPE html>
<html>
<head>

	<title>Smart Attendance System</title>


        <style type="text/css">
	    .center {
        margin: auto;
        width: 50%;
        /*padding: 10px;*/
        margin-top: 20%
    }

body {
      background-image: url("<?php echo base_url();?>uploads/Admin-Background.jpg");
      object-fit: contain;
    }
/*

</style>
</head>
<body>
	<form method="POST">
	<div class="container">
		<div class="card center border border-0 bg-accent mb-5" style="width: 50%; height: 90%;">
			<div class="card-haeder text-center mt-4 mb-4" style="background-color: white">
				<h2>BUITEMS SMART ATTENDANCE SYSTEM</h2>
			</div>
			<div class="card-body mb-5">
				<input name="admin" type="submit" class="btn btn-block btn-primary btn-lg text-white mb-4" style="font-size: 15px; height: 53%" value="LOGIN AS ADMIN">
				<input type="submit" name="ins" class="btn btn-block btn-lg btn-primary text-white" style="font-size:15px; height: 53%" value="LOGIN AS INSTRUCTOR">
			</div>
		</div>
	</div>
</form>
</body>
</html>

<?php
if($this->input->post('admin')) {
	redirect(base_url().'admin/Signin');
}

if($this->input->post('ins')) {
	redirect(base_url().'instructor/Signin');
}
?>