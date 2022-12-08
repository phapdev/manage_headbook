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

$page_title = $lang_module['student_list'];

$classid = $nv_Request->get_int('classid', 'post,get');

$page_addstudent = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addstudent';
$array = [];

// Gọi csdl để lấy dữ liệu
$querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_lop = '. $classid .' ORDER BY ho_ten ASC');
// đổ dữ liệu
while ($row = $querystudent->fetch()) {
    $array[$row['ma_hoc_sinh']] = $row;
}

$queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class WHERE ma_lop = ' . $classid);
$dataclass = $queryclass->fetch();

$xtpl = new XTemplate('student.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('PAGE_ADDSTUDENT', $page_addstudent);


// hien thi du lieu 
if(!empty($array)) { 
    $i = 1;
    foreach ($array as $value) {
        $value['checksess'] = md5($value['ma_hoc_sinh'] . NV_CHECK_SESSION);
        $value['stt'] = $i++;
        $value['ten_lop'] = $dataclass['ten_lop'];
        $value['ngay_sinh'] = nv_date('d/m/Y', $value['ngay_sinh']);
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addstudent&studentid=' . $value['ma_hoc_sinh'];
        $xtpl->assign('DATA_STUDENT', $value);
        $xtpl->parse('student.loop');
    }
}


$xtpl->parse('student');
$contents = $xtpl->text('student');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';