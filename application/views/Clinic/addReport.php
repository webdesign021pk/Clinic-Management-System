<!-- Body Content Start -->
<div class="container mt-4">
    <h3 class="modal-title"><i class="fas fa-notes-medical"></i> Add New Report</h3>
</div>
<br />
<div class="container p-3 mb-5 border bg-white shadow-sm">
    <?php echo form_open_multipart(base_url('Clinic/Patients/addReport'));?>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="userfile">Select Report:</label>
                    <input type="file" class="form-control-file" name="userfile" required>
                    <?php if(isset($error)){ echo $error;}?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="patientId">Patient:</label>
                    <select class="selectpicker form-control border "
                            data-hide-disabled="true" data-live-search="true"
                            name="patientId" id="patientId" required>
                        <option value="">Select Patient</option>
                        <?php
                        foreach($patients as $patient){ ?>
                            <option value="<?=$patient->patientIdPK?>">
                                <?=$patient->p_firstName?>&nbsp;<?=$patient->p_lastName?>
                            </option>
                        <?php }
                        ?>
                    </select>
                    <?php echo form_error('patientId')?>
                </div>
                <div class="form-group">
                    <label for="reportTitle">Report Title:</label>
                    <input type="text" class="form-control" name="reportTitle" id="reportTitle" placeholder="Enter Report Title"
                           value="<?=set_value('reportTitle')?>"  autocomplete="off" required>
                    <?php echo form_error('reportTitle')?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="reportDate">Report Date:</label>
                    <input type="date" class="form-control" id="reportDate" name="reportDate" placeholder="" value="<?=set_value('reportDate')?>" >
                    <?php echo form_error('reportDate')?>
                </div>
                <div class="form-group">
                    <label for="isClear">Visiblity:</label>
                    <select class="form-control" id="isClear" name="isClear" required>
                        <option value="">Select Clarity</option>
                        <option value="1">Clear</option>
                        <option value="0">Blur/Unclear</option>
                    </select>
                    <?php echo form_error('isClear')?>
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
    function getAppointmentTime()
    {
        var aptDate = $('#appointmentDate').val();
        var methodUrl = '<?=base_url('Clinic/NoUI/getAppointmentTime/')?>'+aptDate;
        $.ajax({
            url: methodUrl,
            success:function(data)
            {
                $('#timeSlotId').html(data);
            }
        })
    }

</script>
