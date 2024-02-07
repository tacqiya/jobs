<div class="page">
    <h6 class="common-title">Edit Job</h6>
    <div class="form">
        <?php echo form_open_multipart('', array('id' => 'form')); ?>
        <div class="form-group clear">
            <label>Category</label>
            <select class="input-field" name="category" id="category">
                <option value="">Select Category</option>
                <option value="Staff" <?= ($opportunity->category == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                <option value="Faculty" <?= ($opportunity->category == 'Faculty') ? 'selected' : ''; ?>>Faculty</option>
                <option value="Research" <?= ($opportunity->category == 'Research') ? 'selected' : ''; ?>>Research</option>
            </select>
        </div>

        <div class="form-group clear" <?= ($opportunity->category != 'Faculty') ? 'style="display: none;"' : ''; ?>>
            <label>College</label>
            <select class="input-field" name="college" id="college" <?= ($opportunity->category != 'Faculty') ? 'disabled' : ''; ?>>
                <option value="">Select College</option>
                <option value="College of Engineering" <?= ($opportunity->college == 'College of Engineering') ? 'selected' : ''; ?>>College of Engineering</option>
                <option value="College of Arts and Science" <?= ($opportunity->college == 'College of Arts and Science') ? 'selected' : ''; ?>>College of Arts and Science</option>
                <option value="College of Medicine and Health Science" <?= ($opportunity->college == 'College of Medicine and Health Science') ? 'selected' : ''; ?>>College of Medicine and Health Science</option>
            </select>
        </div>

        <div class="form-group clear">
            <label>Requistion ID <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="requisition_id" value="<?= $opportunity->requisition_id ?>" required />
        </div>
        <div class="form-group clear">
            <label>Position Code <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="position_code" value="<?= $opportunity->position_code ?>" required />
        </div>
        <div class="form-group clear">
            <label>Position Title <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="description_value" value="<?= $opportunity->description_value ?>" required />
        </div>
        <div class="form-group clear">
            <label>Position type</label>
            <input class="input-field" type="text" name="position_type" value="<?= $opportunity->position_type ?>" />
        </div>
        <div class="form-group clear">
            <label>Position duration</label>
            <input class="input-field" type="text" name="position_duration" value="<?= $opportunity->position_duration ?>" />
        </div>
        <div class="form-group clear">
            <label>Relevant research center</label>
            <input class="input-field" type="text" name="relevant_research_center" value="<?= $opportunity->relevant_research_center ?>" />
        </div>
        <div class="form-group clear">
            <label>Technical keywords</label>
            <input class="input-field" type="text" name="technical_keywords" value="<?= $opportunity->technical_keywords ?>" />
        </div>
        <div class="form-group clear">
            <label>Justification</label>
            <input class="input-field" type="text" name="justification" value="<?= $opportunity->justification ?>" />
        </div>
        <div class="form-group clear">
            <label>Sector Name</label>
            <input class="input-field" type="text" name="sector_name" value="<?= $opportunity->sector_name ?>" />
        </div>
        <div class="form-group clear">
            <label>Division Name</label>
            <input class="input-field" type="text" name="division_name" value="<?= $opportunity->division_name ?>" />
        </div>
        <div class="form-group clear">
            <label>Department Name <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="dept_name" value="<?= $opportunity->dept_name ?>" required />
        </div>
        <div class="form-group clear">
            <label>Required Years of Experience <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="years_of_experience" value="<?= $opportunity->years_of_experience ?>" required />
        </div>
        <div class="form-group clear">
            <label>Recruiter Name</label>
            <input class="input-field" type="text" name="recruiter_name" value="<?= $opportunity->recruiter_name ?>" />
        </div>
        <div class="form-group clear">
            <label>Recruiter Email</label>
            <input class="input-field" type="email" name="recruiter_email" value="<?= $opportunity->recruiter_email ?>" />
        </div>
        <div class="form-group clear">
            <label>Hiring Manager Name <?= ($opportunity->category == 'Research') ? '<span class="text-danger text-bold" title="Mandatory">*</span>' : ''; ?></label>
            <input class="input-field" type="text" name="hiring_manager_name" id="hiring_manager_name" value="<?= $opportunity->hiring_manager_name ?>" <?= ($opportunity->category == 'Research') ? 'required' : ''; ?> />
        </div>
        <div class="form-group clear">
            <label>Hiring Manager Email <?= ($opportunity->category == 'Research') ? '<span class="text-danger text-bold" title="Mandatory">*</span>' : ''; ?></label>
            <input class="input-field" type="email" name="hiring_manager_email" id="hiring_manager_email" value="<?= $opportunity->hiring_manager_email ?>" <?= ($opportunity->category == 'Research') ? 'required' : ''; ?> />
        </div>
        <div class="form-group clear">
            <label>Apply Link</label>
            <input class="input-field" type="text" name="apply_link" value="<?= $opportunity->apply_link ?>" />
        </div>
        <div class="form-group clear">
            <label>Project Title Long Description</label>
            <input class="input-field" type="text" name="project_title" value="<?= $opportunity->project_title ?>" />
        </div>
        <div class="form-group clear">
            <label>Project Manager Name</label>
            <input class="input-field" type="text" name="project_manager_name" value="<?= $opportunity->project_manager_name ?>" />
        </div>
        <div class="form-group clear">
            <label>Project Manager Email</label>
            <input class="input-field" type="email" name="project_manager_email" value="<?= $opportunity->project_manager_email ?>" />
        </div>
        <div class="form-group clear">
            <label>Employment End Date Value</label>
            <input class="input-field" type="text" name="emp_end_date" value="<?= $opportunity->emp_end_date ?>" />
        </div>
        <div class="form-group clear">
            <label>Project Code</label>
            <input class="input-field" type="text" name="project_code" value="<?= $opportunity->project_code ?>" />
        </div>
        <div class="form-group clear">
            <label>Project Authorizer Name</label>
            <input class="input-field" type="text" name="project_auth_name" value="<?= $opportunity->project_auth_name ?>" />
        </div>
        <div class="form-group clear">
            <label>Closing Date <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="closing_date" value="<?= $opportunity->closing_date ?>" required />
        </div>
        <div class="form-group clear">
            <label>Status Details</label>
            <select class="input-field" name="status_details" id="status_details">
                <option value="Open" <?= ($opportunity->status_details == 'Open') ? 'selected' : ''; ?>>Open</option>
                <option value="Expired" <?= ($opportunity->status_details == 'Expired') ? 'selected' : ''; ?>>Expired</option>
                <option value="Unposted" <?= ($opportunity->status_details == 'Unposted') ? 'selected' : ''; ?>>Unposted</option>
                <option value="Posted" <?= ($opportunity->status_details == 'Posted') ? 'selected' : ''; ?>>Posted</option>
                <option value="Canceled" <?= ($opportunity->status_details == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
            </select>
        </div>

        <div class="form-group clear">
            <label>Job Descriptions</label>
            <div class="ck-textarea">
                <textarea class="text-area" name="descriptions" id="descriptions" rows="10" cols="10"><?= $opportunity->descriptions ?></textarea>
                <span class="ck-error" id="error1">This field is required</span>
            </div>
        </div>

        <div class="form-group clear">
            <label>Qualifications</label>
            <div class="ck-textarea">
                <textarea class="text-area" name="qualifications" id="qualifications" rows="10" cols="10"><?= $opportunity->qualifications ?></textarea>
                <span class="ck-error" id="error1">This field is required</span>
            </div>
        </div>

        <div class="form-group clear">
            <label></label>
            <input type="submit" value="Update Job" class="common-button" id="submit-btn" />&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if ($opportunity->publish == 'edited') { ?>
                <input type="button" value="Publish" class="common-button" id="publish-btn" />
            <?php } ?>
        </div>
        </form>
    </div>
</div>

<script>
    <?php if (isset($url)) { ?>
        setTimeout(function() {
            window.location.replace("<?= $url ?>");
        }, 1000);
    <?php } ?>

    CKEDITOR.replace('descriptions', {
        plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format'
    }).on('required', function(evt) {
        $('#error1').fadeIn();
        evt.cancel();
    });

    CKEDITOR.replace('qualifications', {
        plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format,autogrow',
        extraPlugins: 'autogrow',
	autoGrow_maxHeight: 800,

	// Remove the Resize plugin as it does not make sense to use it in conjunction with the AutoGrow plugin.
	removePlugins: 'resize'
    }).on('required', function(evt) {
        $('#error1').fadeIn();
        evt.cancel();
    });

    $("#category").on("change", function() {
        var valueSelected = this.value;
        console.log(valueSelected)
        if (valueSelected == 'Faculty') {
            $('#college').attr('disabled', false);
            $('#college').closest('.form-group').css('display', 'block');
        } else {
            $('#college').attr('disabled', true);
            $('#college').closest('.form-group').css('display', 'none');
        }

        if (valueSelected == 'Staff' || valueSelected == 'Faculty') {
            $('#hiring_manager_name').attr('required', false);
            $('#hiring_manager_email').attr('required', false);
            $('#hiring_manager_name').prev().children().hide();
            $('#hiring_manager_email').prev().children().hide();
        } else if (valueSelected == 'Research') {
            $('#hiring_manager_name').attr('required', true);
            $('#hiring_manager_email').attr('required', true);
            $('#hiring_manager_name').prev().children().show();
            $('#hiring_manager_email').prev().children().show();
        }
    });

    // $('#publish-btn').click(function() {
    //     let id = <?= $opportunity->id ?>;
    //     var formData = $('#form')[0];
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url() . ADMIN_URL . '/publish-opportunity' ?>",
    //         dataType: "json",
    //         data: {
    //             id: id,
    //             'formData': formData
    //         }
    //     }).done(function(msg) {
    //         $(".publish-btn[data-id='" + id + "']").replaceWith('<span>Published</span>');
    //         $(".table").load(location.href + " .table");
    //     });
    // });

    $('#publish-btn').on('click', function() {
        let id = <?= $opportunity->id ?>;
        let req_id = '<?= $opportunity->requisition_id ?>';
        let pos_code = '<?= $opportunity->position_code ?>';
        var fd = $('#form').serializeArray();
        fd.push({
            name: 'id',
            value: id
        });
        fd.push({
            name: 'req_id',
            value: req_id
        });
        fd.push({
            name: 'pos_code',
            value: pos_code
        });

        $.ajax({
            method: "POST",
            url: "<?= base_url() . ADMIN_URL . '/publish-opportunity' ?>",
            data: fd,
            dataType: "json",
            success: function(data) {
                var msg = data['msg'];
                if (data['type'] == 'success') {
                    $('body').append('<div class="new-alert success">' + msg + '</div>');
                    setTimeout(function() {
                        $(".new-alert").hide();
                        $(".new-alert").remove();
                        window.location.reload();
                    }, 2000);
                } else if (data['type'] == 'success') {
                    $('body').append('<div class="new-alert error">' + msg + '</div>');
                    setTimeout(function() {
                        $(".new-alert").hide();
                        $(".new-alert").remove();
                    }, 2000);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
</script>