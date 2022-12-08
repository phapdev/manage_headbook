<?php

/**
 * Headbook Management System
 * @version 4.x
 * @author Group DNTU
 * @license GNU/GPL version 3 
 * @see https://github.com/phapdev/manage_headbook.git The Manage headbook GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['subject'];
$page_addsubject = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addsubject';

$arr_subject = [];
// Gọi csdl để lấy dữ liệu về
$query_subject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject ORDER BY ten_mon_hoc ASC');
// đổ dữ liệu 
while ($row = $query_subject->fetch()) {
    $arr_subject[$row['ma_mon_hoc']] = $row;
}


$xtpl = new XTemplate('subject.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

// hien thi du lieu 
if(!empty($arr_subject)) { 
    foreach ($arr_subject as $value) {
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addsubject&id=' . $value['ma_mon_hoc'];
        $value['checksess'] = md5($value['ma_mon_hoc'] . NV_CHECK_SESSION);
        $xtpl->assign('DATA_subject', $value);
        $xtpl->parse('subject.loop');
    }
}
$xtpl->assign('PAGE_ADDSUBJECT', $page_addsubject);

$xtpl->parse('subject');
$contents = $xtpl->text('subject');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';