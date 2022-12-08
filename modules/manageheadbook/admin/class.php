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

$page_title = $lang_module['class'];
$page_addclass = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addclass';

$arr_class = [];
// Gọi csdl để lấy dữ liệu về
$query_class = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class ORDER BY ten_lop ASC');
// đổ dữ liệu 
while ($row = $query_class->fetch()) {
    $arr_class[$row['ma_lop']] = $row;
}


$xtpl = new XTemplate('class.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

// hien thi du lieu 
if(!empty($arr_class)) { 
    foreach ($arr_class as $value) {
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addclass&id=' . $value['ma_lop'];
        $value['url_studentlist'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE .'=studentlist&classlistid=' . $value['ma_lop'] ;
        $value['checksess'] = md5($value['ma_lop'] . NV_CHECK_SESSION);

        // gọi đến csdl để lấy tên giáo viên
        $queryteacher = $db->query('SELECT * FROM nv4_users WHERE userid = ' . $value['ma_gvcn'] );
        $rowteacher = $queryteacher->fetch();

        $value['ten_gvcn'] = $rowteacher['last_name'] . ' ' . $rowteacher['first_name'];
        
        $xtpl->assign('DATA_CLASS', $value);
        $xtpl->parse('class.loop');
    }
}
$xtpl->assign('PAGE_ADDCLASS', $page_addclass);

$xtpl->parse('class');
$contents = $xtpl->text('class');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
