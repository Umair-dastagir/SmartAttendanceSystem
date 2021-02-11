<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	$ins_id = $_SESSION['id'];	
?>

<title>Students Attendance</title>


<br><br>
<form method="POST">
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
		<!-- <button style="float:right; background-color: #05386B; color: white"  class="btn btn-sm rounded-0 mb-4" name="add">Assign Class</button> -->
		<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th class="text-center"><i class="fas fa-chalkboard"></i>&nbsp;Student Name</th>
				<th class="text-center"><i class="fa fa-book" aria-hidden="true"></i>&nbsp;CMS ID</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Total Classes</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Present In Classes</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Attendance In Percentage (%)</th>

			</tr>
			</thead>

			<?php
				$assigned_id = $this->input->get('id');
				
				$check_type = $this->Instructor_model->get_type($assigned_id);

				if($check_type == 0) {
				$fetch_student_data = $this->Instructor_model->fetch_attendance_assigned($assigned_id, $ins_id);

				foreach($fetch_student_data->result() as $st_data) {
					$student_id = $st_data->student_id;
					$total_no_classes = $this->Instructor_model->count_rows_classes($assigned_id);
					foreach($total_no_classes as $total) {
						$totall = $total->ct;
						$present = $this->Instructor_model->fetch_student_att($student_id, $assigned_id);
						foreach($present as $pr) {
							$present = $pr->at;
							$totall = $total->ct;
							$percent = floor(($present / $totall) * 100);

							if($percent != 0) {
			?>

			<tr>
				<td class="text-center"><?php echo $st_data->student_name.' '.$st_data->student_lastname;?></td>
				<td class="text-center"><?php echo $st_data->cms_id;?></td>
				<td class="text-center"><?php echo $total->ct;?></td>
				<td class="text-center"><?php echo $pr->at;?></td>
				<td class="text-center"><?php $percent.'%';?></td>
			</tr>

			<?php }}}}} else if($check_type == 1) { 
				$student_ids = $this->Instructor_model->fetch_elective_data($assigned_id);
				foreach($student_ids as $ids) {
					$total_no_classes = $this->Instructor_model->count_rows_classes($assigned_id);
					foreach($total_no_classes as $total) {
						$totall = $total->ct;
						$present = $this->Instructor_model->fetch_student_att($ids->student_id, $assigned_id);
						foreach($present as $pr) {
							$present = $pr->at;
							$totall = $total->ct;
							if($totall != 0) {
							$percent = floor(($present / $totall) * 100); } else {$percent = 0; }
			?>
			<tr>
				<td class="text-center"><?php echo $this->Instructor_model->fetch_elective_student($ids->student_id)['student_name'].' '.$this->Instructor_model->fetch_elective_student($ids->student_id)['student_lastname']?></td>
				<td class="text-center"><?php echo $this->Instructor_model->fetch_elective_student($ids->student_id)['cms_id'];?></td>
				<td class="text-center"><?php echo $total->ct;?></td>
				<td class="text-center"><?php echo $pr->at;?></td>
				<td class="text-center"><?php $percent.'%';?></td>
			</tr>

			<?php }}}} ?>
			
		</table>
	</div>
	</div>
</e>
</div></div>
<br><h4 class="text-center text-dark">STUDENTS WITH NO ATTENDANCE</h4><br>
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
						<table class="table table-bordered table-hover" style="width: 100%; color:black">
			<tr style="background-color: whitesmoke">
				<th class="text-center"><i class="fas fa-chalkboard-teacher">&nbsp;Student</th>
				<th class="text-center"><i class="fas fa-chalkboard-teacher">&nbsp;CMS ID</th>
			</tr>
			<?php 
			$assigned_id = $this->input->get('id');

			$fetch_student_data = $this->Instructor_model->fetch_attendance_assigned($assigned_id, $ins_id);
			if($fetch_student_data->result()) {
				$stt = $this->Admin_model->fetch_studentsss($st_data->student_semester, $st_data->student_dept);
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
</form>

<?php } ?>