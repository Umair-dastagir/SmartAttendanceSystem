<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	
?>

<title>Students Attendance</title>


<br><br>
<form method="POST">
<div class="card ml-3 mr-4 bg-white border border-0 rounded-0 shadow" style="background-color: #05386B;">
	<div class="card-body table-responsive">
		<h3 style="color: #05386B;" class="text-center">CLASS</h3>
	</div>
</div>
<br>
<?php 
$check_type = $this->Admin_model->check_course_type($this->input->get('id'));
if($check_type == 0) {
?>
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
		<table id="myTable1" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Student</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;CMS ID</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Total Classes</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Present In Classes</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Attendance in %</th>
			</tr>
		</thead>
		<?php
		$id = $this->input->get('id');
		$fetch_class = $this->Admin_model->fetch_attendance_assigned($id);
		if($fetch_class) {
			foreach($fetch_class->result() as $class) {
				$st = $class->std;
				$total_classes = $this->Admin_model->count_rows_classes($id);
				foreach($total_classes as $tc) {
					$attendance = $this->Admin_model->fetch_student_att($st, $id);
					foreach($attendance as $atd) {
						$present = $atd->at;
						$total = $tc->ct;

						$percent = floor(($present / $total) * 100);
		?>
		<tr>
			<td class="text-center"><?php echo $class->student_name. ' '.$class->student_lastname;?></td>
			<td class="text-center"><?php echo $class->cms_id ?></td>
			<td class="text-center"><?php echo $tc->ct;?></td>
			<td class="text-center"><?php echo $atd->at;?></td>
			<td class="text-center"><?php echo $percent.'%';?></td>
		</tr>
		<?php }}}} ?>
		</table>
	</div>
</e>
	</div>
	<br>
	<h4 class="text-center text-dark">STUDENTS WITH NO ATTENDANCE</h4><br>

	<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
	<div class="card-body table-responsive">
		<e style="font-size: 14px; color: #000">
				<table class="table table-bordered table-hover" style="width: 100%; color:black">
			<tr style="background-color: whitesmoke">
				<th class="text-center"><i class="fas fa-chalkboard-teacher">&nbsp;Student</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher">&nbsp;CMS ID</th>
			</tr>
			<?php 
			if($fetch_class->result()) {
				$stt = $this->Admin_model->fetch_studentsss($class->student_semester, $class->student_dept);
				foreach($stt as $s) { 
					$check_st_assign = $this->Admin_model->check_in_att($this->input->get('id'), $s->student_id);
					if(!$check_st_assign) {
			?>
		<tr>
			<td class="text-center"><?php echo $s->student_name. ' '.$s->student_lastname;;?></td>
			<td class="text-center"><?php echo $s->cms_id ;?></td>
		</tr>
			 <?php }}} else { 
			 	$classid = $this->Admin_model->fetch_class_id($this->input->get('id'));
			 	$department = $this->Admin_model->fetch_class_det($classid)->result_array()[0]['depart_id'];
			 	$semester = $this->Admin_model->fetch_class_det($classid)->result_array()[0]['semester'];

			 	$fetch_st = $this->Admin_model->fetch_studentsss($semester, $department);
			 	foreach($fetch_st as $st) {
			 ?>
			 <tr>
			 	<td class="text-center"><?php echo $st->student_name. ' '.$st->student_lastname;;?></td>
			 	<td class="text-center"><?php echo $st->cms_id ;?></td>
			</tr>
			 <?php }} ?>
		</table>
	</div>
</e>
</div>

</div>
</div>
<?php } else { ?>
	<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
		<table id="myTable1" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Student</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;CMS ID</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Total Classes</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Present In Classes</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Attendance in %</th>
			</tr>
		</thead>
		<?php 
			$students = $this->Admin_model->fetch_st_from_elective($this->input->get('id'));
			foreach($students as $st) {
				$total_classes = $this->Admin_model->count_rows_classes($this->input->get('id'));
				foreach($total_classes as $tc) {
					$attendance = $this->Admin_model->fetch_student_att($st->std, $this->input->get('id'));
					foreach($attendance as $atd) {
						$present = $atd->at;
						$total = $tc->ct;

						$percent = floor(($present / $total) * 100);
		?>
		<tr>
			<td class="text-center"><?php echo $st->student_name.' '.$st->student_lastname;?></td>
			<td class="text-center"><?php echo $st->cms_id;?></td>
			<td class="text-center"><?php echo $tc->ct;?></td>
			<td class="text-center"><?php echo $present;?></td>
			<td class="text-center"><?php echo $percent.'%';?></td>
		</tr>
		<?php }}} ?>
		</table>
	</div>

	</div>
		<br>
	<h4 class="text-center text-dark">STUDENTS WITH NO ATTENDANCE</h4><br>

	<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
	<div class="card-body table-responsive">
		<e style="font-size: 14px; color: #000">
				<table class="table table-bordered table-hover" style="width: 100%; color:black">
			<tr style="background-color: whitesmoke">
				<th class="text-center"><i class="fas fa-chalkboard-teacher">&nbsp;Student</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher">&nbsp;CMS ID</th>
			</tr>
			<?php 
				$electives = $this->Admin_model->get_elective_assigned($this->input->get('id'));
				foreach($electives as $el) {
					$student = $el->student_id;
					$check_st_assign = $this->Admin_model->check_in_att($this->input->get('id'), $student);
					if(!$check_st_assign) {		
			?>
		<tr>
			<td class="text-center"><?php echo $el->student_name.' '.$el->student_lastname;?></td>
			<td class="text-center"><?php echo $el->cms_id;?></td>
		</tr>
			 <?php }} ?>
		</table>
	</div>
</e>
</div>

</div>
</form>




<?php
}
if(isset($_POST['add'])) {
	redirect('admin/AssignedClasses/Add_AssignedClass');
}
?>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable1').DataTable();
} );
</script>