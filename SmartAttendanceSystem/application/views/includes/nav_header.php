<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
  <!-- Custom fonts for this template-->
  <link href="<?= base_url(); ?>assets/vendor/bootstrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!--<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>vendor/datatables/datatables.min.css"/>-->
  <script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">

    <!--data table-->
  
  <!-- Custom styles for this template-->
  <link href="<?= base_url(); ?>assets/vendor/bootstrap/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/vendor/toastr/toastr.min.css" rel="stylesheet">
  <!-- <link href="<?= base_url(); ?>assets/css/style.scss" rel="stylesheet"> -->
  <style>
     .collapse-item{
font-size: 15px;
    }
 
    @media screen and (max-width: 500px) {
  .collapse-item{
font-size: 9px;
    }
    .txt{
      font-size: 9px;
    }

}
   
  </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #05386B">



        <div class="sidebar-heading-text text-white text-center mt-4 mb-4" style="font-size: 20px; font-weight: bold">BUITEMS Smart Attendance<br>System</div>
      <!-- </a>  -->

      <!-- Divider -->
<hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a id="students" class="nav-link" href="<?php echo base_url();?>admin/Students">
         <i class="fas fa-users text-light" aria-hidden="true"></i>
          <span>Students</span></a>
      </li>
<hr class="sidebar-divider my-0">

      <!-- Nav Item - customer -->
            <li class="nav-item">
        <a id="students" class="nav-link" href="<?php echo base_url();?>admin/Instructor">
         <i class="fas fa-chalkboard-teacher text-light"></i>
          <span>Instructors</span></a>
      </li>
 
<hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a id="dept" class="nav-link" href="<?php echo base_url();?>admin/Departments">
         <i class="fa fa-building text-light" aria-hidden="true"></i>
          <span>Departments</span></a>
      </li>
      <hr class="sidebar-divider my-0">
      
      <li class="nav-item">
        <a id="dept" class="nav-link" href="<?php echo base_url();?>admin/Courses">
         <i class="fa fa-book text-light" aria-hidden="true"></i>
          <span>Courses</span></a>
      </li>
        
   <hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a id="dept" class="nav-link" href="<?php echo base_url();?>admin/Classes">
        <i class="fas fa-chalkboard text-light"></i>
          <span>Classes</span></a>
      </li>
      
         <hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a id="dept" class="nav-link" href="<?php echo base_url();?>admin/AssignedClasses">
        <i class="fas fa-list text-light"></i>
          <span>Assigned Classes</span></a>
      </li>
      
         <hr class="sidebar-divider my-0">

      <li class="nav-item">
        <a id="dept" class="nav-link" href="<?php echo base_url();?>admin/StudentsAttendance">
        <i class="fa fa-hourglass" aria-hidden="true"></i>
          <span>Students Attendance</span></a>
      </li>

   <b><hr class="sidebar-divider my-0"></b>

      <li class="nav-item mt-2">
        <a id="dept" class="nav-link" href="<?php echo base_url();?>admin/Signin/sign_out">
        <i class="fas fa-sign-out-alt text-light"></i>
          <span style="font-size: 16px">Logout</span></a>
      </li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" style="background-color: whitesmoke">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-default topbar mb-4 static-top shadow">
<div class="input-group md-form form-sm form-1 pl-0 ml-2" style="margin-right: 5%">
  <div class="input-group-prepend">
    <span class="input-group-text rounded-0" id="basic-text1" style="border-right: 12px; border-left: 12px; border-top: 12px;" hidden><i class="fas fa-search text-white"
        aria-hidden="true" hidden></i></span>
  </div>
  <input class="form-control my-0 py-1 rounded-0" type="text" id="theSearch" placeholder="Search" aria-label="Search" style="border-right: 12px; border-left: 12px; border-top: 12px;" hidden>
</div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

       <li class="nav-item dropdown no-arrow">
 
       </li>

          <li class="nav-item dropdown no-arrow">
        <a id="dept" href="<?php echo base_url();?>admin/AccountSettings" class="nav-link dropdown-toggle" style="color: #05386B; font-size: 15px; font-weight: bold">
     <i class="fas fa-cog"></i>&nbsp;Account Settings&nbsp;</a>
      </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
