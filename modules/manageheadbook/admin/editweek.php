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
$page_title = $lang_module['edit_week'];

//lay id post
$weekid = $nv_Request->get_int('weekid', 'post,get');
$schoolyearid = $nv_Request->get_int('schoolyearid', 'post,get');

$xtpl = new XTemplate('editweek.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

if ($weekid) {
    // chinh sua 
    $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_tuan = ' . $weekid);
    $week = $queryweek->fetch();
    if($week) { 
        $xtpl->assign('DATA', $week);
    }
    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {
        $row['mo_ta'] = nv_substr($nv_Request->get_title('mo_ta', 'post', ''), 0, 250);
        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_week SET mo_ta=:mo_ta WHERE ma_tuan=' . $weekid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':mo_ta', $row['mo_ta'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=weeklist&schoolyearid='.$schoolyearid);
        }
    } 
}


$xtpl->parse('editweek');
$contents = $xtpl->text('editweek');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';