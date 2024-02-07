<style>
    .btn-info {
        padding: 5px 15px;
        font-size: 12px;
        text-transform: capitalize;
    }
</style>
<div class="page">
    <h6 class="common-title">All Temporary Updated Jobs</h6>

    <table class="table" id="<?= TBL_JOB_TEMP ?>">
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Requisition ID</th>
            <th>Position Code</th>
            <th>Position Title</th>
            <th>Department - Name</th>
            <th>Recruiter</th>
            <th>Hiring Manager</th>
            <th>Closing date</th>
            <th>Imported Date</th>
        </tr>
        <?php
        $x = 1;
        if (isset($opportunities) && !empty($opportunities)) {
            foreach ($opportunities as $row) {
        ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $row->category; ?></td>
                    <td><?php echo $row->requisition_id; ?></td>
                    <td><?php echo $row->position_code; ?></td>
                    <td style="width: 20%;"><?php echo $row->description_value; ?></td>
                    <td><?php echo $row->dept_name; ?></td>
                    <td><?php echo $row->recruiter_name ?></td>
                    <td><?php echo $row->hiring_manager_name ?></td>
                    <td><?php echo $row->closing_date ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row->datetime)); ?></td>
                </tr>
        <?php
                $x++;
            }
        }
        ?>
    </table>

</div>

<script>
    $('.publish-btn').click(function() {
        let id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "<?= base_url() . ADMIN_URL . '/publish-job' ?>",
            dataType: "json",
            data: {
                dataid: id
            }
        }).done(function(msg) { console.log(msg.success)
            $(".publish-btn[data-id='" + id +"']").replaceWith('<span>Published</span>');
            $(".table").load(location.href + " .table");
            $('body').append('<div class="new-alert success">'+ id +' has been published.</div>');
            setTimeout(function() {
                $(".new-alert").hide();
                $(".new-alert").remove();
                window.location.reload();
            }, 2000);
        });
    });
</script>