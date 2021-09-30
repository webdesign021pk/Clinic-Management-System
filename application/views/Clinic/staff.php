<!-- Body Content Start -->
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <h3><i class="fas fa-list"></i> Staff List</h3>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <?php if($_SESSION['userLevel']==4) {?>
            <a href="<?=base_url('Clinic/Staff/add')?>" class="btn btn-info float-right mx-1">
                <i class="fas fa-user-md"></i> New Staff
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
                        <th width="8%">ID</th>
                        <th>Staff's Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Designation</th>
                        <th width="10%">Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    <?php
                    if($staff){
                        foreach($staff as $row){?>
                            <tr>
                                <td>
                                    <span class="" ><?=$row->staffIdPK?></span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$row->s_firstName?>&nbsp;
                                        <?=$row->s_lastName?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$row->contact1?><br />
                                        <?=$row->contact2?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?=$row->address?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?php
                                        if($row->gender==1){echo 'Male';}
                                        elseif($row->gender==2){echo 'Female';}
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="" >
                                        <?php
                                        if($row->staffLevel==1){echo '<i class="fas fa-user-nurse"></i> Nurse';}
                                        elseif($row->staffLevel==2){echo '<i class="fas fa-mortar-pestle"></i> Compounder';}
                                        elseif($row->staffLevel==3){echo '<i class="fas fa-prescription"></i> Pharmacist';}
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?=base_url('Clinic/Staff/modify/'.$row->staffIdPK)?>"
                                            class="btn btn-sm btn-warning">
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