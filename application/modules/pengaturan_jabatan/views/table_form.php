<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="table-responsive">
            <table id="tableMaster" class="table table-bordered table-hover table-sm" width="100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th style="text-align:center;vertical-align:middle" width="5%">No.</th>
                        <th style="text-align:center;vertical-align:middle" width="40%">Menu</th>
                        <th style="text-align:center;vertical-align:middle" width="10%">Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <section id="master_data_penanggung_jawab-sec">
                        <tr>
                            <td colspan="2" class="text-white bg-primary"><i><b>Master Data - Penanggung Jawab</b></i></td>
                            <td class="text-white bg-primary" style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="allCheckbox" id="master_data_penanggung_jawab_all">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">1.</td>
                            <td>Data</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__data" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">2.</td>
                            <td>Tambah</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__add" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Tambah">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">3.</td>
                            <td>Edit</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__edit" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Edit">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">4.</td>
                            <td>Edit Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__edit_batch" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Edit Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">5.</td>
                            <td>Hapus</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__delete" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Hapus">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">6.</td>
                            <td>Hapus Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__delete_batch" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Hapus Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">7.</td>
                            <td>Lihat Tong Sampah</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__recycle_bin" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Lihat Tong Sampah">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">8.</td>
                            <td>Pulihkan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__restore" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Pulihkan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">9.</td>
                            <td>Pulihkan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__restore_batch" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Pulihkan Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">10.</td>
                            <td>Hancurkan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__destroy" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Hancurkan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">11.</td>
                            <td>Hancurkan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="master_data_penanggung_jawab" id="master_data_penanggung_jawab__destroy_batch" data-checkbox="true" data-namamenu="Master Data - Penanggung Jawab - Hancurkan Batch">
                            </td>
                        </tr>
                    </section>
                    <section id="pengaturan_user-sec">
                        <tr>
                            <td colspan="2" class="text-white bg-primary"><i><b>Pengaturan - User</b></i></td>
                            <td class="text-white bg-primary" style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="allCheckbox" id="pengaturan_user_all">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">1.</td>
                            <td>Data</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__data" data-checkbox="true" data-namamenu="Pengaturan - User">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">2.</td>
                            <td>Tambah</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__add" data-checkbox="true" data-namamenu="Pengaturan - User - Tambah">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">3.</td>
                            <td>Edit</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__edit" data-checkbox="true" data-namamenu="Pengaturan - User - Edit">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">4.</td>
                            <td>Hapus</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__delete" data-checkbox="true" data-namamenu="Pengaturan - User - Hapus">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">5.</td>
                            <td>Hapus Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__delete_batch" data-checkbox="true" data-namamenu="Pengaturan - User - Hapus Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">6.</td>
                            <td>Lihat Tong Sampah</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__recycle_bin" data-checkbox="true" data-namamenu="Pengaturan - User - Lihat Tong Sampah">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">7.</td>
                            <td>Pulihkan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__restore" data-checkbox="true" data-namamenu="Pengaturan - User - Pulihkan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">8.</td>
                            <td>Pulihkan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__restore_batch" data-checkbox="true" data-namamenu="Pengaturan - User - Pulihkan Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">9.</td>
                            <td>Hancurkan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__destroy" data-checkbox="true" data-namamenu="Pengaturan - User - Hancurkan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">10.</td>
                            <td>Hancurkan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__destroy_batch" data-checkbox="true" data-namamenu="Pengaturan - User - Hancurkan Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">11.</td>
                            <td>Ganti Status Keaktifan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__switch_active" data-checkbox="true" data-namamenu="Pengaturan - User - Ganti Status Keaktifan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">12.</td>
                            <td>Ganti Status Keaktifan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_user" id="pengaturan_user__switch_active_batch" data-checkbox="true" data-namamenu="Pengaturan - User - Ganti Status Keaktifan Batch">
                            </td>
                        </tr>
                    </section>
                    <section id="pengaturan_jabatan-sec">
                        <tr>
                            <td colspan="2" class="text-white bg-primary"><i><b>Pengaturan - Jabatan</b></i></td>
                            <td class="text-white bg-primary" style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="allCheckbox" id="pengaturan_jabatan_all">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">1.</td>
                            <td>Data</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__data" data-checkbox="true" data-namamenu="Pengaturan - Jabatan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">2.</td>
                            <td>Tambah</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__add" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Tambah">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">3.</td>
                            <td>Edit</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__edit" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Edit">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">4.</td>
                            <td>Hapus</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__delete" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Hapus">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">5.</td>
                            <td>Hapus Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__delete_batch" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Hapus Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">6.</td>
                            <td>Lihat Tong Sampah</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__recycle_bin" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Lihat Tong Sampah">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">7.</td>
                            <td>Pulihkan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__restore" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Pulihkan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">8.</td>
                            <td>Pulihkan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__restore_batch" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Pulihkan Batch">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">9.</td>
                            <td>Hancurkan</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__destroy" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Hancurkan">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center;vertical-align:top" width="5%">10.</td>
                            <td>Hancurkan Batch</td>
                            <td style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_jabatan" id="pengaturan_jabatan__destroy_batch" data-checkbox="true" data-namamenu="Pengaturan - Jabatan - Hancurkan Batch">
                            </td>
                        </tr>
                    </section>
                    <section id="pengaturan_log_aktivitas-sec">
                        <tr>
                            <td colspan="2" class="text-white bg-primary"><i><b>Pengaturan - Log Aktivitas</b></i></td>
                            <td class="text-white bg-primary" style="text-align:center;vertical-align:top">
                                <input type="checkbox" name="pengaturan_log_aktivitas" id="pengaturan_log_aktivitas" data-checkbox="true" data-namamenu="Pengaturan - Log Aktivitas">
                            </td>
                        </tr>
                    </section>
                </tbody>
            </table>
        </div>
    </div>
</div>