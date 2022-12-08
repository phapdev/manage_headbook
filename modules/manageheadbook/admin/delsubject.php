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
$ma_mon_hoc = $nv_Request->get_int('ma_mon_hoc', 'post', 0);
$contents = '';

if ($ma_mon_hoc > 0) {
    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_delsubject', "ma_mon_hoc " . $ma_mon_hoc, $admin_info['userid']);
    $sql ='DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject WHERE ma_mon_hoc=' . $ma_mon_hoc;
    if ($db->exec($sql)) {
        $nv_Cache->delMod($module_name);
        $contents = "OK_" . $ma_mon_hoc;
    } else {
        $contents = "ERR_" . $lang_module['subject_delete_unsuccess'];
    }
}

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';