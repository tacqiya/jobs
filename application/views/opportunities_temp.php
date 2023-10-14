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
            <th>Action</th>
            <th>Category</th>
            <th>Requisition ID</th>
            <th>Position Title</th>
            <th>Division - Name</th>
            <th>Department - Name</th>
            <th>Recruiter</th>
            <th>Hiring Manager</th>
            <th>Closing date</th>
            <th>Publish</th>
        </tr>
        <?php
        $x = 1;
        if (isset($opportunities) && !empty($opportunities)) {
            foreach ($opportunities as $row) {
        ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td style="width: 5%" class="actions">
                        <a href="<?php echo base_url() . ADMIN_URL; ?>/edit-opportunity-temp/<?php echo $row->id; ?>" class="btn edit"></a>
                        <a href="javascript:void(0)" data-id="<?php echo $row->id; ?>" class="btn dlt"></a>
                    </td>
                    <td><?php echo $row->category; ?></td>
                    <td><?php echo $row->requisition_id; ?></td>
                    <td style="width: 20%;"><?php echo $row->description_value; ?></td>
                    <td><?php echo $row->division_name; ?></td>
                    <td><?php echo $row->dept_name; ?></td>
                    <td><?php echo $row->recruiter_name ?></td>
                    <td><?php echo $row->hiring_manager_name ?></td>
                    <td><?php echo $row->closing_date ?></td>
                    <td>
                        <?php if ($row->publish == 'published') { ?>
                            <span>Published</span>
                        <?php } else { ?>
                            <button class="btn btn-info publish-btn" data-id="<?= $row->requisition_id ?>">Publish</button>
                        <?php } ?>
                    </td>
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
        }).done(function(msg) {
            $(".publish-btn[data-id='" + id +"']").replaceWith('<span>Published</span>');
            $(".table").load(location.href + " .table");
        });
    });
</script>