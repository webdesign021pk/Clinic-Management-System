<?php $_SESSION['ClinicName']= 'Get Well Soon Clinic';?>
<?php $_SESSION['ClinicAddress']= '2763 Fort Campbell Blvd #7554';?>
<?php $_SESSION['ClinicContact1']= '7057934986';?>
<?php $_SESSION['ClinicContact2']= '7057934989';?>
<?php $title=$_SESSION['ClinicName']?>
<!doctype html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">    
    <title><?=$title?></title>
    <link href="<?=base_url('Assets/img/favicon.ico')?>" type="image/x-icon" rel="icon"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Required meta tags -->    
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Website Designing and Web Application Development">
    <meta name="author" content="Rashid Rafiq">
    <meta name="robots" content="index, follow">
    <!-- Bootstrap CSS -->
    <?= link_tag("Assets/bootstrap/css/bootstrap.min.css")?>
    <?= link_tag("Assets/bootstrap/css/sticky-footer.css")?>
    <script src="https://kit.fontawesome.com/0281032158.js" crossorigin="anonymous"></script>
    <style>
        @media print {
            #printPageButton {
                display: none;
            }
        }
    </style>
</head>
<body class="">
<div class="container-fluid">
    <div class="clearfix"></div>
