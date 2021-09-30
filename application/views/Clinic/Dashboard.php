<!-- Body Content Start -->
<div class="container p-3 mb-5">
    <div class="row mb-2">
        <div class="col-md-10">
            <h3><i class="fas fa-home"></i> Dashboard</h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-12 shadow-sm bg-white rounded-lg">
            <div class="row p-3 ">
                <div class="col-lg-4 col-md-6 col-sm-6 text-white mr-auto ml-auto">
                    <div class="row border bg-light-green shadow-sm p-3">
                        <div class="col-lg-3 col-md-12 col-md-12 text-center">
                            <i class="fas fa-procedures fa-4x opacity-80"></i>
                        </div>
                        <div class="col-lg-8 mt-auto mb-auto text-center">
                            <span style="font-size: 1.2em">Total Patients: </span>
                            <br>
                            <span style="font-size: 1.2em">
                                <?=$totalPatients?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 text-white mr-auto ml-auto">
                    <div class="row border bg-light-blue shadow-sm p-3">
                        <div class="col-lg-3 col-md-12 col-md-12 text-center">
                            <i class="fas fa-notes-medical fa-4x opacity-80"></i>
                        </div>
                        <div class="col-lg-8 mt-auto mb-auto text-center">
                            <span style="font-size: 1.2em">Total Appointments: </span>
                            <br>
                            <span style="font-size: 1.2em">
                                <?=$appointments;?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 text-white mr-auto ml-auto">
                    <div class="row border bg-light-brown shadow-sm p-3">
                        <div class="col-lg-3 col-md-12 col-md-12 text-center">
                            <i class="fas fa-calendar-check fa-4x opacity-80"></i>
                        </div>
                        <div class="col-lg-8 mt-auto mb-auto text-center">
                            <span style="font-size: 1.2em">Todays Appointment: </span>
                            <br>
                            <span style="font-size: 1.2em">
                                <?=$todaysAppointments?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br />
    <div class="row mb-2 bg-white shadow-sm rounded p-2">
        <div class="col-lg-6 col-md-12 col-sm-12 p-2">
            <h5 class="ml-2">Patients Medical Record:</h5>
            <div class="input-group">
                <select class="selectpicker form-control border "
                        data-hide-disabled="true" data-live-search="true"
                        name="patientId" id="patientId"required>
                    <option value="">Select Patient</option>
                    <?php
                    foreach($patients as $patient){ ?>
                        <option value="<?=base_url('Clinic/Patients/MR/'.$patient->patientIdPK)?>">
                            <?=$patient->p_firstName?>&nbsp;<?=$patient->p_lastName?>
                        </option>
                    <?php }
                    ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit"
                            onclick="window.location = jQuery('#patientId option:selected').val();" >
                        <i class="fas fa-laptop-medical"></i> View
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 p-2">
            <h5 class="ml-2">Appointment Details:</h5>
            <div class="input-group">
                <input class="form-control" placeholder="Enter Appointment Number" id="appointmentId" type="number" min="1" max="9999">
                <div class="input-group-append">
                    <button class="btn btn-success" type="button"
                            onclick="window.location = '<?=base_url('Clinic/Appointments/View/')?>'+jQuery('#appointmentId').val();" >
                        <i class="fas fa-laptop-medical"></i> View
                    </button>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row mb-2 bg-white shadow-sm rounded p-2">
        <div class="col-12 p-2 text-center">
            <h4 class="mt-2 mb-3">Today's Appointments</h4>
            <div style="overflow-x: auto">
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr class="bg-dark text-white">
                        <th>Appointment Time</th>
                        <th>Patient's Name</th>
                        <th>Doctor's Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($todaysAppointmentsList) {
                            foreach($todaysAppointmentsList as $row2) {?>
                            <tr>
                                <td><?=$row2->timeSlot?></td>
                                <td><?=$row2->p_firstName?>&nbsp;<?=$row2->p_firstName?></td>
                                <td><?=$row2->d_firstName?>&nbsp;<?=$row2->d_firstName?></td>
                                <td>
                                    <a  href="<?=base_url('Clinic/Appointments/View/'.$row2->appointmentIdPK); ?>"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else {?>
                            <tr>
                                <td colspan="4">No Appointments Today!</td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<!-- Body Content End -->

<script type="text/javascript">

    /* BAR CHART * ---------*/
    var bar_data = {
        data : [
            <?php// foreach($graph as $graphValue) {?>
            [<?php//=$graphValue->classIdFK?>,<?php//=$graphValue->totalStudents?>],
            <?php// } ?>
        ],
        bars: { show: true }
    };
    $.plot('#bar-chart', [bar_data], {
        grid  : {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor  : '#f3f3f3'
        },
        series: {
            bars: {
                show: true, barWidth: 0.5, align: 'center',
            },
        },
        colors: ['#3c8dbc'],
        xaxis : {
            show : true,
            axisLabel : 'Classes',
            ticks: [
                <?php// foreach($graph as $graphValue) {?>
                [<?php//=$graphValue->classIdFK?>,'<?php//=$graphValue->className?>'],
                <?php// } ?>
            ]
        },
        yaxis: {
            show : true,
            axisLabel : 'No. of Students',
            position: 'left',
            //show: true,
            /*tickSize: 100,*/
            minTickSize: 1,
            tickDecimals: 0
        }

    });
    /* END BAR CHART */
</script>