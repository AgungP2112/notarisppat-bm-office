<script>
    $(document).ready(function() {
        loadMainData();
    });
    // ----------------------------------------------------------------------
    function loadMainData() {
        $.ajax({
            url: '<?= base_url('master_data/rekening/load/data/edit_batch') ?>',
            type: "POST",
            dataType: 'json',
            data: {
                rekening_id: '<?= $this->uri->segment(4) ?>'
            },
            beforeSend: function() {
                HoldOn.open({
                    theme: 'sk-circle',
                    message: "<h4>Memproses ... </h4>"
                });
            },
            complete: function() {
                HoldOn.close();
            },
            success: function(data) {
                data.forEach(function(row) {
                    append(row);
                });
            }
        });
    };
    // ----------------------------------------------------------------------
    function append(data) {
        output = '<tr>';
        output += '<td style="vertical-align:top">' + data.nama + '</td>';
        output += '<td style="vertical-align:top">' + data.nomor_rekening + '</td>';
        output += '</tr>';
        $('#tableBatchEdit tbody').append(output);
    };
    // ----------------------------------------------------------------------
    function processForm() {
        if ($('#checkboxnama').is(':checked') == false && $('#checkboxnomorrekening').is(':checked') == false) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Centang minimal satu jenis perubahan!',
                icon: 'error',
                allowOutsideClick: false
            });
        } else {
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
                        url: '<?= base_url('master_data/rekening/process/edit_batch') ?>',
                        type: "POST",
                        dataType: "json",
                        data: {
                            rekening_id: '<?= $this->uri->segment(4) ?>',
                            nama_check: $('#checkboxnama').is(':checked'),
                            nama: $('#nama').val(),
                            nomor_rekening_check: $('#checkboxnomorrekening').is(':checked'),
                            nomor_rekening: $('#nomorrekening').val()
                        },
                        beforeSend: function() {
                            HoldOn.open({
                                theme: 'sk-circle',
                                message: "<h4>Memproses ... </h4>"
                            });
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
                                callPusher(['pushMasterDataRekening']);
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
                }
            });
        }
    };
</script>