<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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

.vl {
  border-left: 1px solid white;
  height: 10%;
}
   
  </style>
</head>
<body id="page-top">

      <!-- Main Content -->
      <div id="content" class="bg-white">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top" style="background-color: #05386B">

          <div class="topbar-heading-text text-white text-center mt-4 mb-4" style="font-size: 20px; font-weight: bold">BUITEMS Smart Attendance System</div>

       <!--    <div class="vl ml-4" style="height: 100%"></div> -->

          <div class="text-white text-center ml-4" style="font-size: 17px">
          <a href="Home" class=" nav-link text-white"><i class="fas fa-home" style="font-size: 14px"></i>&nbsp;Home</a>
        </div>
          <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown no-arrow">
        <a id="dept" class="nav-link text-white dropdown-toggle" style="font-size: 17px;" href="<?php echo base_url();?>instructor/Signin/sign_out">
     <i class="fas fa-sign-out-alt" style="font-size: 14px"></i>&nbsp;Logout</a>
      </li>

          </ul>

        </nav>