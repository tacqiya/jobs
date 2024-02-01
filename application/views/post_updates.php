<div class="page">
    <h6 class="common-title">All Categories</h6>

    <table class="table" id="<?= TBL_TALEO ?>">
        <tr>
            <th>#</th>
            <th>Updated Method</th>
            <th>Updated Status</th>
            <th>Updated Table</th>
            <th>Date</th>
        </tr>
        <?php
        $x = 1;
        if (isset($updates) && !empty($updates)) {
            foreach ($updates as $row) {
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $row->updated_method; ?></td>
                    <?php if($row->updated_batch == 'yes') { ?>
                    <td>
                    <ul style="list-style-type:disc; padding: 0 20px;">
                        <?php foreach(unserialize($row->update_status) as $up_data) {
                        echo '<li>'.$up_data.'</li>';
                    } ?>
                    </ul>    
                    </td>
                    <?php } else { ?>
                        <td><?php echo $row->update_status; ?></td>
                    <?php } ?>
                    <td><?php echo $row->updated_table; ?></td>
                    <td><?php echo date('Y-m-d h:i:s a', strtotime($row->datetime)); ?></td>
                </tr>
                <?php
                $x++;
            }
        }
        ?>       
    </table>

</div>

