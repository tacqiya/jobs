<div class="page">
    <h6 class="common-title">Add Job</h6>
    <div class="form">
        <?php echo form_open_multipart(current_url(), array('id' => 'register-form')); ?>
        <div class="form-group clear">
            <label>Category</label>
            <select class="input-field" name="category" id="category">
                <option value="">Select Category</option>
                        <option value="Staff">Staff</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Research">Research</option>
            </select>
        </div>
        <div class="form-group clear" style="display: none;" >
            <label>College</label>
            <select class="input-field" name="college" id="college" disabled>
                <option value="">Select College</option>
                <option value="College of Engineering">College of Engineering</option>
                <option value="College of Arts and Science">College of Arts and Science</option>
                <option value="College of Medicine and Health Science">College of Medicine and Health Science</option>
            </select>
        </div>

        <div class="form-group clear">
            <label>Requistion ID <span class="text-danger text-bold" title="Mandatory">*</span></label>
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
            <label>Closing Date <span class="text-danger text-bold" title="Mandatory">*</span></label>
            <input class="input-field" type="text" name="closing_date" required/>
        </div>
        <div class="form-group clear">
            <label>Status Details</label>
            <select class="input-field" name="status_details" id="status_details">
                <option value="Open">Open</option>
                <option value="Expired">Expired</option>
                <option value="Unposted">Unposted</option>
                <option value="Posted">Posted</option>
                <option value="Canceled">Canceled</option>
            </select>
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
            <input type="submit" value="Add Job" class="common-button" id="submit-btn" />
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

    $("input[name='requisition_id']").on("input", function() {
        var getLink = $(this).val();
        var apply_link = 'https://careers.ku.ac.ae/careersection/application.jss?lang=en&type=1&csNo=10060&portal=8116755942&reqNo=' + getLink + '&isOnLogoutPage=true';
        $("input[name='apply_link']").val(apply_link);
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


    $("input[name='requisition_id']").on('change', function(){
        let id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?= base_url() . ADMIN_URL . '/check-post' ?>",
            dataType: "json",
            data: {
                datavalue: id
            }
        }).done(function(msg) {  console.log(msg)
            if(msg.type == 'error') { 
                $.dialog({
                        type: 'red',
                        title: 'Failed',
                        content: msg.msg,
                        boxWidth: ($(window).width() > 700) ? '30%' : '90%',
                        useBootstrap: false,
                    });
                    
                // $('body').append('<div class="new-alert success">'+ msg.msg +'</div>');
                // setTimeout(function() {
                //         $(".new-alert").hide();
                //         $(".new-alert").remove();
                //     }, 5000);
            }
            // $('body').append('<div class="new-alert success">'+ id +' has been published.</div>');
        });
    }); 


    $("#register-form").submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData($(this)[0]);
        var actionUrl = form.attr('action');
        let id = $("input[name='requisition_id']").val();
            $.ajax({
            url: actionUrl,
            type: "POST",
            dataType: "json",
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
        }).done(function(msg) { console.log(msg.type)
            if(msg.type == 'success') {
                $.dialog({
                        type: 'green',
                        title: 'Success',
                        content: msg.msg,
                        boxWidth: ($(window).width() > 700) ? '30%' : '90%',
                        useBootstrap: false,
                    });
                // $('body').append('<div class="new-alert success">'+ msg.msg +'</div>');
                setTimeout(function() {
                        // $(".new-alert").hide();
                        // $(".new-alert").remove();
                        window.location.href = msg.url;
                    }, 3000);
            } else {
                $.dialog({
                        type: 'red',
                        title: 'Failed',
                        content: msg.msg,
                        boxWidth: ($(window).width() > 700) ? '30%' : '90%',
                        useBootstrap: false,
                    });
                // $('body').append('<div class="new-alert error">'+ msg.msg +'</div>');
                // setTimeout(function() {
                //         $(".new-alert").hide();
                //         $(".new-alert").remove();
                //     }, 3000);
            }
        });
    });

</script>