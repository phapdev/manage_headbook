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


// them nam hoc moi
$page_title = $lang_module['add_year_title'];
$row = [];

if ($nv_Request->isset_request('btnsubmit', 'post')) {

    $thoi_gian_bat_dau = $nv_Request->get_string('thoi_gian_bat_dau', 'post', '');
    if (!empty($thoi_gian_bat_dau) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoi_gian_bat_dau))
    $thoi_gian_bat_dau = "";
    if (empty($thoi_gian_bat_dau)) {
        $row['thoi_gian_bat_dau'] = 0;
    } else {
        $phour = date('H');
        $pmin = date('i');
        unset($m);
        preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoi_gian_bat_dau, $m);
        $row['thoi_gian_bat_dau'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
    }

    $thoi_gian_ket_thuc = $nv_Request->get_string('thoi_gian_ket_thuc', 'post', '');
    if (!empty($thoi_gian_ket_thuc) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoi_gian_ket_thuc))
    $thoi_gian_ket_thuc = "";
    if (empty($thoi_gian_ket_thuc)) {
        $row['thoi_gian_ket_thuc'] = 0;
    } else {
        $phour = date('H');
        $pmin = date('i');
        unset($m);
        preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $thoi_gian_ket_thuc, $m);
        $row['thoi_gian_ket_thuc'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
    }

    $row['tu_nam'] = $nv_Request->get_int('tu_nam', 'post', '');
    $row['den_nam'] = $nv_Request->get_int('den_nam', 'post', '');

    //Xu ly luu du lieu  
    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_school_year (
        tu_nam, den_nam, thoi_gian_bat_dau, thoi_gian_ket_thuc) VALUES (
        :tu_nam, :den_nam, :thoi_gian_bat_dau, :thoi_gian_ket_thuc)';
    $sth = $db->prepare($_sql);
    $sth->bindParam(':tu_nam', $row['tu_nam'], PDO::PARAM_STR);
    $sth->bindParam(':den_nam', $row['den_nam'], PDO::PARAM_STR);
    $sth->bindParam(':thoi_gian_bat_dau', $row['thoi_gian_bat_dau'], PDO::PARAM_STR);
    $sth->bindParam(':thoi_gian_ket_thuc', $row['thoi_gian_ket_thuc'], PDO::PARAM_STR);
    $sth->execute(); 

    // tiep tuc goi thang moi them vao de lay id
    $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year WHERE tu_nam='. $row['tu_nam'] .' AND den_nam=' . $row['den_nam'].' AND thoi_gian_bat_dau=' . $row['thoi_gian_bat_dau'] .' AND thoi_gian_ket_thuc=' . $row['thoi_gian_ket_thuc']);

    // đổ dữ liệu
    $data_school_year = $query->fetch();
    

    $time_per_week = 86400 * 7;
    $time_per_1day = 86400;

    $time_from_day = $row['thoi_gian_bat_dau'] ;
    $time_to_day = $row['thoi_gian_ket_thuc'];

    $sum_time = 0;

    if (date('w',$time_from_day) != 1) {
        for($i = 0; date('w',$time_from_day) != 1; ++$i) {
            $time_from_day -=  $time_per_1day;
        }
    }
    
    $_sqlweek = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_week (ma_nam_hoc, tu_ngay, den_ngay, ten_tuan) VALUES";
    for ($i = 0; $sum_time <= $time_to_day; $i++) {
        $sum_time = $time_from_day + $i * $time_per_week + $time_per_week - $time_per_1day;
        $tu_ngay = $time_from_day + $i * $time_per_week;
        $den_ngay = $time_from_day + $i * $time_per_week + $time_per_week - $time_per_1day;
        $ten_tuan ='Tuần ' . ($i+1);
        if ($sum_time > $time_to_day) 
            $_sqlweek = $_sqlweek . " (". $data_school_year['ma_nam_hoc'].", ".$tu_ngay.", ".$den_ngay.", '".$ten_tuan."');";
        else 
            $_sqlweek = $_sqlweek . " (". $data_school_year['ma_nam_hoc'].", ".$tu_ngay.", ".$den_ngay.", '".$ten_tuan."'),";
    }
    // die($_sqlweek);
    $db->query($_sqlweek);
        

    if ($db) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=schoolyearlist');
    }
}

$xtpl = new XTemplate('addyear.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);




$xtpl->parse('addyear');
$contents = $xtpl->text('addyear');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';