<div class="page">
    <h6 class="common-title">Add Job</h6>
    <div class="form">
        <?php echo form_open_multipart('', array('id' => 'form')); ?>
        <div class="form-group clear">
            <label>Category</label>
            <select class="input-field" name="category" id="category">
                <option value="">Select Category</option>
                        <option value="Staff">Staff</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Research">Research</option>
                <option value="General Application">General Application</option>

            </select>
        </div>
        <div class="form-group clear" >
            <label>College</label>
            <select class="input-field" name="college" id="college">
                <option value="">Select College</option>
                <option value="College of Engineering">College of Engineering</option>
                <option value="College of Arts and Science">College of Arts and Science</option>
                <option value="College of Medicine and Health Science">College of Medicine and Health Science</option>
            </select>
        </div>

        <div class="form-group clear">
            <label>Requistion ID</label>
            <input class="input-field" type="text" name="requisition_id" required />
        </div>
        <div class="form-group clear">
            <label>Position Code <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="position_code" required />
        </div>
        <div class="form-group clear">
            <label>Position Title <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="description_value" required />
        </div>
        <div class="form-group clear">
            <label>Position type</label>
            <input class="input-field" type="text" name="position_type" />
        </div>
        <div class="form-group clear">
            <label>Position duration</label>
            <input class="input-field" type="text" name="position_duration" />
        </div>
        <div class="form-group clear">
            <label>Relevant research center</label>
            <input class="input-field" type="text" name="relevant_research_center" />
        </div>
        <div class="form-group clear">
            <label>Technical keywords</label>
            <input class="input-field" type="text" name="technical_keywords" />
        </div>
        <div class="form-group clear">
            <label>Justification</label>
            <input class="input-field" type="text" name="justification" />
        </div>
        <div class="form-group clear">
            <label>Sector Name</label>
            <input class="input-field" type="text" name="sector_name" />
        </div>
        <div class="form-group clear">
            <label>Division Name</label>
            <input class="input-field" type="text" name="division_name" />
        </div>
        <div class="form-group clear">
            <label>Department Name <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="dept_name" required />
        </div>
        <div class="form-group clear">
            <label>Required Years of Experience <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="years_of_experience" required />
        </div>
        <div class="form-group clear">
            <label>Recruiter Name</label>
            <input class="input-field" type="text" name="recruiter_name" />
        </div>
        <div class="form-group clear">
            <label>Recruiter Email</label>
            <input class="input-field" type="email" name="recruiter_email" />
        </div>
        <div class="form-group clear">
            <label>Hiring Manager Name <span class="text-danger text-bold" style="display: none;" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="hiring_manager_name" id="hiring_manager_name" />
        </div>
        <div class="form-group clear">
            <label>Hiring Manager Email <span class="text-danger text-bold" style="display: none;" title="Mandatory">*</span></label>
            <input class="input-field" type="email" name="hiring_manager_email" id="hiring_manager_email" />
        </div>
        <div class="form-group clear">
            <label>Apply Link</label>
            <input class="input-field" type="text" name="apply_link" />
        </div>
        <div class="form-group clear">
            <label>Project Title Long Description</label>
            <input class="input-field" type="text" name="project_title" />
        </div>
        <div class="form-group clear">
            <label>Project Manager Name</label>
            <input class="input-field" type="text" name="project_manager_name" />
        </div>
        <div class="form-group clear">
            <label>Project Manager Email</label>
            <input class="input-field" type="email" name="project_manager_email" />
        </div>
        <div class="form-group clear">
            <label>Employment End Date Value</label>
            <input class="input-field" type="text" name="emp_end_date" />
        </div>
        <div class="form-group clear">
            <label>Project Code</label>
            <input class="input-field" type="text" name="project_code" />
        </div>
        <div class="form-group clear">
            <label>Project Authorizer Name</label>
            <input class="input-field" type="text" name="project_auth_name" />
        </div>
        <div class="form-group clear">
            <label>Closing Date</label>
            <input class="input-field" type="text" name="closing_date" />
        </div>
        <div class="form-group clear">
            <label>Status Details</label>
            <input class="input-field" type="text" name="status_details" />
        </div>

        <div class="form-group clear">
            <label>Job Descriptions</label>
            <div class="ck-textarea">
                <textarea class="text-area" name="descriptions" id="descriptions" rows="10" cols="10"></textarea>
                <span class="ck-error" id="error1">This field is required</span>
            </div>
        </div>

        <div class="form-group clear">
            <label>Qualifications</label>
            <div class="ck-textarea">
                <textarea class="text-area" name="qualifications" id="qualifications" rows="10" cols="10"></textarea>
                <span class="ck-error" id="error1">This field is required</span>
            </div>
        </div>

        <div class="form-group clear">
            <label></label>
            <input type="submit" value="Add Job" class="common-button" />
        </div>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace('descriptions', {
        plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format'
    }).on('required', function(evt) {
        $('#error1').fadeIn();
        evt.cancel();
    });

    CKEDITOR.replace('qualifications', {
        plugins: 'wysiwygarea,toolbar,basicstyles,link,list,format'
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

</script>