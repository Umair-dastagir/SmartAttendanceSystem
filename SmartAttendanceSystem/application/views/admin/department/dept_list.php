<?php
  if(empty($_SESSION['id'])) {
      redirect('admin/Signin');
  } else {
  	
?>
<br><br>
<form method="POST">
<div class="card ml-3 mr-4 bg-white border border-0 rounded-0 shadow" style="background-color: #05386B;">
	<div class="card-body table-responsive">
		<h3 style="color: #05386B;" class="text-center">DEPARTMENT LIST</h3>
	</div>
</div>
<br>
<div class="card ml-3 mr-4 border border-0 rounded-0 shadow">
<e style="font-size: 14px; color: #000">
	<div class="card-body table-responsive">
		<button style="float:right; background-color: #05386B; color: white"  class="btn btn-sm rounded-0 mb-4" name="add">Add Department</button>
		<table id="myTable" class="table table-bordered table-hover" style="width: 100%; color:black">
			<thead>
			<tr style="background-color: whitesmoke">
				<th style="width: 140px;" class="text-center"><i class="fas fa-tasks"></i>&nbsp;Actions&nbsp;&nbsp;</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Department</th>
				<th class="text-center"><i class="fas fa-building"></i>&nbsp;Faculty</th>
				<th class="text-center"><i class="fas fa-user"></i>&nbsp;Chair Person</th>
			</tr>
		</thead>
		<?php
		$fetch_dept = $this->Admin_model->fetch_depts();
		if($fetch_dept) {
			foreach($fetch_dept as $dept) {
		?>
		<tr>
			<td class="text-center"><a href="<?php echo base_url();?>admin/Departments/Update_Department?id=<?php echo $dept->dept_id?>" title="update"><i class="fas fa-edit text-primary" style="font-size: 18px"></i></a></td>
			<td class="text-center"><?php echo $dept->dept_name;?></td>
			<td class="text-center"><?php echo $dept->fac_name;?></td>
			<td class="text-center"><?php echo $dept->chair_person;?></td>
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
	redirect('admin/Departments/Add_Department');
}
?>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function() {
    $('#myTable').DataTable();
} );
</script>