<!-- Body Content Start -->
<div class="container p-3 mb-5">
<!-- Body Content Start -->
    <h3><i class="fas fa-user-circle"></i> User Details</h3>
    <div class="jsError"></div>
    <div class="row" id="profile">
        <div class="col-lg-12">
            <div class="alert alert-warning">
                Note: Modification of Profile Details is Disabled in Demo Version.
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <form class="mt-3" method="post">
                        <label for="userName">User Name:</label>
                        <div class="input-group mb-3">
                            <?php echo form_input([
                                    'class'=>'form-control','placeholder'=>'Enter Username',
                                    'name'=>'userName','value'=>set_value('userName', $user->userName),
                                    'autocomplete'=>'off'
                                ])?>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="alert('This Function is Disabled in Demo');" type="submit">
                                    Change <i class="fas fa-user-edit"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6">
                    <form class="mt-3" method="post">
                        <label for="userEmail">Email:</label>
                        <div class="input-group mb-3">
                            <?php echo form_input([
                                'class'=>'form-control','placeholder'=>'Enter Email',
                                'name'=>'userEmail','value'=>set_value('userEmail', $user->userEmail),
                                'autocomplete'=>'off'
                            ])?>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="alert('This Function is Disabled in Demo');" type="submit">
                                    Change <i class="fas fa-at"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <h5>Personal Details</h5>
            <form class="mt-1 border-top" method="post">
                <div class="row mt-2">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="firstName">First Name:</label>
                            <?php echo form_input([
                                'class'=>'form-control','placeholder'=>'Enter First Name',
                                'name'=>'firstName','value'=>set_value('firstName', $user->firstName),
                                'autocomplete'=>'off'
                            ])?>
                        </div>
                        <div class="form-group">
                            <label for="secretQuestion">Secret Question?</label>
                            <?php echo form_input([
                                'class'=>'form-control','placeholder'=>'Enter Secret Question?',
                                'name'=>'secretQuestion','value'=>set_value('secretQuestion', $user->secretQuestion),
                                'autocomplete'=>'off'
                            ])?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <?php echo form_input([
                                'class'=>'form-control','placeholder'=>'Enter Last Name',
                                'name'=>'lastName','value'=>set_value('lastName', $user->lastName),
                                'autocomplete'=>'off'
                            ])?>
                        </div>
                        <div class="form-group">
                            <label for="secretAnswer">Secret Answer:</label>
                            <?php echo form_input([
                                'class'=>'form-control','placeholder'=>'Enter Secret Answer',
                                'name'=>'secretAnswer','value'=>set_value('secretAnswer', $user->secretAnswer),
                                'autocomplete'=>'off'
                            ])?>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="submit" onclick="alert('This Function is Disabled in Demo');" name="others" class="btn btn-primary float-right">
                           Change Personal <i class="fas fa-address-card"></i>
                        </button>
                        <button type="button" class="btn btn-danger float-right mr-2"
                                onclick="location.reload()">Reset</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12">
            <form class="mt-3 modifyInstitute border-left"  method="post">
                <div class="row ml-3">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="oldpwd">Old Password:</label>
                            <?php echo form_password([
                                'class'=>'form-control','placeholder'=>'Enter Old Password',
                                'name'=>'oldpwd','value'=>set_value('oldpwd'),
                                'autocomplete'=>'off'
                            ])?>
                            <input type="hidden" name="userName" value="<?=$user->userName?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <?php echo form_password([
                                'class'=>'form-control','placeholder'=>'Enter New Password',
                                'name'=>'password','value'=>set_value('password'),
                                'autocomplete'=>'off'
                            ])?>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label for="confirm_pass">Confirm Password:</label>
                            <?php echo form_password([
                                'class'=>'form-control','placeholder'=>'Enter New Password',
                                'name'=>'confirm_pass','value'=>set_value('confirm_pass'),
                                'autocomplete'=>'off'
                            ])?>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <button type="submit" onclick="alert('This Function is Disabled in Demo');" class="btn btn-primary float-right">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<!--End Body Content -->
</div>
<!--End Body Content -->
<script>
        $("#profile :input").prop("disabled", true);
    </script>