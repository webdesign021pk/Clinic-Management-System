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
            <h3><i class="fas fa-list"></i> Appointments</h3>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <a href="<?=base_url('Clinic/Appointments/add')?>" class="btn btn-info float-right mx-1">
                <i class="fas fa-notes-medical"></i> New Appointment
            </a>
        </div>
        <br />
        <br />
        <div class="col-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link <?=$navClass?> <?php if($this->uri->segment(4)=='Unattended'){echo ' active';} ;?>"
                       data-toggle="tab" href="#Unattended">Unattended</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($this->uri->segment(4)=='Attended'){echo ' active';} ;?>"
                       data-toggle="tab" href="#Attended">Attended</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container <?=$navClass?> <?php if($this->uri->segment(4)=='Unattended'){echo ' active';} ;?>
                            pt-3 pl-0" id="Unattended">
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered" id="UnattendedAppointments">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Patient's Name</th>
                                <th>Doctor's Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            if($appointments){
                                foreach($appointments as $appointment){?>
                                    <tr>
                                        <td>
                                            <span class="" >
                                                <?=$appointment->appointmentDate?>
                                                <?php
                                                $datetime = DateTime::createFromFormat('Y-m-d', $appointment->appointmentDate);
                                                echo '('.$datetime->format('D').')';
                                                ?>
                                                <?php
                                                $today=date('Y-m-d');
                                                if($today>$appointment->appointmentDate){
                                                    ?>
                                                    <span class="badge badge-danger">Late</span>
                                                <?php } ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="" >
                                                <?=$appointment->timeSlot?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="" >
                                                <a href="<?=base_url('Clinic/Patients/MR/'.$appointment->patientIdPK)?>">
                                                    <?=$appointment->p_firstName?>&nbsp;
                                                    <?=$appointment->p_lastName?>
                                                </a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="" >
                                                <?=$appointment->d_firstName?>&nbsp;
                                                <?=$appointment->d_lastName?>
                                            </span>
                                        </td>
                                        <td>
                                            <a  href="<?=base_url('Clinic/Appointments/View/'.$appointment->appointmentIdPK); ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane container <?php if($this->uri->segment(4)=='Attended'){echo ' active';};?>
                             pt-3 pl-0" id="Attended">
                    <div class="" style="overflow-x: auto">
                        <table class="table table-responsive table-bordered" id="attendedAppointments">
                            <thead>
                            <tr class="bg-dark text-white">
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Patient's Name</th>
                                <th>Doctor's Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <?php
                            if($attendedAppointments){
                                foreach($attendedAppointments as $attendedAppointment){?>
                                    <tr>
                                        <td>
                                    <span class="" >
                                        <?=$attendedAppointment->appointmentDate?>
                                        <?php
                                        $datetime = DateTime::createFromFormat('Y-m-d', $attendedAppointment->appointmentDate);
                                        echo '('.$datetime->format('D').')';
                                        ?>
                                    </span>
                                        </td>
                                        <td>
                                    <span class="" >
                                        <?=$attendedAppointment->timeSlot?>
                                    </span>
                                        </td>
                                        <td>
                                    <span class="" >
										<a href="<?=base_url('Clinic/Patients/MR/'.$attendedAppointment->patientIdPK)?>">
											<?=$attendedAppointment->p_firstName?>&nbsp;
											<?=$attendedAppointment->p_lastName?>
										</a>
                                    </span>
                                        </td>
                                        <td>
                                    <span class="" >
                                        <?=$attendedAppointment->d_firstName?>&nbsp;
                                        <?=$attendedAppointment->d_lastName?>
                                    </span>
                                        </td>
                                        <td>
                                            <a  href="<?=base_url('Clinic/Appointments/View/'.$attendedAppointment->appointmentIdPK); ?>"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-eye"></i> View
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

            <!--Classes List Table-->
            <div class="" style="overflow-x: auto">

            </div>
            <!--End Classes List Table-->
        </div>
    </div>
</div>
<!-- Body Content End -->

<script>
    $(document).ready(function(){
        $("#UnattendedAppointments").fancyTable({
            pagination: true,
            perPage:20,
            searchable: true
        });
        $("#attendedAppointments").fancyTable({
            pagination: true,
            perPage:20,
            searchable: true
        });
    });
</script>