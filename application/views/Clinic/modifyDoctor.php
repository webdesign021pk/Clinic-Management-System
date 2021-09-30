<!-- Body Content Start -->
<div class="container mt-4">
    <h3 class="modal-title">
        <i class="fas fa-user-md"></i> Modify Doctor &nbsp;
        <small style="font-size: 1rem">
            <a href="<?=base_url('Clinic/Doctors')?>">
                <i class="fas fa-angle-double-left"></i> Return to Doctors
            </a>
        </small>
    </h3>
</div>
<br />
<div class="container p-3 mb-5 border bg-white shadow-sm" id="modifyDoctor">
    <?php echo form_open(base_url('Clinic/Doctors/modify/'.$doctor->doctorIdPK));?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="d_firstName">First Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter first name',
                        'name'=>'d_firstName','value'=>set_value('d_firstName', $doctor->d_firstName), 'autocomplete'=>'off'])?>
                    <?php echo form_error('d_firstName')?>
                </div>
                <div class="form-group">
                    <label for="contact1">Contact 1:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter contact',
                        'name'=>'contact1','value'=>set_value('contact1', $doctor->contact1), 'autocomplete'=>'off'])?>
                    <?php echo form_error('contact1')?>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'eg. Flat/House#, Plot#, Block#, Area, City',
                        'name'=>'address','value'=>set_value('address', $doctor->address), 'autocomplete'=>'off'])?>
                    <?php echo form_error('address')?>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <?php $attr3 = 'class="form-control" id="gender"'; ?>
                    <?php
                    $gender=[
                        ''=>'Select',
                        '1'=>'Male',
                        '2'=>'Female'
                    ] ?>
                    <?= form_dropdown('gender', $gender, set_value('gender', $doctor->gender), $attr3); ?>
                    <?php echo form_error('gender')?>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="d_lastName">Last Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter last name',
                        'name'=>'d_lastName','value'=>set_value('d_lastName', $doctor->d_lastName), 'autocomplete'=>'off'])?>
                    <?php echo form_error('d_lastName')?>
                </div>
                <div class="form-group">
                    <label for="contact2">Contact 2:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter contact',
                        'name'=>'contact2','value'=>set_value('contact2', $doctor->contact2), 'autocomplete'=>'off'])?>
                    <?php echo form_error('contact2')?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter email',
                        'name'=>'email','value'=>set_value('email', $doctor->email), 'autocomplete'=>'off'])?>
                    <?php echo form_error('email')?>
                </div>
                <div class="form-group">
                    <label for="dob">DOB:</label>
                    <?php echo form_input(['class'=>'form-control','type'=>'date','placeholder'=>'Enter Date of Birth',
                        'name'=>'dob','value'=>set_value('dob', $doctor->dob)])?>
                    <?php echo form_error('dob')?>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <?php if ($_SESSION['userLevel'] ==4) {?>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-danger" onclick="location.reload();">Reset</button>
        </div>
        <?php } ?>
    </form>
<!--End Body Content -->
</div>
<?php if($_SESSION['userLevel']!=4) {?>
    <script>
        $("#modifyDoctor :input").prop("disabled", true);
    </script>
<?php } ?>
