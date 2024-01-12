<div class="page">
    <h6 class="common-title">Import Job Descriptions</h6>
    <section class="ftco-section">
        <div class="container">
            
            <div class="row mt-5">
                <div class="col-md-6 m-auto">
                    <form method="post" id="import_form" enctype="multipart/form-data">
                        <div class="file-upload-wrapper" data-text="Click here to upload the Excelsheet">
                            <!-- <p><label>Select Excel File</label> -->
                            <input type="file" name="file" id="file" class="file-upload-field" required accept=".csv, .xlsx, .xls" />
                            <!-- </p> -->
                        </div>
                        <br />
                        <div class="text-center">
                            <input type="submit" name="import" value="Import" class="btn btn-lg btn-info px-5" />
                        </div>
                        <!-- <div class="text-center mt-5 font-weight-bold text-success">
                            <a class="text-success link-success" href="<?= base_url() ?>assets/resources/sample_template.xlsx" download>Download sample template
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z" />
                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                </svg></a>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="spinner-closure">
        <div class="lds-dual-ring"></div>
    </div>
</div>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://use.fontawesome.com/a905693f00.js"></script>

<script>
    $(document).ready(function() {
        $("form").on("change", ".file-upload-field", function() {
            $(this).parent(".file-upload-wrapper").attr("data-text", $(this).val().replace(/.*(\/|\\)/, ''));
        });
        $('#import_form').on('submit', function(event) {
            event.preventDefault();
            $('.spinner-closure').show();
            $.ajax({
                url: "<?= base_url().ADMIN_URL.'/jd-import'; ?>",
                dataType: 'json',
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('.spinner-closure').hide();
                    if (!data['error']) {
                        $.dialog({
                            type: 'green',
                            title: 'Success',
                            content: data['message'],
                            boxWidth: '30%',
                            useBootstrap: false,
                            buttons: {},
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        $.dialog({
                            type: 'red',
                            title: 'Failed',
                            content: data['message'],
                            boxWidth: '30%',
                            useBootstrap: false,
                        });
                    }
                },
                error: function(error) {
                    $.dialog({
                        type: 'red',
                        title: 'Failed',
                        content: 'Something went wrong',
                        boxWidth: '30%',
                        useBootstrap: false,
                    });
                }
            })
        });
    });
</script>











    <!-- <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="<?= base_url() ?>assets/plugins/jqueryConfirm/js/jquery-confirm.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jqueryConfirm/css/jquery-confirm.css" />

    <link href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>assets/plugins/datatables/extensions/Select/css/select.dataTables.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>assets/plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.1.10.21.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/datatables/extensions/Select/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>

    
    <link href="<?= base_url() ?>assets/scss/admin.css?v=1.0" type="text/css" rel="stylesheet" />

    <link href="<?= base_url() ?>assets/plugins/toastr/build/toastr.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?= base_url() ?>assets/plugins/toastr/build/toastr.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/toastr.config.min.js"></script> -->