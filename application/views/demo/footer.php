</div>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/popup/css/alertify.core.css'); ?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/popup/css/alertify.default.css'); ?>" id="toggleCSS" />
<script src="<?php echo base_url(); ?>assets/plugins/popup/js/alertify.min.js"></script>
<script>
    function reset() {
        alertify.set({
            labels: {
                ok: "OK",
                cancel: "Cancel"
            },
            delay: 5000,
            buttonReverse: false,
            buttonFocus: "ok"
        });
    }
    $(".dlt").on('click', function() {
        var id = $(this).data('id');
        var cat = $(this).closest('table').attr('id');
        console.log(cat);
        alertify.confirm("Are you sure, you want to delete this one ?", function(e) {
            if (e) {
                $('[data-id=' + id + ']').closest('tr').fadeOut(1000);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . ADMIN_URL; ?>/dlt',
                    data: {
                        id: id,
                        cat: cat
                    }, //How can I preview this?
                    dataType: 'json',
                    async: false, //This is deprecated in the latest version of jquery must use now callbacks
                    success: function(d) {
                        console.log(d);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
        });
        return false;
    });

    $(".pass").on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var cat = $(this).closest('table').attr('id');
        // console.log($( this ).hasClass( "viewed" ));
        if ($(this).hasClass("viewed")) {
            $(this).removeClass('viewed');
        } else {
            $(this).addClass('viewed');
        }
        // $(this).addClass('viewed');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . ADMIN_URL; ?>/pass',
            data: {
                id: id,
                cat: cat
            },
            dataType: 'json',
            async: false,
            success: function(d) { //console.log(d.value);
                if (d.value == 'error') {
                    $(this).addClass('viewed');
                } else if (d.value == 'success') {
                    $(this).removeClass('viewed');
                }
            },
            error: function(e) {
                console.log(e);
            }
        });

    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>