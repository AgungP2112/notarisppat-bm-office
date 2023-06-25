<script>
    $(document).ready(function() {
        initJabatan();
        $('#jabatan').select2('open');
    });
    // ----------------------------------------------------------------------
    function initJabatan() {
        $('#jabatan').select2({
            ajax: {
                url: '<?= base_url('pengaturan/user/load/select/jabatan') ?>',
                type: "POST",
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            templateResult: function(data) {
                return data.text
            },
            templateSelection: function(data) {
                return data.text
            },
            escapeMarkup: function(data) {
                return data;
            },
            placeholder: '-- PILIH --'
        });
    };
    // ----------------------------------------------------------------------
    function processForm() {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin datanya sudah benar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            allowOutsideClick: false
        }).then((result) => {
            if (result.value) {
                $('#submit').blur();

                $.ajax({
                    url: '<?= base_url('pengaturan/user/process/add') ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
                        jabatan_id: $('#jabatan :selected').val(),
                        nama: $('#nama').val(),
                        username: $('#username').val(),
                        password: $('#password').val(),
                        ulangi_password: $('#ulangiPassword').val()
                    },
                    beforeSend: function() {
                        HoldOn.open({
                            theme: 'sk-circle',
                            message: "<h4>Memproses ... </h4>"
                        })
                    },
                    complete: function() {
                        HoldOn.close();
                    },
                    success: function(data) {
                        if (data.error) {
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: 'Data gagal disimpan! Cek kembali inputtan!',
                                icon: 'error',
                                allowOutsideClick: false,
                                didClose: function() {
                                    if (data.jabatanIdError != '') {
                                        $.notify((data.jabatanIdError).replace('<p>', '').replace('</p>', ''), 'error')
                                    }
                                    if (data.namaError != '') {
                                        $.notify((data.namaError).replace('<p>', '').replace('</p>', ''), 'error')
                                    }
                                    if (data.usernameError != '') {
                                        $.notify((data.usernameError).replace('<p>', '').replace('</p>', ''), 'error')
                                    }
                                    if (data.passwordError != '') {
                                        $.notify((data.passwordError).replace('<p>', '').replace('</p>', ''), 'error')
                                    }
                                    if (data.ulangiPasswordError != '') {
                                        $.notify((data.ulangiPasswordError).replace('<p>', '').replace('</p>', ''), 'error')
                                    }
                                }
                            });
                        }
                        if (data.success) {
                            callPusher(['pushPengaturanUser']);
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: 'Data berhasil disimpan',
                                icon: 'success',
                                allowOutsideClick: false,
                                didClose: function() {
                                    $('#nama').focus();
                                }
                            });
                        } else {
                            if (data.redirect) {
                                window.open("<?= base_url('error_403') ?>", '_self');
                            }
                        }
                    }
                });
            };
        });
    };
</script>