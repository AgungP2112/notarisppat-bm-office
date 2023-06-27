<?php if (check_hak_akses('master_data_klien__recycle_bin') == 'true') { ?>
    <script>
        $(document).ready(function() {
            loadTableMaster();
        });
        // ----------------------------------------------------------------------
        var pusher = new Pusher('466d37c14733aee83030', {
            cluster: 'ap1'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('pushMasterDataKlien', function(data) {
            $('#tableMaster').DataTable().ajax.reload(null, false);
        });

        $('#masterAllCheckbox').click(function() {
            if ($(this).is(':checked')) {
                $('.masterCheckbox').prop('checked', true);
            } else {
                $('.masterCheckbox').prop('checked', false);
            }
        });
        // ----------------------------------------------------------------------
        var tableMaster;

        function loadTableMaster() {
            tableMaster = $('#tableMaster').DataTable({
                dom: "<'row'<'col-lg-3 col-md-3 col-xs-12 dt-custom-length'l><'col-lg-9 col-md-9 col-xs-12 dt-custom-buttons'B>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row'<'col-lg-5 col-md-5 col-xs-12'i><'col-lg-7 col-md-7 col-xs-12 dt-custom-pagination'p>>",
                buttons: [{
                        extend: 'copy',
                        className: "btn btn-sm btn-dark",
                        text: '<i class="fas fa-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        className: "btn btn-sm btn-dark",
                        text: '<i class="fas fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        className: "btn btn-sm btn-dark",
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: "btn btn-sm btn-dark",
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: "btn btn-sm btn-dark",
                        text: '<i class="fas fa-print"></i> Print'
                    }
                ],
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: '<?= base_url('master_data/klien/load/table/recycle_bin') ?>',
                    type: "POST"
                },
                keys: true,
                select: true,
                columns: [{
                        data: "command",
                        orderable: false,
                        className: "text-center"
                    },
                    {
                        data: "checkbox",
                        orderable: false,
                        className: "text-center"
                    },
                    {
                        data: "no",
                        orderable: false,
                        className: "text-center"
                    },
                    {
                        data: "nama"
                    }
                ],
                lengthMenu: [
                    [10, 20, 50, 100],
                    [10, 20, 50, 100]
                ],
                pagingType: 'full_numbers',
                language: {
                    emptyTable: '-- KOSONG --',
                    lengthMenu: '_MENU_ Data Per Halaman',
                    info: 'Menampilkan _START_ sampai _END_ dari total _TOTAL_ data',
                    infoEmpty: '-- KOSONG --',
                    zeroRecords: '-- KOSONG --',
                    infoFiltered: '',
                    processing: "Memproses ...",
                    paginate: {
                        first: '<i class="fas fa-angles-left"></i>',
                        previous: '<i class="fas fa-circle-arrow-left"></i>',
                        next: '<i class="fas fa-circle-arrow-right"></i>',
                        last: '<i class="fas fa-angles-right"></i>'
                    },
                    select: {
                        rows: {
                            _: ""
                        }
                    }
                },
                initComplete: function() {
                    this.api().columns().every(function() {
                        var that = this;
                        $('input, select', this.footer()).on('keyup change clear', function() {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                    });
                }
            });
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('master_data_klien__restore') == 'true') { ?>
    <script>
        function restoreForm(id) {
            if (checkHakAkses('master_data_klien__restore') == 'true') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: '1 data akan dipulihkan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: '<?= base_url('master_data/klien/process/restore') ?>',
                            dataType: 'json',
                            data: {
                                klien_id: id
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
                                if (data.success) {
                                    callPusher(['pushMasterDataKlien']);
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Data berhasil dipulihkan',
                                        icon: 'success',
                                        allowOutsideClick: false
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
            } else {
                alert(forbiddenAccess('master_data_klien__restore'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('master_data_klien__restore_batch') == 'true') { ?>
    <script>
        function processRestoreBatch() {
            if (checkHakAkses('master_data_klien__restore_batch') == 'true') {
                var checkBox = $('.masterCheckbox:checked');
                if (checkBox.length > 1) {
                    var dataList = [];
                    $(checkBox).each(function() {
                        dataList.push($(this).val());
                    });
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: dataList.length + ' data akan dipulihkan',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: '<?= base_url('master_data/klien/process/restore_batch') ?>',
                                dataType: 'json',
                                data: {
                                    id: dataList
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
                                    if (data.success) {
                                        callPusher(['pushMasterDataKlien']);
                                        Swal.fire({
                                            title: 'Konfirmasi',
                                            text: 'Data berhasil dipulihkan',
                                            icon: 'success',
                                            allowOutsideClick: false
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
                } else {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Pilih lebih dari 1 data',
                        icon: 'error',
                        allowOutsideClick: false
                    });
                }
            } else {
                alert(forbiddenAccess('master_data_klien__restore_batch'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('master_data_klien__destroy') == 'true') { ?>
    <script>
        function destroyForm(id) {
            if (checkHakAkses('master_data_klien__destroy') == 'true') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: '1 data akan dihancurkan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: '<?= base_url('master_data/klien/process/destroy') ?>',
                            dataType: 'json',
                            data: {
                                klien_id: id
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
                                if (data.success) {
                                    callPusher(['pushMasterDataKlien']);
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Data berhasil dihancurkan',
                                        icon: 'success',
                                        allowOutsideClick: false
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
            } else {
                alert(forbiddenAccess('master_data_klien__destroy'));
            };
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('master_data_klien__destroy_batch') == 'true') { ?>
    <script>
        function processDestroyBatch() {
            if (checkHakAkses('master_data_klien__destroy_batch') == 'true') {
                var checkBox = $('.masterCheckbox:checked');
                if (checkBox.length > 1) {
                    var dataList = [];
                    $(checkBox).each(function() {
                        dataList.push($(this).val());
                    });
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: dataList.length + ' data akan dihancurkan',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: '<?= base_url('master_data/klien/process/destroy_batch') ?>',
                                dataType: 'json',
                                data: {
                                    id: dataList
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
                                    if (data.success) {
                                        callPusher(['pushMasterDataKlien']);
                                        Swal.fire({
                                            title: 'Konfirmasi',
                                            text: 'Data berhasil dihancurkan',
                                            icon: 'success',
                                            allowOutsideClick: false
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
                } else {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Pilih lebih dari 1 data',
                        icon: 'error',
                        allowOutsideClick: false
                    });
                }
            } else {
                alert(forbiddenAccess('master_data_klien__destroy_batch'));
            }
        };
    </script>
<?php } ?>