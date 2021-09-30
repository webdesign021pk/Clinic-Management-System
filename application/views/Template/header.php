<?php $_SESSION['userLevel']= $userDetail->userLevel;?>
<?php $_SESSION['doctorId']= $userDetail->doctorId;?>
<?php $_SESSION['year']= '2020';?>
<?php $_SESSION['ClinicName']= 'Get Well Soon Clinic';?>
<?php $_SESSION['ClinicAddress']= '2763 Fort Campbell Blvd #7554';?>
<?php $_SESSION['ClinicContact1']= '7057934986';?>
<?php $_SESSION['ClinicContact2']= '7057934989';?>
<?php $title=$_SESSION['ClinicName']?>
<?php $userlevel=$_SESSION['userLevel']?>
<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">    
    <title><?=$title;?></title>
    <link href="<?=base_url('Assets/img/favicon.ico')?>" type="image/x-icon" rel="icon"/>
    <!--Important Javascript-->
    <script src="<?=base_url('Assets/js/jquery-3.4.1.min.js')?>"></script>
    <script src="<?=base_url('Assets/js/printThis.js')?>"></script>
    <!--Important Javascript-->

    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Website Designing and Web Application Development">
    <meta name="author" content="Rashid Rafiq">
    <meta name="robots" content="index, follow">
    <!-- Required meta tags -->

    <!--Bootstrap-->
    <?php //echo link_tag("Assets/bootstrap/css/bootstrap.min.css")?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <?= link_tag("Assets/bootstrap/css/sticky-footer.css")?>
    <?= link_tag("Assets/css/custom.css")?>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="<?= base_url()?>Assets/bootstrap/js/bootstrap.js"></script>
    <!--Bootstrap-->

    <!--Font Awesome-->
    <!--<?php //echo link_tag("Assets/fontawesome/css/all.css")?>
    <script src="<?php //echo base_url('Assets/fontawesome/js/all.js')?>" crossorigin="anonymous"></script>-->
    <script src="https://kit.fontawesome.com/0281032158.js" crossorigin="anonymous"></script>
    <!--Font Awesome-->

    <!--Searchable Select-->
    <?= link_tag("Assets/css/bootstrap-select.css")?>
    <script src="<?= base_url()?>Assets/js/bootstrap-select.js"></script>
    <!--Searchable Select-->

    <!--Data Table-->
    <script src="<?= base_url()?>Assets/js/fancyTable.js"></script>
    <!--Data Table-->

    <!--Graph-->
    <script src="<?=base_url('Assets/js/jquery.flot.js')?>" crossorigin="anonymous"></script>
    <script src="<?= base_url()?>Assets/js/rGraphs/RGraph.common.core.js"></script>
    <script src="<?= base_url()?>Assets/js/rGraphs/RGraph.common.dynamic.js"></script>
    <script src="<?= base_url()?>Assets/js/rGraphs/RGraph.common.key.js"></script>
    <script src="<?= base_url()?>Assets/js/rGraphs/RGraph.drawing.rect.js"></script>
    <script src="<?= base_url()?>Assets/js/rGraphs/RGraph.line.js"></script>
    <script src="demos.js" ></script>
    <?= link_tag("Assets/css/rGraphs/demos.css")?>
    <!--Graph-->

    <!--<script src="1https://kit.fontawesome.com/0281032158.js" crossorigin="anonymous"></script>-->
    <style>

    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue">
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarsExample08"
                    aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="navbar-brand text-light"><i class="fas fa-clinic-medical"></i> <?=$title;?></span>
            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                <ul class="navbar-nav">
                    <li class="nav-item mr-1 mb-1">
                        <a class="btn btn-light rounded-0 w-100" href="<?=base_url()?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <?php if ($userlevel !=2) {?>
                    <li class="nav-item mr-1 mb-1">
                        <a class="btn btn-light rounded-0 w-100" href="<?=base_url('Clinic/Patients')?>">
                            <i class="fas fa-procedures"></i> Patients
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-item mr-1 mb-1">
                        <a class="btn btn-light rounded-0 w-100" href="<?=base_url('Clinic/Appointments')?>">
                            <i class="fas fa-notes-medical"></i> Appointments
                        </a>
                    </li>
                    <?php if ($userlevel !=2) {?>
                    <li class="nav-item mr-1 mb-1">
                        <a class="btn btn-light rounded-0 w-100" href="<?=base_url('Clinic/Payments')?>">
                            <i class="fas fa-file-invoice-dollar"></i> Payments
                        </a>
                    </li>
                    <?php } ?>
                    <li class="nav-item dropdown pr-1">
                        <a class="btn btn-light rounded-0 dropdown-toggle w-100" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i> Settings
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if ($userlevel ==4 || $userlevel ==1 ) {?>
                            <a class="dropdown-item mt-1" href="<?=base_url('Clinic/Staff')?>">
                                <i class="fas fa-user-nurse"></i> Staff
                            </a>
                            <!--<div class="dropdown-divider"></div>-->
                            <a class="dropdown-item" href="<?=base_url('Clinic/Doctors')?>">
                                <i class="fas fa-user-md"></i> Doctors
                            </a>
                            <div class="dropdown-divider"></div>
                            <?php } ?>
                            <a class="dropdown-item" href="<?=base_url('Clinic/Home/profile')?>">
                                <i class="fas fa-user-circle"></i> Profile
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <span class="navbar-brand dropdown text-light">Welcome,
                <?= $userDetail->firstName;?>
                <a class="alpha-Circle w-100" href="javascript:void(0);" id="navbarDropdown1" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=strtoupper($userDetail->firstName[0].$userDetail->lastName[0]);?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="<?=base_url('Admin/logout')?>">
                        <i class="fas fa-user-lock"></i> Logout
                    </a>
                </div>
            </span>
        </nav>
    <div class="bg-light h-100 container-fluid">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-12">
            <?php if ($error=$this->session->flashdata('msg')) :?>
                <div class="w-75 ml-auto mr-auto mt-1">
                    <div class="alert alert-<?=$this->session->flashdata('alert')?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?=$error;?>
                    </div>
                </div>
            <?php endif?>
        </div>
    </div>
    <div class="clearfix"></div>