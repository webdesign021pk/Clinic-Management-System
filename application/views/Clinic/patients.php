<!-- Body Content Start -->
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <h3><i class="fas fa-list"></i> Patients List</h3>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <a href="<?=base_url('Clinic/Patients/add')?>" class="btn btn-info float-right mx-1">
                <i class="fas fa-procedures"></i> New Patient
            </a>
        </div>
        <br />
        <br />
        <div class="col-12">
            <!--Classes List Table-->
            <div class="" style="overflow-x: auto">
                <table class="table table-responsive table-bordered" id="memberTable">
                    <thead>
                    <tr class="bg-dark text-white">
                        <th width="8%">ID</th>
                        <th>Patient's Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th width="10%">Gender</th>
                        <th>Action</th>
                    </tr>

                    </thead>
                    <tbody class="bg-white">
                    <?php
                    if($patients){
                        foreach($patients as $patient){?>
                            <tr>
                                <td>
                                    <span class="" ><?=$patient->patientIdPK?></span>
                                </td>
                                <td>
                                    <?=$patient->p_firstName?>&nbsp;
                                    <?=$patient->p_lastName?>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$patient->contact1?><br />
                                        <?=$patient->contact2?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$patient->address?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
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
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?php
                                        if($patient->gender=1){echo 'Male';}
                                        elseif($patient->gender=2){echo 'Female';}
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a  href="<?=base_url('Clinic/Patients/MR/'.$patient->patientIdPK); ?>"
                                            class="btn btn-sm btn-success">
                                        <i class="fas fa-laptop-medical"></i> View MR
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!--End Classes List Table-->
        </div>
    </div>
</div>
<!-- Body Content End -->
<script>
    $(document).ready(function(){
        $("#memberTable").fancyTable({
            pagination: true,
            perPage:15,
            searchable: true
        });
    });
</script>