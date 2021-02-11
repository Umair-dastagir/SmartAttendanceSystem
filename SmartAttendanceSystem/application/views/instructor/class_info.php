<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	$ins_id = $_SESSION['id'];	
  	$assigned_id = $this->input->get('id');
?>

<title>Students Attendance</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css"> -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<br><br>

<form method="POST">
	<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
		<e style="font-size: 14px; color: #000">
			<div class="card-body table-responsive"><br>
				<?php 
				$total_classes = $this->Instructor_model->count_rows_classes($assigned_id);
				if($total_classes) {
					foreach($total_classes as $total) {
						$totalclasses = $total->ct;
				?>
				<p style="float:right; font-size: 20px; font-weight: bold;">Total Classes: <?php echo $total->ct;?></p>
				<br><br>
			<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
				<thead>
					<tr style="background-color: whitesmoke">
						<th class="text-center"><i class="fas fa-chalkboard"></i>&nbsp;Student Name</th>
						<th class="text-center"><i class="fa fa-book" aria-hidden="true"></i>&nbsp;CMS ID</th>
						<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Attended Classes</th>
						<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Attendance (%)</th>
					</tr>
				</thead>


				<?php 
					$check_type = $this->Instructor_model->get_type($assigned_id);
					if($check_type == 0) { // compulsory
						$class = $this->Instructor_model->fetch_class_assigned($assigned_id);
						$semester = $this->Instructor_model->class_data($class)['semester'];
						$department = $this->Instructor_model->class_data($class)['depart_id'];
						$students = $this->Instructor_model->fetch_students($semester, $department);
						if($students) {
							foreach($students as $st) {
								$student_id = $st->student_id;
								$attended_classes = $this->Instructor_model->fetch_student_att($student_id, $assigned_id);
								if($attended_classes) {
								foreach($attended_classes as $atc) {
									$at_classes = $atc->at;
									if($at_classes == 0) {
										$percentage = 0;									
									} else {
										$percentage = floor(($at_classes/$totalclasses) * 100);
									}
				?>
					<tr>
						<td class="text-center"><?php echo $st->student_name.' '.$st->student_lastname?></td>
						<td class="text-center"><?php echo $st->cms_id?></td>
						<td class="text-center"><?php echo $at_classes?></td>
						<td class="text-center"><?php echo $percentage.'%'?></td>
					</tr>

				<?php }} else { die('no student has attended this class'); }}} else { die('no students present');}} else { 
					$fetch_elective_students = $this->Instructor_model->fetch_elective_data($assigned_id);
					if($fetch_elective_students) {
						foreach($fetch_elective_students as $st) {
							$student_id = $st->student_id;
							$students = $this->Instructor_model->fetch_elective_student($student_id);
							foreach($students as $stt) {
							$attended_classes = $this->Instructor_model->fetch_student_att($student_id, $assigned_id);
							if($attended_classes) {
								foreach($attended_classes as $atc) {
									$at_classes = $atc->at;
									if($at_classes == 0) {
										$percentage = 0;									
									} else {
										$percentage = floor(($at_classes/$totalclasses) * 100);
									}
				?>
					<tr>
						<td class="text-center"><?php echo $stt->student_name.' '.$stt->student_lastname?></td>
						<td class="text-center"><?php echo $stt->cms_id?></td>
						<td class="text-center"><?php echo $at_classes?></td>
						<td class="text-center"><?php echo $percentage.'%'?></td>
					</tr>


				<?php }} else die('no student has attended this class'); }}} else { die('no students present'); } } ?>
			</table>
			<?php }} else { die('no classes have taken place'); } ?>
			</div>
		</e>
	</div>
</form>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>