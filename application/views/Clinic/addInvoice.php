<!-- Body Content Start -->
<div class="container mt-4">
    <h3 class="modal-title"><i class="fas fa-file-invoice-dollar"></i> Add New Invoice</h3>
</div>
<br />
<div class="container p-3 mb-5 border bg-white shadow-sm">
    <?php echo form_open(base_url('Clinic/Payments/addInvoice'));?>
        <div class="row border-bottom pb-3">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="paymentDate">Invoice Date:</label>
                    <?php echo form_input(['class'=>'form-control bg-white','required', 'readonly'=>'',
                        'name'=>'paymentDate','value'=>date('Y-m-d')])?>
                    <?php echo form_error('paymentDate')?>
                </div>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-6 col-md-6 col-sm-12">
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
                    <label for="paymentTypeId">Payment Type:</label>
                    <select class="form-control border" id="paymentTypeId"
                            name="paymentTypeId" required >
                        <option value="">Select Type</option>
                        <?php
                        foreach($paymentType as $row){ ?>
                            <option data-cost="<?=$row->suggestedAmount?>" value="<?=$row->paymentTypeIdPK?>">
                                <?=$row->paymentType?>
                            </option>
                        <?php }
                        ?>
                    </select>
                    <?php echo form_error('paymentTypeId')?>
                </div>
            </div>
        </div>
        <div class="row border-top pt-3 mt-1">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="amountDue">Amount:</label>
                    <?php echo form_input(['class'=>'form-control','type'=>'number', 'id'=>'amountDue',
                        'placeholder'=>'Enter Amount','required', 'min'=>'0', 'required'=>'',
                        'name'=>'amountDue','value'=>set_value('amountDue')])?>
                    <?php echo form_error('amountDue')?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="discount">Discount:</label>
                    <?php echo form_input(['class'=>'form-control','type'=>'number',  'id'=>'discount',
                        'placeholder'=>'Enter Discount', 'min'=>'0',
                        'name'=>'discount'])?>
                    <?php echo form_error('discount')?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="balanceDue">Balance Due:</label>
                    <?php echo form_input(['class'=>'form-control bg-white','type'=>'text', 'id'=>'balanceDue',
                        'placeholder'=>'Balance Due','readonly'=>''])?>
                    <?php echo form_error('balanceDue')?>
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
<script type="text/javascript">
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

</script>
