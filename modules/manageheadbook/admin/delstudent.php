
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
$ma_hoc_sinh = $nv_Request->get_int('ma_hoc_sinh', 'post', 0);
$contents = '';

if ($ma_hoc_sinh > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_delstudent', "ma_hoc_sinh " . $ma_hoc_sinh, $admin_info['userid']);
    $sql ='DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_hoc_sinh =' . $ma_hoc_sinh;
    $success = $db->exec($sql);
    if ($success) {
        $contents = "OK_" . $ma_hoc_sinh;
    } else {
        $contents = "ERR_" . $lang_module['student_delete_unsuccess'];
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';