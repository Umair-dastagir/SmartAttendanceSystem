<!DOCTYPE html>
<html>
<head>

	<title>Instructor Sign In</title>


        <style type="text/css">
	   .center {
        margin: auto;
        width: 50%;
        padding: 10px;
        margin-top: 1%
    }

   .center2 {
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
		<div class="card center2 mb-4" style="width: 38%; background-color: ghostwhite">
			<div class="card-body">
				<form method="post">

				<h4 class="text-center">LOGIN AS INSTRUCTOR </h4>

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
			<a href="<?php echo base_url()?>admin/Signin" style="font-size: 14px; font-style: italic; text-decoration: underline; padding-left: 36%">Sign In as Admin</a>
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
		$checkemail = $this->Instructor_model->check_email($email);
		if($checkemail) {
			$get_id = $this->Instructor_model->get_ins($email);
			$check_active = $this->Instructor_model->check_active($email);
			if($check_active == 1) {
				// echo '<script type="text/javascript">window.alert("active")</script>';
				if(password_verify($pass1, $pass)) {
					$_SESSION['id'] = $get_id;
					header('location: Home');
				} else {
					echo '<script type="text/javascript">window.alert("incorrect password")</script>';
				}
			} else {
				if($pass1 == $pass) {
					$password_hash = password_hash($pass1, PASSWORD_BCRYPT);
					$data = array(
						'instructor_pass' => $password_hash,
						'is_active' => 1
					);
					$update = $this->Instructor_model->update_pass_active($email, $data);
					if($update) {
						$_SESSION['id'] = $get_id;
						header('location: Home');
					}
				} else {
					echo '<script type="text/javascript">window.alert("incorrect password. try again")</script>';
				}
			}
		} else {
			echo '<script type="text/javascript">window.alert("invalid credentials. try again")</script>';
		}
		}
	}
	?>
</body>
</html>
