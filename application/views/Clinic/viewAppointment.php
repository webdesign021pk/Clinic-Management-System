<!-- Body Content Start -->
<?php
if($appointment){
?>
<div class="container-fluid">
    <div class="row pt-3">
        <div class="col-lg-3 col-md-12 col-sm-12">
            <h3><i class="fas fa-file-medical"></i> Appointment</h3>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 text-right">
            <h6 class="mt-2">
                Appointment Date: <span class=" bg-warning rounded px-2 mx-4"><?=$appointment->appointmentDate?></span>
                Appointment Time: <span class=" bg-warning rounded px-2 mx-4"><?=$appointment->timeSlot?></span>
            </h6>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-lg-4 col-md-5 col-sm-12 p-3">
            <div class=" bg-white rounded shadow-sm p-3 py-1">
                <div class="" style="overflow-x: auto">
                    <table class="table table-responsive table-bordered mb-0" id="">
                        <?php
                        if($appointment){ ?>
                            <tr class="">
                                <th class="py-1">Full Name</th>
                                <td class="py-1">
                                    <a href="<?=base_url('Clinic/Patients/MR/'.$appointment->patientIdPK)?>">
                                        <?=$appointment->p_firstName?>&nbsp;<?=$appointment->p_lastName?>
                                    </a>
                                </td>
                            </tr>
                            <tr class="">
                                <th class="py-1">Gender</th>
                                <td class="py-1">
                                    <?php
                                    if($appointment->gender=1){echo 'Male';}
                                    elseif($appointment->gender=2){echo 'Female';}
                                    ?>
                                </td>
                            </tr>
                            <tr class="">
                                <th class="py-1">Age</th>
                                <td class="py-1">
                                    <?php
                                    $date = new DateTime($appointment->dob);
                                    $now = new DateTime();
                                    $interval = $now->diff($date);
                                    if(($interval->y)<1){
                                        $age = $interval->m.' Months';
                                    } else {
                                        $age = $interval->y.' Years';
                                    }
                                    echo $age;
                                    ?>
                                </td>
                            </tr>
                            <tr class="">
                                <th class="py-1">Contact</th>
                                <td class="py-1"><?=$appointment->contact1?> / <?=$appointment->contact2?></td>
                            </tr>
                            <tr class="">
                                <th class="py-1">Address</th>
                                <td class="py-1"><?=$appointment->address?></td>
                            </tr>
                        <?php } else {echo "<tr><td>No record available</td></tr>";} ?>
                    </table>
                </div>
            </div>
            <br />
            <!--Vitals-->
            <div class=" bg-white rounded shadow-sm p-3">
                <h4 class="my-2 ml-2"><i class="fas fa-heartbeat"></i> Vitals</h4>
                <form class="addVitals" method="post">
                    <div class="row p-2 pt-3">
                        <div class="col-12">
                            <div class="form-group-sm">
                                <label >Heart Rate (BPM)</label>
                                <input type="hidden" name="appointmentIdPK" value="<?=$appointment->appointmentIdPK?>">
                                <input class="form-control" name="pulse" autocomplete="off"
                                       value="<?=set_value('pulse', $appointment->pulse); ?>"
                                    <?php if($appointment->pulse!=0){echo 'disabled';}?> >
                                <?php echo form_error('pulse')?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-sm">
                                <label >Temperature (C)</label>
                                <input class="form-control" name="temperature" autocomplete="off"
                                       value="<?= set_value('temperature', $appointment->temperature); ?>"
                                    <?php if($appointment->temperature!=0){echo 'disabled';}?> >
                                <?php echo form_error('contact1')?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-sm">
                                <label >BP (Systolic) (mmHg)</label>
                                <input class="form-control" name="bpUp" autocomplete="off"
                                       value="<?= set_value('bpUp', $appointment->bpUp); ?>"
                                    <?php if($appointment->bpUp!=0){echo 'disabled';}?> >
                                <?php echo form_error('bpUp')?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-sm">
                                <label >BP (Diastolic) (mmHg)</label>
                                <input class="form-control" name="bpDown" autocomplete="off"
                                       value="<?= set_value('bpDown', $appointment->bpDown); ?>"
                                    <?php if($appointment->bpDown!=0){echo 'disabled';}?> >
                                <?php echo form_error('bpDown')?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-sm">
                                <label >Weight (kg)</label>
                                <input class="form-control" name="weight" autocomplete="off"
                                       value="<?= set_value('weight', $appointment->weight); ?>"
                                    <?php if($appointment->weight!=0){echo 'disabled';}?> >
                                <?php echo form_error('weight')?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group-sm">
                                <label >Height (cm)</label>
                                <input class="form-control" name="height" autocomplete="off"
                                       value="<?= set_value('height', $appointment->height); ?>"
                                    <?php if($appointment->height!=0){echo 'disabled';}?> >
                                <?php echo form_error('height')?>
                            </div>
                        </div>
                        <?php if($appointment->appointmentStatus!=2){?>
                        <div class="col-12 pt-lg-3">
                            <button class="mt-lg-3 btn btn-sm btn-primary float-right" id="saveVitals">Save Vitals</button>
                        </div>
                        <?php } ?>
                        <div class="col-12 my-1">
                            <div class="jsError mt-1"></div>
                        </div>
                    </div>
                </form>
            </div>
            <!--Vitals-->
        </div>
        <div class="col-lg-8 col-md-7 col-sm-12 p-3">
            <!--Consultation-->
            <div class=" bg-white rounded shadow-sm p-3">
                <h4 class="my-2 ml-2">
                    <i class="fas fa-stethoscope"></i> Consultation
                    <span class="ml-2">
                        <span class="bg-info text-white py-2 px-3 ml-3 rounded">
                           Dr. <?=$appointment->d_firstName?>&nbsp;<?=$appointment->d_lastName?>
                        </span>
                        <?php if($appointment->isPaid==0){?>
                        <span class="bg-danger text-white py-1 px-3 ml-3 rounded">
                            Unpaid
                        </span>
                            <?php if($appointment->paymentID==0) {?>
                            <button type="button" class="btn btn-primary btn-sm ml-3" data-toggle="modal" data-target="#myModal">
                                Add invoice
                            </button>
                            <?php } elseif($appointment->paymentID!=0) {?>
                            <a href="<?=base_url('Clinic/Payments/payInvoice/'.$appointment->paymentID)?>" class="btn btn-success btn-sm ml-3">
                                Pay
                            </a>
                            <?php } ?>

                        <?php } else {?>
                        <span class="bg-success text-white py-2 px-3 ml-3 rounded">
                            Paid
                        </span>
                        <?php } ?>
                    </span>
                </h4>
                <div class="row p-2">
                        <div class="col-12">
                            <?php if($appointment->image_path==''){ ?>
                            <h6 > Upload Consultation:</h6>
                            <form action="<?=base_url('Clinic/Appointments/uploadConsultation/'.$appointment->appointmentIdPK)?>" method="post"
                                  enctype="multipart/form-data">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="userfile">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Upload</button>
                                    </div>
                                </div>
                                <?php if(isset($error)){ echo $error;}?>
                            </form>
                            <?php } else { ?>
                                <a href="javascript:void(0);"
                                   onclick='window.open("<?=base_url($appointment->image_path)?>", "MsgWindow",
                                    "width=550,height=650,menubar=1,location=0")'>
                                    <i class="fas fa-location-arrow"></i>
                                    View Consultation Notes
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <form class="" method="post">
                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="form-group-sm">
                                <label >Complaints</label>
                                <input type="hidden" name="appointmentStatus" value="2">
                                <input class="form-control" name="complaints" autocomplete="off"
                                       value="<?=set_value('complaints', $appointment->complaints); ?>"
                                    <?php if($appointment->complaints!=''){echo 'disabled';}?> >
                                <?php echo form_error('complaints')?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group-sm">
                                <label >Diagnosis</label>
                                <input class="form-control" name="diagnosis" autocomplete="off"
                                       value="<?=set_value('diagnosis', $appointment->diagnosis); ?>"
                                    <?php if($appointment->diagnosis!=''){echo 'disabled';}?> >
                                <?php echo form_error('diagnosis')?>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group-sm">
                                <label >Clinical Notes</label>
                                <?php
                                $state='false';
                                $disabled='';
                                if($appointment->diagnosis!=''){$state='true'; $disabled='disabled';}
                                $data = array(
                                    'name'        => 'clinicalNotes',
                                    'value'       => set_value('clinicalNotes', $appointment->clinicalNotes),
                                    'rows'        => '7',
                                    'class'       => 'form-control',
                                    $disabled =>$state,
                                );
                                echo form_textarea($data);
                                ?>
                                <?php echo form_error('clinicalNotes')?>
                            </div>
                        </div>
                        <?php if($appointment->appointmentStatus!=2){?>
                        <div class="col-12 my-2">
                            <button class="btn btn-primary float-right">Save</button>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <!--Consultation-->
            <br />
            <!--Reports-->
            <div class=" bg-white rounded shadow-sm px-3 py-1">
                <h4 class="my-2 ml-2"><i class="fas fa-vials"></i> Reports </h4>
                <?php
                if($reports){?>
                    <table class="table table-responsive">
                        <tr class="bg-dark text-white">
                            <th>Id</th>
                            <th>Report w/Date</th>
                        </tr>
                        <?php foreach($reports as $report){?>
                            <tr>
                                <td><?=$report->reportIdPK?></td>
                                <td>
                                    <a href="javascript:void(0);" onclick='window.open("<?=base_url($report->image_path)?>", "MsgWindow",
                                        "width=550,height=650,menubar=1,location=0")'>
                                        <?=$report->reportTitle?>&nbsp;(<?=$report->reportDate?>)
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else {?>
                    <p>No reports found!</p>
                <?php }?>
            </div>
            <!--Reports-->
        </div>
    </div>
</div>
<br />
<div id="result"></div>
<!-- Body Content End -->
<?php } else {?>
    <br />
    <div class="row">
        <div class="col-12 text-center">
            <span class="alert alert-warning">No Record Found!</span>
        </div>
    </div>
<?php } ?>

<!-- The Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Invoice</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="post" class="addInvoice">
            <!-- Modal body -->
            <div class="modal-body">
                <!--Payment-->
                <div class="row pt-1 ">
                    <div class="col-12">
                        <div class="jsError2"></div>
                    </div>
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="amountDue">Amount:</label>
                            <?php echo form_input(['class'=>'form-control','type'=>'number', 'id'=>'amountDue',
                                'placeholder'=>'Select Payment Type','required', 'min'=>'0', 'required'=>'', 'readonly'=>'',
                                'name'=>'amountDue','value'=>set_value('amountDue')])?>
                            <?php echo form_error('amountDue')?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <input type="hidden" name="patientId" value="<?=$appointment->patientIdPK?>">
                        <input type="hidden" name="paymentDate" value="<?=date('Y-m-d');?>">
                        <input type="hidden" name="appointmentId" value="<?=$appointment->appointmentIdPK;?>">
                    </div>
                </div>
                <!--Payment-->
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Add Invoice</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('form.addVitals').on('submit', function(form){
        form.preventDefault();
        $.post('<?=base_url("Clinic/NoUI/addVitals/".$appointment->appointmentIdPK)?>', $('form.addVitals').serialize(), function(data){
            if(data=='1'){
                alert('Vitals Saved');
                $('#saveVitals').css('display','none');
                $('#notification').css('display','none');
                //location.reload();
            } else {
                $('div.jsError').html(data);
            }
        });
    });
    $('#paymentTypeId').on('change', function() {
        var cost = $(this).children(':selected').data('cost');
        //alert(this.value);
        $('#amountDue').val(cost);
    });
    $('form.addInvoice').on('submit', function(form){
        form.preventDefault();
        $.post('<?=base_url("Clinic/NoUI/addInvoice")?>', $('form.addInvoice').serialize(), function(data){
            if(data=='1'){
                /*alert('Vitals Saved');
                $('#saveVitals').css('display','none');
                $('#notification').css('display','none');*/
                location.reload();
            } else {
                $('div.jsError2').html(data);
            }
        });
    });

</script>