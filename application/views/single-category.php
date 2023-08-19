<div class="page">
    <h6 class="common-title">Application Details</h6>

    <table class="table" id="applications">
        <tr>
            <th width="15%">Name</th>
            <td><?php echo $application->name; ?></td>
        </tr>
        <tr>
            <th>Phone number</th>
            <td><?php echo $application->phone; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $application->email; ?></td>
        </tr>
        <tr>
            <th>Nationality</th>
            <td><?php echo $application->nationality; ?></td>
        </tr>
        <tr>
            <th>Team Background</th>
            <td><?php echo $application->team_background; ?></td>
        </tr>
        <tr>
            <th>Service / Product idea</th>
            <td><?php echo $application->service_product; ?></td>
        </tr>
        <tr>
            <th>Working Technology</th>
            <td><?php echo $application->technology; ?></td>
        </tr>
        <tr>
            <th>Uniqueness</th>
            <td><?php echo $application->uniqueness; ?></td>
        </tr> 
        <tr>
            <th>Date</th>
            <td><?php echo $application->submited_on; ?></td>
        </tr>                 
    </table>

</div>

