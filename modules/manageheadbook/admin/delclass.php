
<?php

/**
 * Headbook Management System
 * @version 4.x
 * @author Group DNTU
 * @license GNU/GPL version 3 
 * @see https://github.com/phapdev/manage_headbook.git The Manage headbook GitHub project
 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

if (! defined('NV_IS_AJAX')) {
    die('Wrong URL');
}

$checkss = $nv_Request->get_string('checkss', 'post');
$ma_lop = $nv_Request->get_int('ma_lop', 'post', 0);
$contents = '';

if ($ma_lop > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_delclass', "ma_lop " . $ma_lop, $admin_info['userid']);
    $sql ='DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class WHERE ma_lop=' . $ma_lop;
    if ($db->exec($sql)) {
        // $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_studentlist WHERE maLop=" . $ma_lop);
        $nv_Cache->delMod($module_name);

        $contents = "OK_" . $ma_lop;
    } else {
        $contents = "ERR_" . $lang_module['class_delete_unsuccess'];
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';