<?php if (check_hak_akses('pengaturan_user__data') == 'true') { ?>
    <script>
        $(document).ready(function() {
            loadTableMaster();
            tableMaster.on('key-focus', function(e, datatable, cell, originalEvent) {
                if (originalEvent.type === 'keydown') {
                    tableMaster.rows().deselect();
                    tableMaster.row(cell[0][0].row).select();
                }
            });
        });
        // ----------------------------------------------------------------------

        var pusher = new Pusher('535091a164e2cfedfb65', {
            cluster: 'ap1'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('pushPengaturanUser', function(data) {
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
                        className: "btn btn-sm bg-dark",
                        text: '<i class="fas fa-copy"></i> Copy'
                    },
                    {
                        extend: 'csv',
                        className: "btn btn-sm bg-dark",
                        text: '<i class="fas fa-file-csv"></i> CSV'
                    },
                    {
                        extend: 'excel',
                        className: "btn btn-sm bg-dark",
                        text: '<i class="fas fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'pdf',
                        className: "btn btn-sm bg-dark",
                        text: '<i class="fas fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'print',
                        className: "btn btn-sm bg-dark",
                        text: '<i class="fas fa-print"></i> Print'
                    }
                ],
                processing: true,
                serverSide: true,
                order: [],
                ajax: {
                    url: '<?= base_url('pengaturan/user/load/table/main') ?>',
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
                        data: "username"
                    },
                    {
                        data: "nama"
                    },
                    {
                        data: "jabatan"
                    },
                    {
                        data: "aktif",
                        orderable: false,
                        className: "text-center"
                    },
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

<?php if (check_hak_akses('pengaturan_user__add') == 'true') { ?>
    <script>
        function addForm() {
            if (checkHakAkses('pengaturan_user__add') == 'true') {
                window.open('<?= base_url('pengaturan/user/add') ?>');
            } else {
                alert(forbiddenAccess('pengaturan_user__add'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('pengaturan_user__edit') == 'true') { ?>
    <script>
        function editForm(id) {
            if (checkHakAkses('pengaturan_user__edit') == 'true') {
                window.open('<?= base_url('pengaturan/user/edit/') ?>' + id);
            } else {
                alert(forbiddenAccess('pengaturan_user__edit'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('pengaturan_user__delete') == 'true') { ?>
    <script>
        function deleteForm(id) {
            if (checkHakAkses('pengaturan_user__delete') == 'true') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: '1 data akan dihapus',
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
                            url: '<?= base_url('pengaturan/user/process/delete') ?>',
                            dataType: 'json',
                            data: {
                                user_id: id
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
                                    callPusher(['pushPengaturanUser']);
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Data berhasil dihapus',
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
                alert(forbiddenAccess('pengaturan_user__delete'));
            };
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('pengaturan_user__delete_batch') == 'true') { ?>
    <script>
        function processDeleteBatch() {
            if (checkHakAkses('pengaturan_user__delete_batch') == 'true') {
                var checkBox = $('.masterCheckbox:checked');
                if (checkBox.length > 1) {
                    var dataList = [];
                    $(checkBox).each(function() {
                        dataList.push($(this).val());
                    })
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: dataList.length + ' data akan dihapus',
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
                                url: '<?= base_url('pengaturan/user/process/delete_batch') ?>',
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
                                        callPusher(['pushPengaturanUser']);
                                        Swal.fire({
                                            title: 'Konfirmasi',
                                            text: 'Data berhasil dihapus',
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
                alert(forbiddenAccess('pengaturan_user__delete_batch'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('pengaturan_user__switch_active') == 'true') { ?>
    <script>
        function gantiStatusKeaktifanForm(id) {
            if (checkHakAkses('pengaturan_user__switch_active') == 'true') {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'User ini akan diubah status keaktifannya. Jika user saat ini aktif, maka akan diubah menjadi nonaktif. Jika user saat ini nonaktif, maka akan diubah menjadi aktif. Yakin ingin melanjutkan?',
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
                            url: '<?= base_url('pengaturan/user/process/ganti_status_keaktifan') ?>',
                            dataType: 'json',
                            data: {
                                user_id: id
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
                                    callPusher(['pushPengaturanUser']);
                                    Swal.fire({
                                        title: 'Konfirmasi',
                                        text: 'Data berhasil disimpan',
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
                alert(forbiddenAccess('pengaturan_user__switch_active'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('pengaturan_user__switch_active_batch') == 'true') { ?>
    <script>
        function processGantiStatusKeaktifanBatch() {
            if (checkHakAkses('pengaturan_user__switch_active_batch') == 'true') {
                var checkBox = $('.masterCheckbox:checked');
                if (checkBox.length > 1) {
                    var dataList = [];
                    $(checkBox).each(function() {
                        dataList.push($(this).val());
                    })
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: dataList.length + ' akan diubah status keaktifannya. Jika user saat ini aktif, maka akan diubah menjadi nonaktif. Jika user saat ini nonaktif, maka akan diubah menjadi aktif. Yakin ingin melanjutkan?',
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
                                url: '<?= base_url('pengaturan/user/process/ganti_status_keaktifan_batch') ?>',
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
                                        callPusher(['pushPengaturanUser']);
                                        Swal.fire({
                                            title: 'Konfirmasi',
                                            text: 'Data berhasil disimpan',
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
                };
            } else {
                alert(forbiddenAccess('pengaturan_user__switch_active_batch'));
            }
        };
    </script>
<?php } ?>

<?php if (check_hak_akses('pengaturan_user__recycle_bin') == 'true') { ?>
    <script>
        function binForm() {
            if (checkHakAkses('pengaturan_user__recycle_bin') == 'true') {
                window.open('<?= base_url('pengaturan/user/recycle_bin') ?>');
            } else {
                alert(forbiddenAccess('pengaturan_user__recycle_bin'));
            }
        };
    </script>
<?php } ?>