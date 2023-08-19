<div class="page">
    <h6 class="common-title">All Careers</h6>

    <table class="table" id="<?= TBL_CAREER ?>">
        <tr>
            <th>#</th>
            <th>Action</th>
            <th>Category</th>
            <th>Position Title</th>
            <th>Position Code</th>
            <th>Position Type</th>
            <th>Project Title</th>
            <th>Project Supervisor</th>
            <th>Academic Department</th>
            <th>Relevent Research Center</th>
            <th>Date</th>
        </tr>
        <?php
        $x = 1;
        if (isset($opportunities) && !empty($opportunities)) {
            foreach ($opportunities as $row) {
                ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td class="actions">
                        <a target="_blank" href="<?php echo MAIN_URL; ?>opportunity?lang=en&redirectionURI=<?php echo $row->slug; ?>" class="btn view"></a>
                        <a href="<?php echo base_url() . ADMIN_URL; ?>/edit-opportunity/<?php echo $row->id; ?>" class="btn edit"></a>
                        <a href="javascript:void(0)" data-id="<?php echo $row->id; ?>" class="btn dlt"></a>
                    </td>
                    <td><?php echo $row->category; ?></td>
                    <td><?php echo $row->position_title; ?></td>
                    <td><?php echo $row->position_code; ?></td>
                    <td><?php echo $row->position_type; ?></td>
                    <td><?php echo $row->project_title; ?></td>
                    <td><?php echo $row->project_supervisor; ?></td>
                    <td><?php echo $row->academic_department; ?></td>
                    <td><?php echo $row->relevant_research_center; ?></td>
                    <td><?php echo $row->datetime; ?></td>
                </tr>
                <?php
                $x++;
            }
        }
        ?>       
    </table>

</div>