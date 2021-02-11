<?php
if(empty($_SESSION['id'])) {
	redirect('admin/Signin');
} else {
	$id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<style type="text/css">
		.center2 {
        margin: auto;
        width: 50%;
        padding: 10px;
        margin-top: 12%
    }

    		.center1 {
        margin: auto;
        width: 50%;
        padding: 10px;
        margin-top: 0%
    }
	</style>
</head>
<body class="bg-white">
	<br>
	<div class="container bg-white center">
		<div class="row">
			<div class="col col-sm bg-white">
		<?php foreach($course as $cr) { ?>
				<div class="card rounded-0 shadow-sm card-sm mb-3 center1" style="width: 65%">
					<div class="card-header">
						<h5 class="text-center" style="font-weight: bold; color: #05386B">CLASS - <?php echo $cr->class_id;?></h5>
					</div>
					<div class="card-body text-center">
						<div class="row">
							<div class="col col-sm ml-3">
								<e style="color: #05386B; font-size: 17px">DEPARTMENT</e>
							</div>
							<div class="col mr-3">
								<e style="font-size: 17px"><?php echo $cr->dept_name; ?></e>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col col-sm ml-3">
								<e style="color: #05386B; font-size: 17px">COURSE NAME</e>
							</div>
							<div class="col mr-3">
								<e style="font-size: 17px"><?php echo $cr->course_name; ?></e>
							</div>
						</div>
						<div class="row mt-2">
							<div class="col col-sm ml-3">
								<e style="color: #05386B; font-size: 17px">COURSE CODE</e>
							</div>
							<div class="col mr-3">
								<e style="font-size: 17px"><?php echo $cr->course_code; ?></e>
							</div>
						</div>
						<br><br>
						<a href="" style="float: right" class="mr-1">More Class Info&nbsp;&nbsp;<i class="fas fa-arrow-right"></i></a>
						<br><a href="<?php echo base_url();?>instructor/ShowQRCode?id=<?php echo $cr->class_id?>" style="float: right" class="mr-1">Scan QR Code&nbsp;&nbsp;<i class="fas fa-qrcode"></i></a>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>

</body>
</html>
<?php } ?>