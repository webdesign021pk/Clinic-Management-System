<!-- Body Content Start -->
<div class="container mt-4">
    <h3 class="modal-title"><i class="fas fa-user-nurse"></i> Add New Staff</h3>
</div>
<br />
<div class="container p-3 mb-5 border bg-white shadow-sm">
    <?php echo form_open(base_url('Clinic/Staff/add'));?>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="s_firstName">First Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter first name',
                        'name'=>'s_firstName','value'=>set_value('s_firstName'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('s_firstName')?>
                </div>
                <div class="form-group">
                    <label for="contact1">Contact 1:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter contact',
                        'name'=>'contact1','value'=>set_value('contact1'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('contact1')?>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'eg. Flat/House#, Plot#, Block#, Area, City',
                        'name'=>'address','value'=>set_value('address'), 'autocomplete'=>'off'])?>
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
                    <?= form_dropdown('gender', $gender, set_value('gender'), $attr3); ?>
                    <?php echo form_error('gender')?>
                </div>
                <div class="form-group">
                    <label for="staffLevel">Staff Level:</label>
                    <?php $attr4 = 'class="form-control" id="staffLevel"'; ?>
                    <?php
                    $staffLevel=[
                        ''=>'Select',
                        '1'=>'Nurse',
                        '2'=>'Compounder',
                        '3'=>'Pharmacist'
                    ] ?>
                    <?= form_dropdown('staffLevel', $staffLevel, set_value('staffLevel'), $attr4); ?>
                    <?php echo form_error('staffLevel')?>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="s_lastName">Last Name:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter last name',
                        'name'=>'s_lastName','value'=>set_value('s_lastName'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('s_lastName')?>
                </div>
                <div class="form-group">
                    <label for="contact2">Contact 2:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter contact',
                        'name'=>'contact2','value'=>set_value('contact2'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('contact2')?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <?php echo form_input(['class'=>'form-control','placeholder'=>'Enter email',
                        'name'=>'email','value'=>set_value('email'), 'autocomplete'=>'off'])?>
                    <?php echo form_error('email')?>
                </div>
                <div class="form-group">
                    <label for="dob">DOB:</label>
                    <?php echo form_input(['class'=>'form-control','type'=>'date','placeholder'=>'Enter Date of Birth',
                        'name'=>'dob','value'=>set_value('dob')])?>
                    <?php echo form_error('dob')?>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-danger" onclick="location.reload();">Reset</button>
        </div>
    </form>
<!--End Body Content -->
</div>
