<?php

function user_id()
{
    $ci = &get_instance();
    return $ci->session->userdata('clover_code_userid');
}

function check_already_login()
{
    $ci = &get_instance();
    $userSession = $ci->session->userdata('clover_code_userid');
    if ($userSession) {
        redirect(base_url() . 'profil');
    }
}

function check_not_login()
{
    $ci = &get_instance();
    $userSession = $ci->session->userdata('clover_code_userid');
    if (!$userSession) {
        redirect(base_url() . 'login');
    }
}

function check_root_hak_akses($menu)
{
    $ci = &get_instance();
    $ci->load->model('ext_model');
    $hakAkses = $ci->ext_model->check_root_hak_akses($menu);
    return $hakAkses;
}

function php_check_hak_akses($menu)
{
    $ci = &get_instance();
    $ci->load->model('ext_model');
    $hakAkses = $ci->ext_model->php_check_hak_akses($menu);
    return $hakAkses;
}

function add_log($log)
{
    $ci = &get_instance();
    $ci->load->model('ext_model');
    $ci->ext_model->add_log($log);
}

function add_log_open_menu($menu)
{
    $ci = &get_instance();
    $ci->load->model('ext_model');
    $ci->ext_model->add_log_open_menu($menu);
}

function add_log_forbidden($menu)
{
    $ci = &get_instance();
    $ci->load->model('ext_model');
    $ci->ext_model->add_log_forbidden($menu);
}

function call_pusher($channel)
{
    $status = true;
    if ($status == true) {
        $options = ['cluster' => 'ap1', 'useTLS' => true];
        $pusher = new Pusher\Pusher('535091a164e2cfedfb65', 'b9ae001a89cea18ac87c', '1622575', $options);
        foreach ($channel as $row) {
            $pusher->trigger('my-channel', $row, null);
        }
    }
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function rupiah_sen($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function angka($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function angka_desimal($angka)
{
    $hasil_rupiah = number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function sys_date($date)
{
    date_default_timezone_set('Asia/Singapore');
    $result = date('d-m-Y', strtotime($date));
    return $result;
}

function sys_date_time()
{
    date_default_timezone_set('Asia/Singapore');
    return date('Y-m-d H:i:s');
}

function text_search_bar($text)
{
    return '<input type="text" name="searchbox" class="form-control form-control-sm" placeholder="Cari ' . $text . ' ...">';
}

function select_search_bar($id)
{
    return '<select id="' . $id . '" class="form-control form-control-sm" style="width:100%"></select>';
}

function select_custom_search_bar($id, $data)
{
    $option = '';
    foreach ($data as $row) {
        $option .= '<option value="' . $row['value'] . '">' . $row['text'] . '</option>';
    }
    return '<select id="' . $id . '" class="form-control form-control-sm" style="width:100%">' . $option . '</select>';
}

function checkbox_all_search_bar()
{
    return '<input type="checkbox" name="masterAllCheckbox" id="masterAllCheckbox">';
}

function form_header($icon, $title, $close_button = false)
{
    $text = '<div class="d-sm-flex align-items-center justify-content-between mb-4">';
    $text .= '<h1 class="h3 mb-0 text-gray-800">' . $icon . ' ' .  $title . '</h1>';
    if ($close_button == true) {
        $text .= '<button type="button" class="btn btn-primary" onclick="window.close()"><i class="fas fa-times-circle"></i> Tutup</button>';
    }
    $text .= '</div>';
    return $text;
}

function form_menu_item($command, $icon, $nama)
{
    return '<a class="dropdown-item" href="#" onclick="' . $command . '">' . $icon . ' &nbsp;' . $nama . '</a>';
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function konversi($x)
{

    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";

    if ($x < 12) {
        $temp = " " . $angka[$x];
    } else if ($x < 20) {
        $temp = konversi($x - 10) . " belas";
    } else if ($x < 100) {
        $temp = konversi($x / 10) . " puluh" . konversi($x % 10);
    } else if ($x < 200) {
        $temp = " seratus" . konversi($x - 100);
    } else if ($x < 1000) {
        $temp = konversi($x / 100) . " ratus" . konversi($x % 100);
    } else if ($x < 2000) {
        $temp = " seribu" . konversi($x - 1000);
    } else if ($x < 1000000) {
        $temp = konversi($x / 1000) . " ribu" . konversi($x % 1000);
    } else if ($x < 1000000000) {
        $temp = konversi($x / 1000000) . " juta" . konversi($x % 1000000);
    } else if ($x < 1000000000000) {
        $temp = konversi($x / 1000000000) . " milyar" . konversi($x % 1000000000);
    }

    return $temp;
}

function tkoma($x)
{
    $str = stristr($x, ",");
    $ex = explode(',', $x);

    if (($ex[1] / 10) >= 1) {
        $a = abs($ex[1]);
    }
    $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan",   "sembilan", "sepuluh", "sebelas");
    $temp = "";

    $a2 = $ex[1] / 10;
    $pjg = strlen($str);
    $i = 1;


    if ($a >= 1 && $a < 12) {
        $temp .= " " . $string[$a];
    } else if ($a > 12 && $a < 20) {
        $temp .= konversi($a - 10) . " belas";
    } else if ($a > 20 && $a < 100) {
        $temp .= konversi($a / 10) . " puluh" . konversi($a % 10);
    } else {
        if ($a2 < 1) {

            while ($i < $pjg) {
                $char = substr($str, $i, 1);
                $i++;
                $temp .= " " . $string[$char];
            }
        }
    }
    return $temp;
}

function terbilang_dengan_koma($x)
{
    if ($x < 0) {
        $hasil = "minus " . trim(konversi($x));
    } else {
        $poin = trim(tkoma($x));
        $hasil = trim(konversi($x));
    }

    if ($poin) {
        $hasil = $hasil . " koma " . $poin;
    } else {
        $hasil = $hasil;
    }
    return $hasil;
}
