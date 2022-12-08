<?php
/**
 * Headbook Management System
 * @version 4.x
 * @author Group DNTU
 * @license GNU/GPL version 3 
 * @see https://github.com/phapdev/manage_headbook.git The Manage headbook GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}


$page_title = $lang_module['week_list'];

$xtpl = new XTemplate('weeklist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);


$schoolyearid = $nv_Request->get_int('schoolyearid', 'post,get');
// lay du lieu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_nam_hoc='.$schoolyearid. ' ORDER BY tu_ngay ASC');

// Đổ dữ liệu
$namhocid;
while ($row = $query->fetch()) {
    $array[$row['ma_tuan']] = $row;
    $namhocid = $row['ma_nam_hoc'];
}

    $querynamhoc = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year WHERE ma_nam_hoc='.$namhocid);
    $datanamhoc = $querynamhoc->fetch();

// hien thi du lieu s
if($array) {
    
    foreach ($array as $value) {
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=editweek&schoolyearid='.$value['ma_nam_hoc'].'&weekid=' . $value['ma_tuan'];
        $value['nam_hoc'] = $datanamhoc['tu_nam'].' - '.$datanamhoc['den_nam'];
        $value['tu_ngay'] = nv_date('d/m/Y', $value['tu_ngay']);
        $value['den_ngay'] = nv_date('d/m/Y', $value['den_ngay']);
        $value['active'] = $value['trang_thai'] == 1 ? 'checked' : '';
        $value['icon'] = $value['mo_ta'] ? "edit" : "plus";
        $xtpl->assign('DATA', $value);
        $xtpl->parse('weeklist.loop');
    }
}

$xtpl->parse('weeklist');
$contents = $xtpl->text('weeklist');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';