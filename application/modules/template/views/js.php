<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- JQuery Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.3/af-2.5.2/b-2.3.5/b-colvis-2.3.5/b-html5-2.3.5/b-print-2.3.5/cr-1.6.1/date-1.3.1/fc-4.2.1/fh-3.3.1/kt-2.8.1/r-2.4.0/rg-1.3.0/rr-1.3.2/sc-2.1.0/sb-1.4.0/sp-2.1.1/sl-1.6.1/sr-1.2.1/datatables.min.js"></script>

<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.10/dist/sweetalert2.all.min.js"></script>

<!-- Notify.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- HoldOn -->
<script src="https://cdn.jsdelivr.net/npm/holdon.js@1.0.1/src/js/HoldOn.min.js"></script>

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Pusher.js -->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<!-- Custom -->
<script src="<?= base_url('assets') ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets') ?>/js/ruang-admin.js"></script>

<script>
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    function angka(data) {
        return data.toLocaleString('id-ID');
    };

    function angkaDesimal(data) {
        return parseFloat(data.toFixed(2)).toLocaleString('id-ID', {
            minimumFractionDigits: 2
        });
    };

    function checkHakAkses(hakAkses) {
        var result = false;
        $.ajax({
            url: '<?= base_url('template/check_hak_akses') ?>',
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                hak_akses: hakAkses
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
                result = data;
            }
        });
        return result.toString();
    };

    function forbiddenAccess(hakAkses) {
        var result = '';
        $.ajax({
            url: '<?= base_url('template/forbidden') ?>',
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                hak_akses: hakAkses
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
                result = data;
            }
        });
        return result;
    };

    function addLog(hakAkses) {
        $.ajax({
            url: '<?= base_url('template/add_log') ?>',
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                hak_akses: hakAkses
            }
        });
    };

    function callPusher(channel) {
        $.ajax({
            url: '<?= base_url('template/call_pusher') ?>',
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                channel: channel
            }
        });
    };
</script>


<?php if ($this->uri->segment(1) == 'login') {
    $this->load->view('login/main_js');
} ?>

<?php if ($this->uri->segment(1) == 'profil') {
    $this->load->view('profil/main_js');
} ?>

<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'penanggung_jawab' && $this->uri->segment(3) == '') {
    if (check_hak_akses('master_data_penanggung_jawab__data') == 'true') {
        $this->load->view('master_data_penanggung_jawab/main_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'penanggung_jawab' && $this->uri->segment(3) == 'add') {
    if (check_hak_akses('master_data_penanggung_jawab__add') == 'true') {
        $this->load->view('master_data_penanggung_jawab/add_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'penanggung_jawab' && $this->uri->segment(3) == 'edit') {
    if (check_hak_akses('master_data_penanggung_jawab__edit') == 'true') {
        $this->load->view('master_data_penanggung_jawab/edit_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'penanggung_jawab' && $this->uri->segment(3) == 'edit_batch') {
    if (check_hak_akses('master_data_penanggung_jawab__edit_batch') == 'true') {
        $this->load->view('master_data_penanggung_jawab/edit_batch_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'penanggung_jawab' && $this->uri->segment(3) == 'recycle_bin') {
    if (check_hak_akses('master_data_penanggung_jawab__recycle_bin') == 'true') {
        $this->load->view('master_data_penanggung_jawab/recycle_bin_js');
    }
} ?>

<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'klien' && $this->uri->segment(3) == '') {
    if (check_hak_akses('master_data_klien__data') == 'true') {
        $this->load->view('master_data_klien/main_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'klien' && $this->uri->segment(3) == 'add') {
    if (check_hak_akses('master_data_klien__add') == 'true') {
        $this->load->view('master_data_klien/add_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'klien' && $this->uri->segment(3) == 'edit') {
    if (check_hak_akses('master_data_klien__edit') == 'true') {
        $this->load->view('master_data_klien/edit_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'klien' && $this->uri->segment(3) == 'edit_batch') {
    if (check_hak_akses('master_data_klien__edit_batch') == 'true') {
        $this->load->view('master_data_klien/edit_batch_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'master_data' && $this->uri->segment(2) == 'klien' && $this->uri->segment(3) == 'recycle_bin') {
    if (check_hak_akses('master_data_klien__recycle_bin') == 'true') {
        $this->load->view('master_data_klien/recycle_bin_js');
    }
} ?>

<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'user' && $this->uri->segment(3) == '') {
    if (check_hak_akses('pengaturan_user__data') == 'true') {
        $this->load->view('pengaturan_user/main_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'user' && $this->uri->segment(3) == 'add') {
    if (check_hak_akses('pengaturan_user__add') == 'true') {
        $this->load->view('pengaturan_user/add_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'user' && $this->uri->segment(3) == 'edit') {
    if (check_hak_akses('pengaturan_user__edit') == 'true') {
        $this->load->view('pengaturan_user/edit_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'user' && $this->uri->segment(3) == 'recycle_bin') {
    if (check_hak_akses('pengaturan_user__recycle_bin') == 'true') {
        $this->load->view('pengaturan_user/recycle_bin_js');
    }
} ?>

<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'jabatan' && $this->uri->segment(3) == '') {
    if (check_hak_akses('pengaturan_jabatan__data') == 'true') {
        $this->load->view('pengaturan_jabatan/main_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'jabatan' && $this->uri->segment(3) == 'add') {
    if (check_hak_akses('pengaturan_jabatan__add') == 'true') {
        $this->load->view('pengaturan_jabatan/add_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'jabatan' && $this->uri->segment(3) == 'edit') {
    if (check_hak_akses('pengaturan_jabatan__edit') == 'true') {
        $this->load->view('pengaturan_jabatan/edit_js');
    }
} ?>
<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'jabatan' && $this->uri->segment(3) == 'recycle_bin') {
    if (check_hak_akses('pengaturan_jabatan__recycle_bin') == 'true') {
        $this->load->view('pengaturan_jabatan/recycle_bin_js');
    }
} ?>

<?php if ($this->uri->segment(1) == 'pengaturan' && $this->uri->segment(2) == 'log_aktivitas') {
    $this->load->view('pengaturan_log_aktivitas/main_js');
} ?>
</body>

</html>