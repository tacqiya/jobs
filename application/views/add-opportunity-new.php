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
            <label>Requisition Id</label>
            <input class="input-field" type="text" name="requisition_id" />
        </div>
        <div class="form-group clear">
            <label>Requisition Title</label>
            <input class="input-field" type="text" name="requisition_title" />
        </div>
        <div class="form-group clear">
            <label>Description Value</label>
            <input class="input-field" type="text" name="description_value" />
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
            <label>Organization Name</label>
            <input class="input-field" type="text" name="org_name" />
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
            <label>Department Name</label>
            <input class="input-field" type="text" name="dept_name" />
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
            <label>Hiring Manager Name</label>
            <input class="input-field" type="text" name="hiring_manager_name" />
        </div>
        <div class="form-group clear">
            <label>Hiring Manager Email</label>
            <input class="input-field" type="email" name="hiring_manager_email" />
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
            <label>Project Authorizer Email</label>
            <input class="input-field" type="email" name="project_auth_email" />
        </div>
        <div class="form-group clear">
            <label>Date Posted</label>
            <input class="input-field" type="text" name="date_posted" />
        </div>
        <div class="form-group clear">
            <label>Closing Date</label>
            <input class="input-field" type="text" name="closing_date" />
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#img_pre').attr('src', e.target.result).css('opacity', 1);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    $("#img_input").change(function() {
        readURL(this);
    });

    $(document).on("click", ".close", function() {
        $(this).closest('.form-group').remove();
        var data_id = $(this).closest('.form-group').attr("data-id");
        editor = 'editor' + data_id;
        CKEDITOR.instances[editor].destroy();
    });

</script>