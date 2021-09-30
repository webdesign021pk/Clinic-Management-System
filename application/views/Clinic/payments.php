<?php
$navClass='';
if($this->uri->segment(4)==''){
    $navClass = ' active';
} ;
?>
<!-- Body Content Start -->
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <h3>
                <i class="fas fa-list"></i> Payments / Invoices
            </h3>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 d-none">
            <a href="<?=base_url('Clinic/Payments/addInvoice')?>" class="btn btn-info float-right mx-1">
                <i class="fas fa-file-invoice-dollar"></i> New Invoice
            </a>
        </div>
        <br />
        <br />
        <div class="col-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?=$navClass?> <?php if($this->uri->segment(4)=='Payments'){echo ' active';} ;?>"
                       data-toggle="tab" href="#Payments">Payments (Unpaid)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($this->uri->segment(4)=='Invoices'){echo ' active';} ;?>"
                       data-toggle="tab" href="#Invoices">Invoices (Paid)</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container <?=$navClass?> <?php if($this->uri->segment(4)=='Payments'){echo ' active';} ;?>
                            pt-3 pl-0" id="Payments">
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered" id="PaymentsTable">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Payment For</th>
                                <th>Cost</th>
                                <th>Discount</th>
                                <th>Amount Due</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            if($payments){
                                foreach($payments as $payment){?>
                                    <tr class="py-1">
                                        <td class="py-1">
                                            <?=$payment->paymentDate?>
                                        </td>
                                        <td class="py-1">
                                            <?=$payment->p_firstName?>&nbsp;
                                            <?=$payment->p_lastName?>
                                        </td>
                                        <td class="py-1">
                                            <?=$payment->paymentType?>
                                        </td>
                                        <td class="py-1">
                                            <?=$payment->amountDue?>
                                        </td>
                                        <td class="py-1">
                                            <?=$payment->discount?>
                                        </td>
                                        <td class="py-1">
                                            <?=$payment->amountDue-$payment->discount?>
                                        </td>
                                        <td class="py-1">
                                            <a  href="<?=base_url('Clinic/Payments/payInvoice/'.$payment->paymentIdPK); ?>"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-wallet"></i> Pay
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane container <?php if($this->uri->segment(4)=='Invoices'){echo ' active';};?>
                             pt-3 pl-0" id="Invoices">
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered" id="InvoicesTable">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>Date</th>
                                <th>Patient Name</th>
                                <th>Payment For</th>
                                <th>Cost & Discount</th>
                                <th>Amount Due</th>
                                <th>Amount Paid</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            if($invoices){
                                foreach($invoices as $invoice){?>
                                    <tr class="py-1">
                                        <td class="py-1">
                                            <?=$invoice->paymentDate?>
                                        </td>
                                        <td class="py-1">
                                            <?=$invoice->p_firstName?>&nbsp;
                                            <?=$invoice->p_lastName?>
                                        </td>
                                        <td class="py-1">
                                            <?=$invoice->paymentType?>
                                        </td>
                                        <td class="py-1">
                                            Cost: <span class="float-right bg-light-green px-2 rounded"><?=$invoice->amountDue?></span><br />
                                            Discount: <span class="float-right bg-light-brown px-2 rounded"><?=$invoice->discount?></span>
                                        </td>
                                        <td class="py-1" align="right">
                                            <?=$invoice->amountDue-$invoice->discount?>
                                        </td>
                                        <td class="py-1" align="right">
                                            <?=$invoice->amountPaid?>
                                        </td>
                                        <td class="py-1">
                                            <a  href="<?=base_url('Clinic/Payments/viewInvoice/'.$invoice->paymentIdPK); ?>"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-file-invoice-dollar"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Body Content End -->

<script>
    $(document).ready(function(){
        $("#PaymentsTable").fancyTable({
            pagination: true,
            perPage:20,
            globalSearch: true,
            sortable: false,
            globalSearchExcludeColumns: [4,5,6,7],
            inputPlaceholder: 'Search by Name / Date / Payment Purpose',
            inputStyle: 'margin-top:1rem; margin-bottom:1rem;'
        });
        $("#InvoicesTable").fancyTable({
            pagination: true,
            perPage:20,
            globalSearch: true,
            sortable: false,
            globalSearchExcludeColumns: [4,5,6,7],
            inputPlaceholder: 'Search by Name / Date / Payment Purpose',
            inputStyle: 'margin-top:1rem; margin-bottom:1rem;'
        });
    });
</script>