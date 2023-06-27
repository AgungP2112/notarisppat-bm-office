<script>
    $(document).ready(function() {
        loadMainData();
    });
    // ----------------------------------------------------------------------
    function loadMainData() {
        $.ajax({
            url: '<?= base_url('master_data/klien/load/data/edit') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                klien_id: '<?= $this->uri->segment(4) ?>'
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
                $('#nama').val(data.nama);
            }
        })
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
                    url: '<?= base_url('master_data/klien/process/edit') ?>',
                    type: "POST",
                    dataType: "json",
                    data: {
                        klien_id: '<?= $this->uri->segment(4) ?>',
                        nama: $('#nama').val()
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
                            callPusher(['pushMasterDataKlien']);
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