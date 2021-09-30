<!-- Body Content Start -->
<div class="container mt-4">
    <h3 class="modal-title"><i class="fas fa-notes-medical"></i> Add New Appointment</h3>
</div>
<br />
<div class="container p-3 mb-5 border bg-white shadow-sm">
    <?php echo form_open(base_url('Clinic/Appointments/add'));?>
        <div class="row">
            <div class="col-12">
                <h4 class="h4">Appointment Details</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="doctorId">Doctor:</label>
                    <select class="selectpicker form-control border "
                            data-hide-disabled="true" data-live-search="true"
                            name="doctorId" id="doctorId" required>
                        <option value="">Select Doctor</option>
                        <?php
                        foreach($doctors as $doctor){ ?>
                            <option value="<?=$doctor->doctorIdPK?>">
                                <?=$doctor->d_firstName?>&nbsp;<?=$doctor->d_lastName?>
                            </option>
                        <?php }
                        ?>
                    </select>
                    <?php echo form_error('doctorId')?>
                </div>
                <div class="form-group">
                    <label for="patientId">Patient:</label>
                    <select class="selectpicker form-control border "
                            data-hide-disabled="true" data-live-search="true"
                            name="patientId" id="patientId" required>
                        <option value="">Select Patient</option>
                        <?php
                        foreach($patients as $patient){ ?>
                            <option value="<?=$patient->patientIdPK?>">
                                <?=$patient->p_firstName?>&nbsp;<?=$patient->p_lastName?>
                            </option>
                        <?php }
                        ?>
                    </select>
                    <?php echo form_error('patientId')?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="appointmentDate">Appointment Date:</label>
                    <?php echo form_input(['class'=>'form-control','type'=>'date', 'id'=>'appointmentDate',
                        'onchange'=>'getAppointmentTime();', 'placeholder'=>'Enter Date of Birth','required', 'min'=>date('Y-m-d'),
                        'name'=>'appointmentDate','value'=>set_value('appointmentDate')])?>
                    <?php echo form_error('appointmentDate')?>
                </div>
                <div class="form-group">
                    <label for="timeSlotId">Appointment Time:</label>
                    <select style="overflow-y: auto" size="6" class="form-control" id="timeSlotId" name="timeSlotId" required>
                        <option value="">Select Date First</option>
                    </select>
                    <?php echo form_error('timeSlotId')?>
                </div>
            </div>
        </div>
        <!--Payment-->
        <!--<div class="row border-top pt-3 mt-4">
            <div class="col-12">
                <h4 class="h4">Payment Details</h4>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="paymentTypeId">Payment Type:</label>
                    <select class="form-control border" id="paymentTypeId"
                            name="paymentTypeId" required >
                        <option value="">Select Type</option>
                        <?php
/*                        foreach($paymentType as $row){ */?>
                            <option data-cost="<?/*=$row->suggestedAmount*/?>" value="<?/*=$row->paymentTypeIdPK*/?>">
                                <?/*=$row->paymentType*/?>
                            </option>
                        <?php /*}
                        */?>
                    </select>
                    <?php /*echo form_error('paymentTypeId')*/?>
                </div>
            </div>
            <div class="col-lg-6">&nbsp;</div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="amountDue">Amount:</label>
                    <?php /*echo form_input(['class'=>'form-control','type'=>'number', 'id'=>'amountDue',
                        'placeholder'=>'Enter Amount','required', 'min'=>'0', 'required'=>'',
                        'name'=>'amountDue','value'=>set_value('amountDue')])*/?>
                    <?php /*echo form_error('amountDue')*/?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="discount">Discount:</label>
                    <?php /*echo form_input(['class'=>'form-control','type'=>'number',  'id'=>'discount',
                        'placeholder'=>'Enter Discount', 'min'=>'0',
                        'name'=>'discount'])*/?>
                    <?php /*echo form_error('discount')*/?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="balanceDue">Balance Due:</label>
                    <?php /*echo form_input(['class'=>'form-control bg-white','type'=>'text', 'id'=>'balanceDue',
                        'placeholder'=>'Balance Due','readonly'=>''])*/?>
                    <?php /*echo form_error('balanceDue')*/?>
                </div>
            </div>
        </div>-->
        <!--Payment-->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-danger" onclick="location.reload();">Reset</button>
        </div>
    </form>
<!--End Body Content -->
</div>
<script type="text/javascript">
    function getAppointmentTime()
    {
        var aptDate = $('#appointmentDate').val();
        var methodUrl = '<?=base_url('Clinic/NoUI/getAppointmentTime/')?>'+aptDate;
        $.ajax({
            url: methodUrl,
            success:function(data)
            {
                $('#timeSlotId').html(data);
            }
        })
    }
    /*Payment*/
    $('#paymentTypeId').on('change', function() {
        var cost = $(this).children(':selected').data('cost');
        //alert(this.value);
        $('#amountDue').val(cost);
        $('#balanceDue').val(cost);
    });
    $('#amountDue').on('change', function() {
        var amount=this.value;
        $('#amountDue').val(amount);
        $('#balanceDue').val(amount);
    });
    $('#discount').on('change', function() {
        if($('#amountDue').val()!=0 || $('#amountDue').val()!=''){
            var discount=this.value;
            var due = $('#amountDue').val();
            var balance = due-discount;
            $('#balanceDue').val(balance);
        } else {
            alert('Please select payment type or enter payment Amount');
            $('#discount').val(0);
        }
    });
    /*Payment*/

</script>
