<div class="page">
    <h6 class="common-title">Add Categories</h6>
    <div class="form">
        <?php echo form_open_multipart('', array('id' => 'form')); ?>
        <div class="form-group clear">
            <label>Category Name</label>
            <input class="input-field" type="text" name="title" value="<?= $category->title ?>" required />
        </div>
        <div class="form-group clear">
            <label></label>
            <input type="submit" value="Update Category" class="common-button" />
        </div>
        </form>
    </div>
</div>

<script>
    CKEDITOR.replace('editor1', {
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

    $(function() {
        $('input[name="title"]').on('blur', function() {
            titleVal = $(this).val().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').replace(/\s+/g, '-').toLowerCase();
            $('input[name="slug"]').val(titleVal);
        });
    });
</script>