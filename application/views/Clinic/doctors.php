<!-- Body Content Start -->
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <h3><i class="fas fa-list"></i> Doctors List</h3>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <?php if($_SESSION['userLevel']==4) {?>
            <a href="<?=base_url('Clinic/Doctors/add')?>" class="btn btn-info float-right mx-1">
                <i class="fas fa-user-md"></i> New Doctor
            </a>
            <?php } ?>
        </div>
        <br />
        <br />
        <div class="col-12">
            <!--Classes List Table-->
            <div class="" style="overflow-x: auto">
                <table class="table table-responsive table-bordered" id="memberTable">
                    <thead>
                    <tr class="bg-dark text-white">
                        <th>Doctor's ID</th>
                        <th>Doctor's Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <?php
                    if($doctors){
                        foreach($doctors as $doctor){?>
                            <tr>
                                <td>
                                    <span class="" ><?=$doctor->doctorIdPK?></span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$doctor->d_firstName?>&nbsp;
                                        <?=$doctor->d_lastName?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$doctor->contact1?><br />
                                        <?=$doctor->contact2?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$doctor->address?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?php
                                        if($doctor->gender==1){echo 'Male';}
                                        elseif($doctor->gender==2){echo 'Female';}
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a  href="<?=base_url('Clinic/Doctors/modify/').$doctor->doctorIdPK; ?>"
                                            class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Modify
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
            perPage:20,
            searchable: true
        });
    });
</script>