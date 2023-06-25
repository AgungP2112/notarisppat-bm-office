<script>
    $(document).ready(function() {
        loadMainData();
    });
    // ----------------------------------------------------------------------
    function loadMainData() {
        $.ajax({
            url: '<?= base_url('profil/load/main/data') ?>',
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $('#nama').val(data.nama);
                $('#username').val(data.username);
            }
        });
    };
    // ----------------------------------------------------------------------
    function processPengaturanForm() {
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
                    url: '<?= base_url('profil/process/settings/user') ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
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
                                allowOutsideClick: false
                            });
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
                        if (data.success) {
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: 'Data berhasil disimpan',
                                icon: 'success',
                                allowOutsideClick: false,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            }
        });
    };
</script>