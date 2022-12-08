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

$subjectid = $nv_Request->get_int('subjectid', 'post,get');

$xtpl = new XTemplate('addsubject.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

if ($subjectid) {
    // chinh sua 
    $page_title = $lang_module['edit_subject'];
    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject WHERE ma_mon_hoc = ' . $subjectid);
    $subject = $querysubject->fetch();
    if($subject) { 
        $xtpl->assign('DATA', $subject);
    }
    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {
        $row['ten_mon_hoc'] = nv_substr($nv_Request->get_title('ten_mon_hoc', 'post', ''), 0, 250);
        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_subject SET ten_mon_hoc=:ten_mon_hoc WHERE ma_mon_hoc=' . $subjectid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':ten_mon_hoc', $row['ten_mon_hoc'], PDO::PARAM_STR);
        $exe = $sth->execute(); 

        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=subject');
        }
    } 
} else {
    // Thêm mới
    $page_title = $lang_module['add_subject'];
    $i = 0;
    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {
        $row['ten_mon_hoc'] = nv_substr($nv_Request->get_title('ten_mon_hoc', 'post', ''), 0, 250);
        //Xu ly luu du lieu  
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_subject (
            ten_mon_hoc) VALUES (:ten_mon_hoc)';
        $sth = $db->prepare($_sql);
        $sth->bindParam(':ten_mon_hoc', $row['ten_mon_hoc'], PDO::PARAM_STR);
        $exe = $sth->execute(); 

        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=subject');
        }
    } 

}

$xtpl->parse('addsubject');
$contents = $xtpl->text('addsubject');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';