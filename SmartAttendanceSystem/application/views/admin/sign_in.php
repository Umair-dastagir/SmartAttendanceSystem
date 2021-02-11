<!DOCTYPE html>
<html>
<head>

	<title>Admin Sign In</title>


        <style type="text/css">
	    .center {
        margin: auto;
        width: 50%;
        padding: 10px;
        margin-top: 15%
    }

body {
      background-image: url("<?php echo base_url();?>uploads/Admin-Background.jpg");
      object-fit: contain;
    }
/*

</style>
</head>
<body>
	<div class="container">
		<div class="card center" style="width: 38%; height: 90%; background-color: ghostwhite">
			<div class="card-body">
				<form method="post">

				<h4 class="text-center">LOGIN AS ADMIN </h4>

					<div class="form-group has-feedback mt-4">
           <input type="email" name="email" class="form-control" placeholder="email" style="font-size: 15px" />
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span> 
        </div>
      <div class="form-wrapper has-feedback">
            <input type="password" name="password" class="form-control" placeholder="password" style="font-size: 15px"/> 
           <span class="glyphicon glyphicon-lock form-control-feedback"></span> 
      </div>
      <br>
      <div class="form-wrapper has-feedback text-center">
			<button type="submit" name="btn" class="btn btn-lg btn-primary rounded-0" value="submit" style="font-size: 15px; width: 30%">Submit <span class="glyphicon glyphicon-check"></span></button> 	
	</div>
		<br>
			<a href="<?php echo base_url()?>instructor/Signin" style="font-size: 14px; font-style: italic; text-decoration: underline; padding-left: 36%">Sign In as Instructor</a>
	<br>
		<hr>
         <div class="lockscreen-footer text-center text-dark" style="font-size: 13px;">
            <?php echo date("Y"); ?> © <?php echo 'BUITEMS SMART ATTENDANCE SYSTEM'; ?>
        </div>
</form>
			</div>
		</div>
	</div>


	<?php
	if($this->input->post('btn')) {
		$email = $this->input->post('email');
		$pass1 = $this->input->post('password');
		if($email == '' && $pass1 != '') {
			echo '<script type="text/javascript">window.alert("Email Required")</script>';
		} else if($pass1 == '' && $email != '') {
			echo '<script type="text/javascript">window.alert("Password Required")</script>';
		} else if($pass1 == '' && $email == '') {
				echo '<script type="text/javascript">window.alert("Email and Password Required")</script>';
		} else {
		if($pass) {
			if(password_verify($this->input->post('password'), $pass)) {
				$get_id = $this->Admin_model->get_admin($email);
				$_SESSION['id'] = $get_id; 
				header('location: Students');
			} else {
				echo '<script type="text/javascript">window.alert("Wrong Password. Try again")</script>';
			}
		} else {
			echo '<script type="text/javascript">window.alert("Invalid Credentials. Try again")</script>';
		}
	}
	}
	?>





<div class="modal fade" id="myModal1" role="dialog">
  <div class="modal-dialog"> 

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</body>


</html>
