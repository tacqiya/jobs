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

        <div class="form-group clear">
            <label>College</label>
            <select class="input-field" name="college" id="college">
                <option value="">Select College</option>
                <option value="College of Engineering" <?= ($opportunity->college == 'College of Engineering') ? 'selected' : ''; ?>>College of Engineering</option>
                <option value="College of Arts and Science" <?= ($opportunity->college == 'College of Arts and Science') ? 'selected' : ''; ?>>College of Arts and Science</option>
                <option value="College of Medicine and Health Science" <?= ($opportunity->college == 'College of Medicine and Health Science') ? 'selected' : ''; ?>>College of Medicine and Health Science</option>
            </select>
        </div>

        <div class="form-group clear">
            <label>Requisition Id</label>
            <input class="input-field" type="text" name="requisition_id" value="<?= $opportunity->requisition_id ?>" />
        </div>
        <div class="form-group clear">
            <label>Requisition Title</label>
            <input class="input-field" type="text" name="requisition_title" value="<?= $opportunity->requisition_title ?>" />
        </div>
        <div class="form-group clear">
            <label>Description Value</label>
            <input class="input-field" type="text" name="description_value" value="<?= $opportunity->description_value ?>" />
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
            <label>Organization Name</label>
            <input class="input-field" type="text" name="org_name" value="<?= $opportunity->org_name ?>" />
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
            <label>Department Name</label>
            <input class="input-field" type="text" name="dept_name" value="<?= $opportunity->dept_name ?>" />
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
            <label>Hiring Manager Name</label>
            <input class="input-field" type="text" name="hiring_manager_name" value="<?= $opportunity->hiring_manager_name ?>" />
        </div>
        <div class="form-group clear">
            <label>Hiring Manager Email</label>
            <input class="input-field" type="email" name="hiring_manager_email" value="<?= $opportunity->hiring_manager_email ?>" />
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
            <label>Date Posted</label>
            <input class="input-field" type="text" name="date_posted" value="<?= $opportunity->date_posted ?>" />
        </div>
        <div class="form-group clear">
            <label>Closing Date</label>
            <input class="input-field" type="text" name="closing_date" value="<?= $opportunity->closing_date ?>" />
        </div>
        <div class="form-group clear">
            <label>Status Details</label>
            <input class="input-field" type="text" name="status_details" value="<?= $opportunity->status_details ?>" />
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
            <input type="submit" value="Update Job" class="common-button" />
        </div>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace('descriptions', {
        plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format'
    }).on('required', function (evt) {
        $('#error1').fadeIn();
        evt.cancel();
    });

    CKEDITOR.replace('qualifications', {
        plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format'
    }).on('required', function (evt) {
        $('#error1').fadeIn();
        evt.cancel();
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_pre').attr('src', e.target.result).css('opacity', 1);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#category").on("change", function () {
        var valueSelected = this.value; console.log(valueSelected)
        if (valueSelected == 'Faculty') {
            $('#college').attr('disabled', false);
            $('#college').closest('.form-group').css('display', 'block');
        } else {
            $('#college').attr('disabled', true);
            $('#college').closest('.form-group').css('display', 'none');
        }
    });

    $("#img_input").change(function () {
        readURL(this);
    });

    $(document).on("click", ".close", function () {
        $(this).closest('.form-group').remove();
        var data_id = $(this).closest('.form-group').attr("data-id");
        editor = 'editor' + data_id;
        CKEDITOR.instances[editor].destroy();
    });

    $('#add-more').on('click', function (e) {
        e.preventDefault();
        var m = $('.existing-fields .form-group').length - 1;
        var n = m + ($('.add-more-fields .form-group').length + 1);
        var html_row = '<div class="form-group clear" data-id="' + n + '" >' +
                '<label><input type="text" class="input-field editor-field editor-field' + n + '" name="editor_heading[]" placeholder="Enter heading" required /></label>' +
                '<div class="ck-textarea">' +
                '<textarea class="input-field" name="editor_details[]" id="editor' + n + '" rows="10" cols="10" required></textarea>' +
                '<span class="ck-error" id="error' + n + '">This field is required</span>' +
                '<span class="close">Close</span>' +
                '</div>' +
                '</div>';
        $('.add-more-fields').append(html_row);
        CKEDITOR.replace('editor' + n, {
            plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format'
        }).on('required', function (evt) {
            $('#error' + n).fadeIn();
            evt.cancel();
        });
        return false;
    });
</script>