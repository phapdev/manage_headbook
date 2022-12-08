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

$page_title = $lang_module['school_info'];


// Gọi csdl để lấy dữ liệu
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_info');
$data = $query->fetch();

$xtpl = new XTemplate('school_info.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$row = [];

if ($nv_Request->isset_request('btnsubmit', 'post')) {
    $row['ten_so'] = nv_substr($nv_Request->get_title('ten_so', 'post', ''), 0, 250);
    $row['ten_phong'] = nv_substr($nv_Request->get_title('ten_phong', 'post', ''), 0, 250);
    $row['ten_truong'] = nv_substr($nv_Request->get_title('ten_truong', 'post', ''), 0, 250);
    $row['tu_nam'] = $nv_Request->get_int('tu_nam', 'post', '');
    $row['den_nam'] = $nv_Request->get_int('den_nam', 'post', '');

  if (!$data) {
    //them moi
    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_school_info (
        ten_so, ten_phong, ten_truong, tu_nam, den_nam) VALUES (
        :ten_so, :ten_phong, :ten_truong, :tu_nam, :den_nam)';

    $sth = $db->prepare($_sql);
    $sth->bindParam(':ten_so', $row['ten_so'], PDO::PARAM_STR);
    $sth->bindParam(':ten_phong', $row['ten_phong'], PDO::PARAM_STR);
    $sth->bindParam(':ten_truong', $row['ten_truong'], PDO::PARAM_STR);
    $sth->bindParam(':tu_nam', $row['tu_nam'], PDO::PARAM_STR);
    $sth->bindParam(':den_nam', $row['den_nam'], PDO::PARAM_STR);
    $exe = $sth->execute();

    if ($exe) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
  } else {
    $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_school_info 
    SET ten_so = :ten_so, ten_phong = :ten_phong, ten_truong = :ten_truong, tu_nam = :tu_nam, den_nam = :den_nam
    WHERE id = '. $data['id'];

    // die($_sql);
    $sth = $db->prepare($_sql);
    $sth->bindParam(':ten_so', $row['ten_so'], PDO::PARAM_STR);
    $sth->bindParam(':ten_phong', $row['ten_phong'], PDO::PARAM_STR);
    $sth->bindParam(':ten_truong', $row['ten_truong'], PDO::PARAM_STR);
    $sth->bindParam(':tu_nam', $row['tu_nam'], PDO::PARAM_STR);
    $sth->bindParam(':den_nam', $row['den_nam'], PDO::PARAM_STR);
    $exe = $sth->execute();

    if ($exe) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
  }
  
}
if($data){
    $xtpl->assign('DATA', $data);
}


$xtpl->parse('school_info');
$contents = $xtpl->text('school_info');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
