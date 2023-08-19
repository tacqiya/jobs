<div class="page">
    <h6 class="common-title">All Categories</h6>

    <table class="table" id="<?= TBL_CATEGORY ?>">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        $x = 1;
        if (isset($categories) && !empty($categories)) {
            foreach ($categories as $row) {
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $row->title; ?></td>
                    <td><?php echo $row->datetime; ?></td>
                    <td class="actions">
                        <a href="<?php echo base_url() . ADMIN_URL; ?>/edit-category/<?php echo $row->id; ?>" class="btn edit"></a>
                        <a href="javascript:void(0)" data-id="<?php echo $row->id; ?>" class="btn dlt"></a>
                    </td>
                </tr>
                <?php
                $x++;
            }
        }
        ?>       
    </table>

</div>

