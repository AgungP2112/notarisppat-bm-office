<script>
    $(document).ready(function() {
        loadTableMaster();
        initTableSelectNamaUser();
        tableMaster.on('key-focus', function(e, datatable, cell, originalEvent) {
            if (originalEvent.type === 'keydown') {
                tableMaster.rows().deselect();
                tableMaster.row(cell[0][0].row).select();
            }
        });
    });
    // ---------------------------------------------------------------------------------------------------------------------
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
                url: '<?= base_url('pengaturan/log_aktivitas/load/table/main') ?>',
                type: "POST"
            },
            keys: true,
            select: true,
            columns: [{
                    data: "no",
                    orderable: false,
                    className: "text-center"
                },
                {
                    data: "nama"
                },
                {
                    data: "waktu",
                    className: "text-center"
                },
                {
                    data: "browser"
                },
                {
                    data: "ip",
                    className: "text-center"
                },
                {
                    data: "log"
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
    // ----------------------------------------------------------------------------------------------------------------------------------------
    function initTableSelectNamaUser() {
        $("#tableMasterNamaUser").select2({
            ajax: {
                url: '<?= base_url('pengaturan/log_aktivitas/load/table/select/user') ?>',
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
            placeholder: '-- PILIH --',
            templateResult: function(data) {
                return data.text
            },
            templateSelection: function(data) {
                return data.text
            },
            escapeMarkup: function(data) {
                return data;
            }
        });
        $('#tableMasterNamaUser').append(new Option('-- SEMUA --', 0, true, true)).trigger('change');
    };
</script>