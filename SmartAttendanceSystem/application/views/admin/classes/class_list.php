<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	
?>
<br><br>
<form method="POST">
<div class="card ml-3 mr-4 bg-white border border-0 rounded-0 shadow" style="background-color: #05386B;">
	<div class="card-body table-responsive">
		<h3 style="color: #05386B;" class="text-center">CLASS LIST</h3>
	</div>
</div>
<br>
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
		<button style="float:right; background-color: #05386B; color: white"  class="btn btn-sm rounded-0 mb-4" name="add">Add Class</button>
		<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th style="width: 140px;" class="text-center"><i class="fas fa-tasks"></i>&nbsp;Actions&nbsp;&nbsp;</th>
				<th class="text-center"><i class="fas fa-chalkboard"></i>&nbsp;Class Number</th>
				<th class="text-center"><i class="fas fa-chalkboard"></i>&nbsp;Class Department</th>
				<!-- <th class="text-center"><i class="fas fa-chalkboard"></i>&nbsp;Course</th> -->
		<!-- 		<th class="text-center"><i class="fas fa-chalkboard"></i>&nbsp;Instructor</th>
			 -->	<!-- <th class="text-center"><i class="fas fa-building"></i>&nbsp;Department</th> -->
				<th class="text-center"><i class="fas fa-book-open"></i>&nbsp;Semester</th>
			</tr>
		</thead>
		<?php
		$fetch_class = $this->Admin_model->fetch_classes();
		if($fetch_class) {
			foreach($fetch_class as $class) {
		?>
		<tr>
			<td class="text-center"><a href="<?php echo base_url();?>admin/Classes/Update_Class?id=<?php echo $class->class_id?>" title="update"><i class="fas fa-edit text-primary" style="font-size: 18px"></i></a></td>
			<td class="text-center"><?php echo $class->class_no;?></td>
			<td class="text-center"><?php echo $class->dept_name;?></td>
			<!-- <td class="text-center"><?php echo $class->course_name;?></td> -->
			<!-- <td class="text-center"><?php echo $class->instructor_name.' '.$class->instructor_lname;?></td> -->
			<td class="text-center"><?php echo $class->semester;?></td>
		</tr>
		<?php }} ?>
	
		</table>
	</div>
	</div>
</div>
</div>
</form>
<!-- <script>
	$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script> -->

<?php
if(isset($_POST['add'])) {
	redirect('admin/Classes/Add_Class');
}
?>

<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>