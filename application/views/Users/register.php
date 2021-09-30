<html>
<head>
    <style>
        /* Sticky footer styles
-------------------------------------------------- */
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 60px; /* Margin bottom by footer height */
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px; /* Set the fixed height of the footer here */
            line-height: 60px; /* Vertically center the text there */
            /*background-color: #f5f5f5;*/
            background-color: #ffffff;
        }
    </style>
    <script src="<?=base_url('Assets/js/jquery-3.4.1.min.js')?>"></script>
    <?= link_tag("Assets/css/bootstrap.min.css")?>
    <script src="https://kit.fontawesome.com/0281032158.js" crossorigin="anonymous"></script>
</head>
<body class="" style="background-color: #f2f2f2 !important;">
<div class="bg-dark text-light text-center align-center" style="height: 38px">
    <a class="navbar-brand mt-auto mb-auto"><i class="fas fa-book-open"></i> Book Lending System</a>
</div>
<div class="container mt-5">
    <div class=" col-lg-8 align-center mx-auto">
        <h3 class="mb-2 mt-3 text-center">Registration Form</h3>
        <?php if ($error=$this->session->flashdata('loginFailed')) :?>
            <div class="w-100">
                <div class="alert alert-danger">
                    <?= $error; ?>
                </div>
            </div>
        <?php endif?>
        <?php echo form_open("Admin/register"); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="userName">User Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter Username','name'=>'userName','value'=>set_value('userName'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('userName')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="userEmail">Email:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter Email','name'=>'userEmail','value'=>set_value('userEmail'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('userEmail')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <?php echo form_password(['class'=>'form-control','placeholder'=>'Enter Password','name'=>'password','value'=>set_value('password'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('password')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="confirm_pass">Confirm Password:</label>
                    <?php echo form_password(['class'=>'form-control','placeholder'=>'Enter Password','name'=>'confirm_pass','value'=>set_value('confirm_pass'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('confirm_pass')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter First Name','name'=>'firstName','value'=>set_value('firstName'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('firstName')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter Last Name','name'=>'lastName','value'=>set_value('lastName'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('lastName')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="secretQuestion">Secret Question?</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter Secret Question?','name'=>'secretQuestion','value'=>set_value('secretQuestion'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('secretQuestion')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="secretAnswer">Secret Answer:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter Secret Answer','name'=>'secretAnswer','value'=>set_value('secretAnswer'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('secretAnswer')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="userLevel">User Level</label>
                    <?php $attr3 = 'class="form-control" id="userLevel"'; ?>
                    <?php
                    $userLevel=[
                        ''=>'Select',
                        '1'=>'Secretary',
                        '2'=>'Doctor'
                    ] ?>
                    <?= form_dropdown('userLevel', $userLevel, set_value('userLevel'), $attr3); ?>
                    <?php echo form_error('userLevel')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group" id="doctor" style="display: none">
                    <label for="doctorId">Doctor Id:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter Doctor ID','name'=>'doctorId','value'=>set_value
                    ('doctorId'), 'autocomplete'=>'off', 'type'=>'number', 'min'=>0])?>
                    <?php echo form_error('doctorId')?>
                </div>
            </div>
        </div>

        <?php echo form_submit(['class'=>'btn btn-success','value'=>'Submit',''])?>
        <?php echo form_reset(['class'=>'btn btn-primary','value'=>'Reset',''])?>
        <a href="<?=base_url()?>login">Registered Already? Login Here</a>
    </div>
</div>
<br />
<br />
<br />
<script>
    $('#userLevel').change(function(){
        var str = "";
        $( "select option:selected" ).each(function() {
            str = $( this ).val();
            alert(str);
            if(str==2){
                $('#doctor').css('display','block');
            } else {
                $('#doctor').css('display','none');
            }
        });
    })
</script>