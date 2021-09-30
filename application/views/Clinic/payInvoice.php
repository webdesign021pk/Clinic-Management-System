<?php
$id=$this->uri->segment(4);
//$balance=$payment->amountDue-$payment->discount;
if(!$payment)
{
    redirect('Clinic/Payments/viewInvoice/'.$id);
}
?>
<!-- Body Content Start -->
<div class="container mt-4">
    <h3 class="modal-title"><i class="fas fa-dollar-sign"></i> Make Payment</h3>
</div>
<br />
<div class="container p-3 mb-5 border bg-white shadow-sm">
    <form class="addInvoice" action="<?=base_url('Clinic/Payments/payInvoice/'.$payment->paymentIdPK)?>" method="post">
        <div class="row border-bottom pb-2">
            <div class="col-lg-6">
                <table class="table table-responsive">
                    <tr>
                        <td class="py-0 border-0">Clinic Name:</td>
                        <td class="py-0 border-0"><?=$_SESSION['ClinicName']?></td>
                    </tr>
                    <tr>
                        <td class="py-0 border-0">Address</td>
                        <td class="py-0 border-0"><?=$_SESSION['ClinicAddress']?></td>
                    </tr>
                    <tr>
                        <td class="py-0 border-0">Contact</td>
                        <td class="py-0 border-0"><?=$_SESSION['ClinicContact1']?> / <?=$_SESSION['ClinicContact2']?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6">
                <p style="font-size: 1.1rem" class="float-right">
                    Invoice Number: <span class="float-right"><?=$payment->paymentIdPK?></span><br />
                    Invoice Date: <span class="ml-5 float-right"><?=$payment->paymentDate?></span>
                </p>
            </div>
        </div>
        <div class="row border-bottom pt-2">
            <div class="col-lg-6">
                <table class="table table-responsive">
                    <tr>
                        <td class="py-0 border-0">Patient' ID:</td>
                        <td class="py-0 border-0"><?=$payment->patientIdPK?></td>
                    </tr>
                    <tr>
                        <td class="py-0 border-0">Patient' Name:</td>
                        <td class="py-0 border-0"><?=$payment->p_firstName?>&nbsp;<?=$payment->p_lastName?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row border-top pt-3 mt-1">
            <div class="col-lg-12">
                <table class="table table-responsive">
                    <thead class="table-dark">
                    <tr>
                        <th>Payment For</th>
                        <th width="20%">Amount Due</th>
                        <th width="20%">Discount</th>
                        <th width="20%">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?=$payment->paymentType?></td>
                        <td>
                            <span id="amountDue"><?=$payment->amountDue?></span>
                        </td>
                        <td>
                            <?php echo form_input(['class'=>'form-control','type'=>'number',  'id'=>'discount',
                                'placeholder'=>'Enter Discount', 'min'=>'0', 'value'=>$payment->discount,
                                'name'=>'discount', 'required'=>''])?>
                            <?php echo form_error('discount')?>
                        </td>
                        <td>
                            <?php echo form_input(['class'=>'form-control','type'=>'number', 'id'=>'balanceDue', 'readonly'=>'',
                                'placeholder'=>'Balance Due', 'min'=>'0', 'value'=>$payment->amountDue-$payment->discount,
                            'name'=>'amountPaid'])?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-4 ml-auto float-right my-1">
                <div class="form-group-sm">
                    <label for="">Amount Paid:</label>
                    <?php echo form_input(['class'=>'form-control-sm bg-white float-right','type'=>'text', 'id'=>'paid',
                        'placeholder'=>'Amount Paid'])?>
                    <?php echo form_error('')?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-4 ml-auto float-right my-1">
                <div class="form-group-sm">
                    <label for="changeDue">Change Due:</label>
                    <input type="hidden" name="paymentStatus" value="1">
                    <input type="hidden" name="appointmentId" value="<?=$payment->appointmentId?>">
                    <?php echo form_input(['class'=>'form-control-sm bg-white float-right','type'=>'text', 'id'=>'changeDue',
                        'placeholder'=>'Change Due','readonly'=>''])?>
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
    $('#paid').on('change', function() {
        var paid=this.value;
        var due = $('#balanceDue').val();
        $('#changeDue').val(paid-due);
    });
    $('#discount').on('change', function() {
        if($('#amountDue').text()!=0 || $('#amountDue').text()!=''){
            var discount=this.value;
            var due = $('#amountDue').text();
            var balance = due-discount;
            $('#balanceDue').val(balance);
            $('#amountPaid').val(balance);
        } else {
            alert('Please select payment type or enter payment Amount');
            $('#discount').val(0);
        }
    });
    $('form.addInvoice').on('submit', function(form){
        form.preventDefault();
        if( $('#paid').val()>$('#balanceDue').val() || $('#paid').val()===$('#balanceDue').val() ){
            $(this).unbind('submit').submit();
        } else {
            alert('Payment amount must be greater than OR equal to Total Due');
        }
    });

</script>
