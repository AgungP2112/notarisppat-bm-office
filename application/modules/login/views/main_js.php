<script>
    // ----------------------------------------------------------------------
    $('#username').keydown(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            $('#password').focus();
        };
    });
    // ----------------------------------------------------------------------
    $('#password').keydown(function(event) {
        if (event.which == 13) {
            event.preventDefault();
            $('#submit').focus();
        };
    });
    // ----------------------------------------------------------------------
    function processForm() {
        $.ajax({
            url: '<?= base_url('login/process') ?>',
            method: "POST",
            data: {
                username: $('#username').val(),
                password: $('#password').val()
            },
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    if (data.usernameError != '') {
                        $.notify((data.usernameError).replace('<p>', '').replace('</p>', ''), 'error');
                    }
                    if (data.passwordError != '') {
                        $.notify((data.passwordError).replace('<p>', '').replace('</p>', ''), 'error');
                    }
                    if (data.customError != '') {
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: data.customError,
                            icon: 'error',
                            allowOutsideClick: false
                        });
                    }
                }
                if (data.success) {
                    window.open('<?= base_url('profil') ?>', '_self');
                }
            }
        })
    };
</script>