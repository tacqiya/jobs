<div class="page">
    <h6 class="common-title">Add Opportunity</h6>
    <div class="form">
        <?php echo form_open_multipart('', array('id' => 'form')); ?>
        <div class="form-group clear">
            <label>Category</label>
            <select class="input-field" name="category" id="category">
                <option>Select Category</option>
                <?php if (isset($category)) {
                    foreach ($category as $cat) {
                        ?>
                        <option value="<?= $cat->id ?>"><?= $cat->title ?></option>
                    <?php }
                }
                ?>
            </select>
        </div>
        <div class="form-group clear" style="display: none;">
            <label>College</label>
            <select class="input-field" name="college" id="college" disabled>
                <option>Select College</option>
                <option value="College of Engineering">College of Engineering</option>
                <option value="College of Arts and Science">College of Arts and Science</option>
                <option value="College of Medicine and Health Science">College of Medicine and Health Science</option>
            </select>
        </div>
        <div class="form-group imageupload  clear">
            <label>Header Image</label>
            <div class="input-field img-preview" style="width: 500px; height: 360px;">
                <input type="file" name="image" class="image_upload" data-width="1400" data-height="590" id="img_input" accept="image/x-png,image/gif,image/jpeg" />
                <img id="img_pre" />
                <span>Click / Drop Here</span>
            </div>
        </div>
        <div class="form-group imageupload  clear">
            <label></label>
            <span><b>Note : </b> Image size ratio has to be 1400(W) x 590px(H)</span>
        </div>
        <div class="form-group clear">
            <label>Position Title</label>
            <input class="input-field" type="text" name="position_title" />
        </div>
        <div class="form-group clear">
            <label>Position Code</label>
            <input class="input-field" type="text" name="position_code" />
        </div>
        <div class="form-group clear">
            <label>Position Type</label>
            <input class="input-field" type="text" name="position_type" />
        </div>
        <div class="form-group clear">
            <label>Position Duration</label>
            <input class="input-field" type="text" name="position_duration" />
        </div>
        <div class="form-group clear">
            <label>Project Title</label>
            <input class="input-field" type="text" name="project_title" />
        </div>
        <div class="form-group clear">
            <label>Project Supervisor</label>
            <input class="input-field" type="text" name="project_supervisor" />
        </div>
        <div class="form-group clear">
            <label>Supervisor Mail</label>
            <input class="input-field" type="email" name="supervisor_mail" />
        </div>
        <div class="form-group clear">
            <label>Reporting To</label>
            <input class="input-field" type="text" name="reporting_to" />
        </div>
        <div class="form-group clear">
            <label>Department</label>
            <input class="input-field" type="text" name="academic_department" />
        </div>
        <div class="form-group clear">
            <label>Relevent Research Center</label>
            <input class="input-field" type="text" name="relevant_research_center" />
        </div>
        <div class="form-group clear">
            <label>Technical Keywords</label>
            <input class="input-field" type="text" name="technical_keywords" />
        </div>
        <div class="form-group clear">
            <label>Schedule</label>
            <input class="input-field" type="text" name="schedule" />
        </div>
        <div class="form-group clear">
            <label>Closing Date & Time</label>
            <input class="input-field" type="text" name="closing_date_time" />
        </div>
        <div class="form-group clear">
            <label>Apply Link</label>
            <input class="input-field" type="text" name="apply_link" />
        </div>

        <div class="form-group clear">
            <label>Brief Description</label>
            <textarea class="text-area" name="job_description" id="job_description" rows="10" cols="10" ></textarea>
        </div>

        <div class="form-group clear" data-id="0">
            <label><input type="text" class="input-field editor-field0" name="editor_heading[]" placeholder="Enter heading" /></label>
            <div class="ck-textarea">
                <textarea class="input-field" name="editor_details[]" id="editor0" rows="10" cols="10" ></textarea>
                <span class="ck-error" id="error1">This field is required</span>
            </div>
        </div>

        <div class="add-more-fields"></div>

        <div class="form-group clear">
            <label></label>
            <button type="button" id="add-more" class="add-more-button">Add More</button>
        </div>

        <div class="form-group clear">
            <label></label>
            <input type="submit" value="Add Opportuunity" class="common-button" />
        </div>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace('editor0', {
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
        var valueSelected = this.value;
        if (valueSelected == 2) {
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
        var n = $('.add-more-fields .form-group').length + 1;
        var html_row = '<div class="form-group clear" data-id="' + n + '" >' +
                '<label><input type="text" class="input-field editor-field' + n + '" name="editor_heading[]" placeholder="Enter heading" required /></label>' +
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