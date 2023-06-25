<script>
    $(document).ready(function() {
        loadMainData();
    });
    // ----------------------------------------------------------------------
    function loadMainData() {
        $.ajax({
            url: '<?= base_url('pengaturan/jabatan/load/data/edit') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                jabatan_id: '<?= $this->uri->segment(4) ?>'
            },
            success: function(data) {
                $('#nama').val(data[0].nama);
                data.forEach(function(row) {
                    if (row.akses == 'true') {
                        $('#' + row.menu).prop('checked', true);
                    } else {
                        $('#' + row.menu).prop('checked', false);
                    }
                });
            }
        })
    };
    // ----------------------------------------------------------------------
    $('input[name="allCheckbox"]').click(function() {
        switch ($(this).attr('id')) {
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
                    url: '<?= base_url('pengaturan/jabatan/process/edit') ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
                        jabatan_id: '<?= $this->uri->segment(4) ?>',
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
                                    window.close();
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