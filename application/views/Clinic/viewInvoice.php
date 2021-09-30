<?php
if(!$payment)
{
    redirect('Clinic/Payments');
}
?>
<!-- Body Content Start -->
<div class="container mt-4">
    <div class="row">
        <div class="col-10">
            <h3 class="modal-title">
                <i class="fas fa-file-invoice-dollar"></i> Invoice &nbsp;
                <small style="font-size: 1rem">
                    <a href="<?=base_url('Clinic/Payments/index/Invoices')?>">
                        <i class="fas fa-angle-double-left"></i> Return to Invoices
                    </a>
                </small>
            </h3>
        </div>
        <div class="col-2">
            <button onclick="$('#invoice').printThis();" class="btn btn-success"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>
</div>
<br />
<div class="container p-3 mb-4 border bg-white shadow-sm" id="invoice">
    <div class="row border-bottom pb-2">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <table class="table">
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
        <div class="col-lg-6 col-md-4 col-sm-12">
            <p style="font-size: 1.1rem" class="float-right">
                Invoice Number: <span class="float-right"><?=$payment->paymentIdPK?></span><br />
                Invoice Date: <span class="ml-5 float-right"><?=$payment->paymentDate?></span>
            </p>
        </div>
    </div>
    <div class="row border-bottom pt-2">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <table class="table table-responsive">
                <tr>
                    <td class="py-0 border-0">Patient's ID:</td>
                    <td class="py-0 border-0"><?=$payment->patientIdPK?></td>
                </tr>
                <tr>
                    <td class="py-0 border-0">Patient's Name:</td>
                    <td class="py-0 border-0"><?=$payment->p_firstName?>&nbsp;<?=$payment->p_lastName?></td>
                </tr>
                <tr>
                    <td class="py-0 border-0">Appointment ID:</td>
                    <td class="py-0 border-0">
                        <a href="<?=base_url('Clinic/Appointments/View/'.$payment->appointmentId)?>">
                            <?=$payment->appointmentId?> <i class="fas fa-notes-medical"></i>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row border-top pt-3 mt-1">
        <div class="col-12">
            <table class="table table-bordered w-100">
                <thead class="table-dark">
                <tr>
                    <th>Payment For</th>
                    <th>Cost</th>
                    <th>Discount</th>
                    <th>Amount Due</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="">
                        <?=$payment->paymentType?>
                    </td>
                    <td class="">
                        <span class="bg-light-green px-2 rounded"><?=$payment->amountDue?></span><br />
                    </td>
                    <td class="">
                        <span class="bg-light-brown px-2 rounded"><?=$payment->discount?></span>
                    </td>
                    <td class="">
                        <?=$payment->amountDue-$payment->discount?>
                    </td>
                </tr>
                </tbody>
                <tfoot class="">
                <tr>
                    <th colspan="3" class="text-right">Amount Paid:</th>
                    <td ><?=$payment->amountPaid?></td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Balance:</th>
                    <td ><?=($payment->amountPaid)-($payment->amountDue-$payment->discount)?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<br />
<script type="text/javascript">

</script>
