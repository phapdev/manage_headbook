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

$page_title = $lang_module['subject'];
$page_addsubject = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addsubject';
$array = [];

// Gọi csdl để lấy dữ liệu
$querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject');

// Đổ dữ liệu
while ($row = $querysubject->fetch()) {
    $array[$row['ma_mon_hoc']] = $row;
}

$xtpl = new XTemplate('subject.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('PAGE_ADDSUBJECT', $page_addsubject);

// Hiển thị dữ liệu 
if($array) { 
    foreach ($array as $value) {
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addsubject&subjectid=' . $value['ma_mon_hoc'];
        $xtpl->assign('DATA', $value);
        $xtpl->parse('subject.loop');
    }
}

$xtpl->parse('subject');
$contents = $xtpl->text('subject');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';