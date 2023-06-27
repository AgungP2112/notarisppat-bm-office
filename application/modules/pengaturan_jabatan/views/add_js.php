<script>
    // ----------------------------------------------------------------------
    $('input[name="allCheckbox"]').click(function() {
        switch ($(this).attr('id')) {
            case 'master_data_penanggung_jawab_all':
                if ($(this).is(':checked')) {
                    $('input[name="master_data_penanggung_jawab"]').prop('checked', true);
                } else {
                    $('input[name="master_data_penanggung_jawab"]').prop('checked', false);
                }
                break;
            case 'master_data_klien_all':
                if ($(this).is(':checked')) {
                    $('input[name="master_data_klien"]').prop('checked', true);
                } else {
                    $('input[name="master_data_klien"]').prop('checked', false);
                }
                break;
            case 'master_data_rekening_all':
                if ($(this).is(':checked')) {
                    $('input[name="master_data_rekening"]').prop('checked', true);
                } else {
                    $('input[name="master_data_rekening"]').prop('checked', false);
                }
                break;
            case 'pengaturan_user_all':
                if ($(this).is(':checked')) {
                    $('input[name="pengaturan_user"]').prop('checked', true);
                } else {
                    $('input[name="pengaturan_user"]').prop('checked', false);
                }
                break;
            case 'pengaturan_jabatan_all':
                if ($(this).is(':checked')) {
                    $('input[name="pengaturan_jabatan"]').prop('checked', true);
                } else {
                    $('input[name="pengaturan_jabatan"]').prop('checked', false);
                }
                break;
        }
    });
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

                var table = [];
                var sub;
                $('input[data-checkbox="true"]').each(function() {
                    sub = {
                        root: $(this).attr('name'),
                        menu: $(this).attr('id'),
                        nama_menu: $(this).data('namamenu'),
                        akses: $(this).is(':checked')
                    }
                    table.push(sub);
                });

                $.ajax({
                    url: '<?= base_url('pengaturan/jabatan/process/add') ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
                        nama: $('#nama').val(),
                        table: table
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
                                    if (data.namaError != '') {
                                        $.notify((data.namaError).replace('<p>', '').replace('</p>', ''), 'error')
                                    }
                                }
                            });
                        }
                        if (data.success) {
                            callPusher(['pushPengaturanJabatan']);
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