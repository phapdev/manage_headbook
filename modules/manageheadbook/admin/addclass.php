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

$classid = $nv_Request->get_int('id', 'post,get');

$xtpl = new XTemplate('addclass.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
// day la chinh sua form
if ($classid) {
    $page_title = $lang_module['edit_class'];
    $arrayteacher=[];
    $queryteacher = $db->query('SELECT * FROM nv4_users WHERE group_id = 2 ORDER BY last_name ASC');

    while ($row = $queryteacher->fetch()) {
        $arrayteacher[$row['userid']] = $row;
    }

    
    $queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class WHERE ma_lop = ' . $classid);

    $class = $queryclass->fetch();

    $selected = $class['ma_gvcn'];

    if ($class) {
        $xtpl->assign('CLASS', $class);
    }
    if(!empty($arrayteacher)) { 
        foreach ($arrayteacher as $value) {
            $value['key'] = $value['userid'];
            $value['title'] = $value['last_name'] . ' ' . $value['first_name'];
            $value['selected'] = $selected == $value['userid'] ? "selected" : "";

            $xtpl->assign('DATA', $value);
            $xtpl->parse('addclass.loop');
        }
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['ten_lop'] = nv_substr($nv_Request->get_title('ten_lop', 'post', ''), 0, 250);
        // truy vấn mã giáo viên
        $row['ma_gvcn'] = $nv_Request->get_int('ma_gvcn', 'post', '');
        $row['khoi'] = $nv_Request->get_int('khoi', 'post', '');

        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_class 
        SET ten_lop = :ten_lop, ma_gvcn = :ma_gvcn, khoi = :khoi WHERE ma_lop = '. $classid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':ten_lop', $row['ten_lop'], PDO::PARAM_STR);
        $sth->bindParam(':ma_gvcn', $row['ma_gvcn'], PDO::PARAM_STR);
        $sth->bindParam(':khoi', $row['khoi'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=class');
        }
    }


}
//day la add form moi
else {
    $page_title = $lang_module['addclass'];
    $array=[];
    // Gọi csdl để lấy dữ liệu
    $queryteacher = $db->query('SELECT * FROM nv4_users WHERE group_id = 2 ORDER BY last_name ASC');
    // đổ dữ liệu
    $selected = 0;
    while ($row = $queryteacher->fetch()) {
        $array[$row['userid']] = $row;
    }

     // hien thi du lieu 
     if(!empty($array)) { 
        foreach ($array as $value) {
            $value['key'] = $value['userid'];
            $value['title'] = $value['last_name'] . ' ' . $value['first_name'];

            $xtpl->assign('DATA', $value);
            $xtpl->parse('addclass.loop');
        }
    }
}

$row = [];
if ($nv_Request->isset_request('btnsubmit', 'post')) {

    $row['ten_lop'] = nv_substr($nv_Request->get_title('ten_lop', 'post', ''), 0, 250);
    // truy vấn mã giáo viên
    $row['ma_gvcn'] = $nv_Request->get_int('ma_gvcn', 'post', '');
    $row['khoi'] = $nv_Request->get_int('khoi', 'post', '');
    //Xu ly luu du lieu  
    $sql;
    if ($classid) {
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_class 
            SET ten_lop = :ten_lop, ma_gvcn = :ma_gvcn, khoi = :khoi WHERE ma_lop = ' . $classid;
    } else {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_class (
            ten_lop, ma_gvcn, khoi) VALUES (:ten_lop, :ma_gvcn, :khoi)';
    }
    $sth = $db->prepare($_sql);
    $sth->bindParam(':ten_lop', $row['ten_lop'], PDO::PARAM_STR);
    $sth->bindParam(':ma_gvcn', $row['ma_gvcn'], PDO::PARAM_STR);
    $sth->bindParam(':khoi', $row['khoi'], PDO::PARAM_STR);
    $exe = $sth->execute();

    if ($exe) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=class');
    }
} 


$xtpl->parse('addclass');
$contents = $xtpl->text('addclass');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
