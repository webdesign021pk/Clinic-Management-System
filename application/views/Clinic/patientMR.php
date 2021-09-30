<?php
$navClass='';
if($this->uri->segment(5)==''){
    $navClass = ' active';
} ;
?>
<!-- Body Content Start -->
<div class="container-fluid">
    <div class="row pt-3">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <h3>
                <i class="fas fa-file-medical"></i> Patient's Medical Record &nbsp;
                <small style="font-size: 1rem">
                    <a href="<?=base_url('Clinic/Patients')?>">
                        <i class="fas fa-angle-double-left"></i> Return to Patients
                    </a>
                </small>
            </h3>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <a href="<?=base_url('Clinic/Patients/addReport')?>" class="btn btn-info float-right mx-1">
                <i class="fas fa-notes-medical"></i> New Report
            </a>
        </div>
        <br />
        <br />
        <div class="col-lg-4 col-sm-12 mb-2">
            <div class="bg-white shadow-sm p-3" style="overflow-x: auto">
                <table class="table table-responsive table-bordered" id="">
                    <?php
                    if($patient){ ?>
                    <tr class="">
                        <th>Patient Id</th>
                        <td><?=$patient->patientIdPK?></td>
                    </tr>
                    <tr class="">
                        <th>Full Name</th>
                        <td><?=$patient->p_firstName?>&nbsp;<?=$patient->p_lastName?></td>
                    </tr>
                    <tr class="">
                        <th>Gender</th>
                        <td>
                        <?php
                        if($patient->gender=1){echo 'Male';}
                        elseif($patient->gender=2){echo 'Female';}
                        ?>
                        </td>
                    </tr>
                    <tr class="">
                        <th>Age</th>
                        <td>
                            <?php
                            $date = new DateTime($patient->dob);
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
                        <th>Contact</th>
                        <td><?=$patient->contact1?> / <?=$patient->contact2?></td>
                    </tr>
                    <tr class="">
                        <th>Address</th>
                        <td><?=$patient->address?></td>
                    </tr>
                    <?php } else {echo "<tr><td>No record available</td></tr>";} ?>
                </table>
            </div>
        </div>
        <div class="col-lg-8 col-sm-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?=$navClass?> <?php if($this->uri->segment(5)=='Charts'){echo ' active';} ;?>" data-toggle="tab"
                       href="#Charts">Health Chart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  <?php if($this->uri->segment(5)=='Appointments'){echo ' active';} ;?>" data-toggle="tab"
                       href="#Appointments">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($this->uri->segment(5)=='Reports'){echo ' active';} ;?>" data-toggle="tab" href="#Reports">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($this->uri->segment(5)=='History'){echo ' active';} ;?>" data-toggle="tab" href="#History">History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($this->uri->segment(5)=='Payments'){echo ' active';} ;?>" data-toggle="tab"
                       href="#Payments">Payments</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container <?=$navClass?> <?php if($this->uri->segment(5)=='Charts'){echo ' active';};?>
                             pt-3 pl-0" id="Charts">
                    <h4 class="mb-0"><i class="fas fa-heartbeat"></i> Blood Pressure (mmHg) & Pulse (BPM) </h4>
                    <div class="row mt-0 pt-0" style="overflow-x: auto">
                        <canvas id="cvs" class="" width="800" height="500">[No canvas support]</canvas>
                    </div>
                    <h4 class="mb-0"><i class="fas fa-thermometer-three-quarters"></i> Temperature (&#176;F) </h4>
                    <div class="row mt-0 pt-0" style="overflow-x: auto">
                        <canvas id="cvs2" class="" width="800" height="330px">[No canvas support]</canvas>
                    </div>
                    <h4 class="mb-0"><i class="fas fa-weight"></i> Weight </h4>
                    <div class="row mt-0 pt-0" style="overflow-x: auto">
                        <canvas id="cvs3" class="" width="800px" height="400px">[No canvas support]</canvas>
                    </div>
                </div>
                <div class="tab-pane container <?php if($this->uri->segment(5)=='Appointments'){echo ' active';} ;?>
                            pt-3 pl-0" id="Appointments">
                    <h4><i class="fas fa-list"></i> Appointments</h4>
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered " id="memberTable">
                            <?php
                            if($appointments){?>
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor's Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            foreach($appointments as $appointment){?>
                                <tr>
                                    <td class="py-1">
                                        <span class="" ><?=$appointment->appointmentIdPK?></span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <?=$appointment->appointmentDate?>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <?=$appointment->timeSlot?>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <?=$appointment->d_firstName?>&nbsp;
                                        <?=$appointment->d_lastName?>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <?php
                                        if($appointment->appointmentStatus=='1'){
                                            echo"<span class='badge badge-primary'>Pending</span>";
                                        } elseif ($appointment->appointmentStatus=='2'){
                                            echo"<span class='badge badge-secondary'>Completed</span>";
                                        } elseif ($appointment->appointmentStatus=='3'){
                                            echo"<span class='badge badge-danger'>Not Attended</span>";
                                        }
                                        ?>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                        <a href="<?=base_url('Clinic/Appointments/View/'.$appointment->appointmentIdPK); ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> View
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            } else { echo "No pending appointments";}
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane container <?php if($this->uri->segment(5)=='Reports'){echo ' active';};?>
                             pt-3 pl-0" id="Reports">
                    <h4><i class="fas fa-list"></i> Reports </h4>
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered " id="memberTable">
                            <?php
                            if($reports){?>
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>ID</th>
                                <th>Date</th>
                                <th>Link/View</th>
                                <th>Visibility</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            foreach($reports as $report){?>
                                <tr>
                                    <td class="py-1">
                                        <span class="" ><?=$report->reportIdPK?></span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <?=$report->reportDate?>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <a href="javascript:void(0);" onclick='window.open("<?=base_url($report->image_path)?>", "MsgWindow",
                                            "width=550,height=650,menubar=1,location=0")'>
                                            <?=$report->reportTitle?>
                                        </a>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                    <span class="" >
                                        <?php
                                        if($report->isClear=='1'){
                                            echo"<span class='badge badge-primary'>Clear</span>";
                                        } else {
                                            echo"<span class='badge badge-secondary'>Unclear</span>";
                                        }
                                        ?>
                                    </span>
                                    </td>
                                    <td class="py-1">
                                        <input type="hidden" value="<?=$report->reportIdPK?>" id="rID">
                                        <input type="hidden" value="<?=$report->image_path?>" id="imgPath">
                                        <a href="#" class="btn btn-sm btn-danger"
                                           onclick="deleteReport();">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            } else { echo "No record available";}
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane container <?php if($this->uri->segment(5)=='History'){echo ' active';};?>
                             pt-3 pl-0" id="History">
                    <h4><i class="fas fa-list"></i> History </h4>
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered " id="memberTable">
                            <?php
                            if($history){?>
                            <thead>
                            <tr class="bg-dark text-white">
                                <th width="15%">Date</th>
                                <th>Complaints</th>
                                <th>Diagnosis</th>
                                <th>Clinical Notes</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            foreach($history as $row){?>
                                <tr>
                                    <td class="py-1">
                                        <?=$row->appointmentDate?>
                                    </td>
                                    <td class="py-1">
                                        <?=$row->complaints?>
                                    </td>
                                    <td class="py-1">
                                        <?=$row->diagnosis?>
                                    </td>
                                    <td class="py-1">
                                        <?=$row->clinicalNotes?>
                                    </td>
                                    <td class="py-1">
                                        <a href="<?=base_url('Clinic/Appointments/View/'.$row->appointmentIdPK)?>" class="btn btn-sm btn-primary">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            } else { echo "No record available";}
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane container <?php if($this->uri->segment(5)=='Payments'){echo ' active';};?>
                             pt-3 pl-0" id="Payments">
                    <h4><i class="fas fa-list"></i> Payments </h4>
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered " id="memberTable">
                            <?php
                            if($payments){?>
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>Date</th>
                                <th>Payment For</th>
                                <th>Cost & Discount</th>
                                <th>Amount Due</th>
                                <th>Amount Paid</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            foreach($payments as $payment){?>
                                <tr>
                                    <td class="py-1">
                                        <?=$payment->paymentDate?>
                                    </td>
                                    <td class="py-1">
                                        <?=$payment->paymentType?>
                                    </td>
                                    <td class="py-1">
                                        Cost: <span class="float-right bg-light-green px-2 rounded"><?=$payment->amountDue?></span><br />
                                        Discount: <span class="float-right bg-light-brown px-2 rounded"><?=$payment->discount?></span>
                                    </td>
                                    <td class="py-1" align="right">
                                        <?=$payment->amountDue-$payment->discount?>
                                    </td>
                                    <td class="py-1" align="right">
                                        <?=$payment->amountPaid?>
                                    </td>
                                    <td class="py-1">
                                        <?php if($payment->paymentStatus==1){ ?>
                                            <a href="<?=base_url('Clinic/Payments/viewInvoice/'.$payment->paymentIdPK); ?>" class="btn btn-sm
                                            btn-success">View</a>
                                        <?php } else { ?>
                                            <a href="<?=base_url('Clinic/Payments/payInvoice/'.$payment->paymentIdPK); ?>" class="btn btn-sm btn-primary">Pay</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            } else { echo "No record available";}
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Body Content End -->
<br />

<!--Temp-->
<script>
    new RGraph.Line({
        id:'cvs2',
        data: [
            [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $temperature){
                        echo $temperature->temperature.',';
                        }
                    }
                ?>
            ]
        ],
        options: {
            colors: ['red', 'blue'],
            tickmarksStyle: ['filledcircle'],
            tickmarksSize: 2,
            linewidth: 1,
            shadow: false,
            spline:true,
            yaxisScaleUnitsPre: '',
            yaxisScaleUnitsPost: ' F',
            backgroundGridHlinesCount: 35,
            backgroundGridVlines: true,
            backgroundGridBorder: false,
            backgroundColor: '#fff',
            marginInner: 1,
            xaxisLabels: [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $down){
                        $time=strtotime($down->appointmentDate);
                        $month=date("F",$time);
                        $day=date("d-m",$time);
                        echo "'".$day."',";
                        }
                    }
                ?>
            ],
            labelsAbove: true,
            labelsAboveBorder: false,
            labelsAboveDecimals: 1,
            labelsAboveSize: 9,
            yaxisScaleMax: 115,
            yaxisScaleMin: 80,
            yaxisLabelsCount: 7,
            yaxisTickmarksCount: 7,
            marginLeft: 50,
            textSize: 9,
            yaxisLabelsOffsetx: -5
        }
    }).draw();
</script>
<!--Temp-->
<!--Weight-->
<script>
    new RGraph.Line({
        id:'cvs3',
        data: [
            [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $weight){
                        echo $weight->weight.',';
                        }
                    }
                ?>
            ]
        ],
        options: {
            colors: ['red', 'blue'],
            tickmarksStyle: ['filledcircle'],
            tickmarksSize: 2,
            linewidth: 1,
            shadow: false,
            spline:true,
            yaxisScaleUnitsPre: ' ',
            yaxisScaleUnitsPost: ' Kg',
            backgroundGridHlinesCount: 18,
            backgroundGridVlines: true,
            backgroundGridBorder: false,
            backgroundColor: '#fff',
            marginInner: 1,
            xaxisLabels: [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $down){
                        $time=strtotime($down->appointmentDate);
                        $month=date("F",$time);
                        $day=date("d-m",$time);
                        echo "'".$day."',";
                        }
                    }
                ?>
            ],
            labelsAbove: true,
            labelsAboveBorder: false,
            labelsAboveDecimals: 1,
            labelsAboveSize: 9,
            yaxisScaleMax: 180,
            yaxisScaleMin: 0,
            yaxisLabelsCount: 18,
            yaxisTickmarksCount: 36,
            marginLeft: 50,
            textSize: 9,
            yaxisLabelsOffsetx: -5
        }
    }).draw();
</script>
<!--Weight-->
<!--Bp and Pulse-->
<script>
    line = new RGraph.Line({
        id: 'cvs',
        data: [
            [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $up){
                        echo $up->bpUp.',';
                        }
                    }
                ?>
            ],
            [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $down){
                        echo $down->bpDown.',';
                        }
                    }
                ?>
            ],
            [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $pulse){
                        echo $pulse->pulse.',';
                        }
                    }
                ?>
            ]
        ],
        options: {
            colors: ['red', 'blue','black'],
            key: ['Bp(Systolic)', 'Bp(Diastolic)','Pulse'],
            keyPosition: 'margin',
            keyInteractive: true,
            tickmarksStyle: ['filledcircle', 'filledcircle', 'filledcircle'],
            tickmarksSize: 2,
            linewidth: 1,
            yaxisScaleMax: 180,
            yaxisScaleMin: 50,
            yaxisTickmarksCount: 52,
            yaxisLabelsCount: 13,
            backgroundGridHlinesCount: 26,
            backgroundColor: '#fff',
            xaxisLabels: [
                <?php
                    if($graphBp) {
                        foreach($graphBp as $down){
                        $time=strtotime($down->appointmentDate);
                        $month=date("F",$time);
                        $day=date("d-m",$time);
                        echo "'".$day."',";
                        }
                    }
                ?>
            ],
            labelsAbove: true,
            labelsAboveBorder: false,
            labelsAboveDecimals: 1,
            labelsAboveSize: 9,
            marginBottom: 45,
            marginInner: 1,
            textSize: 7,
            shadow: true,
            crosshairs: true,
            crosshairsSnap: true
        }
    }).on('crosshairs', function (obj)
        {
            document.getElementById("dataset").value =  obj.canvas.__crosshairs_snap_dataset__;
            document.getElementById("point").value =  obj.canvas.__crosshairs_snap_point__;
        }).draw();
</script>
<!--Bp and Pulse-->
<script>
    $(document).ready(function(){
        $("#memberTable").fancyTable({
            pagination: true,
            perPage:5,
            searchable: false
        });
    });
    function deleteReport()
    {
        if (confirm('Are you sure you want to Delete this Report?')) {
            var rID = $('#rID').val();
            var imgPath = $('#imgPath').val();
            var methodUrl = '<?=base_url('Clinic/NoUI/deleteReport')?>';
            $.ajax({
                type: 'post',
                url: methodUrl,
                data: {
                    imagePath: imgPath,
                    rID: rID
                },
                success:function(data)
                {
                    var url = "<?=base_url('Clinic/Patients/MR/'.$patient->patientIdPK.'/Reports')?>";
                    location.href = url;
                    //alert(data);
                }
            })
        } else {
            // Do nothing!
        }

    }
</script>