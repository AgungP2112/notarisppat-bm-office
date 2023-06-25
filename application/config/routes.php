<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'profil';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['error_403_no_data_found'] = 'dashboard/error403NoDataFound';

// Login / Logout
$route['login/process'] = 'login/process_login';
$route['logout']        = 'login/logout';

// Profil
$route['profil']                       = 'profil';
$route['profil/load']                  = 'profil/load';
$route['profil/process/settings/user'] = 'profil/process_settings_user';
$route['profil/load/main/data']        = 'profil/load_main_data';

// Template
$route['template/php_check_hak_akses'] = 'template/php_check_hak_akses';
$route['template/forbidden']           = 'template/forbidden';
$route['template/add_log']             = 'template/add_log_client';
$route['template/call_pusher']         = 'template/call_pusher';
$route['error_403']                    = 'template/error_403';

// --------------------------------------------------------------------
// PENGATURAN
// --------------------------------------------------------------------
// Pengaturan - User
$route['pengaturan/user']                                      = 'pengaturan_user';
$route['pengaturan/user/load/table/main']                      = 'pengaturan_user/load_table_main';
$route['pengaturan/user/load/select/jabatan']                  = 'pengaturan_user/load_select_jabatan';
$route['pengaturan/user/add']                                  = 'pengaturan_user/add_form';
$route['pengaturan/user/process/add']                          = 'pengaturan_user/process_add';
$route['pengaturan/user/edit/(:num)']                          = 'pengaturan_user/edit_form';
$route['pengaturan/user/load/data/edit']                       = 'pengaturan_user/load_data_edit';
$route['pengaturan/user/process/edit']                         = 'pengaturan_user/process_edit';
$route['pengaturan/user/edit_batch/(:any)']                    = 'pengaturan_user/edit_batch_form';
$route['pengaturan/user/load/data/edit_batch']                 = 'pengaturan_user/load_data_edit_batch';
$route['pengaturan/user/process/edit_batch']                   = 'pengaturan_user/process_edit_batch';
$route['pengaturan/user/process/delete']                       = 'pengaturan_user/process_delete';
$route['pengaturan/user/process/delete_batch']                 = 'pengaturan_user/process_delete_batch';
$route['pengaturan/user/process/ganti_status_keaktifan']       = 'pengaturan_user/process_ganti_status_keaktifan';
$route['pengaturan/user/process/ganti_status_keaktifan_batch'] = 'pengaturan_user/process_ganti_status_keaktifan_batch';
$route['pengaturan/user/recycle_bin']                          = 'pengaturan_user/recycle_bin_form';
$route['pengaturan/user/load/table/recycle_bin']               = 'pengaturan_user/load_table_recycle_bin';
$route['pengaturan/user/process/restore']                      = 'pengaturan_user/process_restore';
$route['pengaturan/user/process/restore_batch']                = 'pengaturan_user/process_restore_batch';
$route['pengaturan/user/process/destroy']                      = 'pengaturan_user/process_destroy';
$route['pengaturan/user/process/destroy_batch']                = 'pengaturan_user/process_destroy_batch';

// Pengaturan - Jabatan
$route['pengaturan/jabatan']                        = 'pengaturan_jabatan';
$route['pengaturan/jabatan/load/table/main']        = 'pengaturan_jabatan/load_table_main';
$route['pengaturan/jabatan/add']                    = 'pengaturan_jabatan/add_form';
$route['pengaturan/jabatan/process/add']            = 'pengaturan_jabatan/process_add';
$route['pengaturan/jabatan/edit/(:num)']            = 'pengaturan_jabatan/edit_form';
$route['pengaturan/jabatan/load/data/edit']         = 'pengaturan_jabatan/load_data_edit';
$route['pengaturan/jabatan/process/edit']           = 'pengaturan_jabatan/process_edit';
$route['pengaturan/jabatan/process/delete']         = 'pengaturan_jabatan/process_delete';
$route['pengaturan/jabatan/process/delete_batch']   = 'pengaturan_jabatan/process_delete_batch';
$route['pengaturan/jabatan/recycle_bin']            = 'pengaturan_jabatan/recycle_bin_form';
$route['pengaturan/jabatan/load/table/recycle_bin'] = 'pengaturan_jabatan/load_table_recycle_bin';
$route['pengaturan/jabatan/process/restore']        = 'pengaturan_jabatan/process_restore';
$route['pengaturan/jabatan/process/restore_batch']  = 'pengaturan_jabatan/process_restore_batch';
$route['pengaturan/jabatan/process/destroy']        = 'pengaturan_jabatan/process_destroy';
$route['pengaturan/jabatan/process/destroy_batch']  = 'pengaturan_jabatan/process_destroy_batch';

// Pengaturan - Log Aktivitas
$route['pengaturan/log_aktivitas']                        = 'pengaturan_log_aktivitas';
$route['pengaturan/log_aktivitas/load/table/main']        = 'pengaturan_log_aktivitas/load_table_main';
$route['pengaturan/log_aktivitas/load/table/select/user'] = 'pengaturan_log_aktivitas/load_table_select_user';
