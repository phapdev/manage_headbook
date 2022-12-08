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

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}


$studentid = $nv_Request->get_int('studentid', 'post,get');

$xtpl = new XTemplate('addstudent.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_UPLOADS_DIR', NV_UPLOADS_DIR);
$xtpl->assign('UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload . '/' . date("Y_m"));
$xtpl->assign('module_name', $module_name);

if ($studentid) {
    // chinh sua 
    $page_title = $lang_module['edit_student'];
    
    $querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_hoc_sinh = ' . $studentid);

    $student = $querystudent->fetch();

    $arrayclass=[];
    // Gọi csdl để lấy dữ liệu
    $queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class');


    // đổ dữ liệu
    $selectedclass = $student['ma_lop'];
    while ($row = $queryclass->fetch()) {
        $arrayclass[$row['ma_lop']] = $row;
    }

     // hien thi du lieu class drop down
     if(!empty($arrayclass)) { 
        foreach ($arrayclass as $value) {
            $value['key'] = $value['ma_lop'];
            $value['title'] = $value['ten_lop'];
            $value['selected'] = $selectedclass == $value['ma_lop'] ? "selected" : "";

            $xtpl->assign('DATA_CLASS', $value);
            $xtpl->parse('addstudent.loopclass');
        }
    }
     // hien thi du lieu sex drop down
    $selectedsex = $student['gioi_tinh'];
    for ($i = 0; $i <= 1; ++$i) {
        $value = [
            'key' => $i,
            'title' => $lang_module['sex' . $i],
            'selected' => $selectedsex == $lang_module['sex' . $i] ? ' selected="selected"' : ''
        ];
        $xtpl->assign('DATA_SEX', $value);
        $xtpl->parse('addstudent.loopsex');
    }

    //hien thi du lieu form con lai
    if($student) { 
        $student['ngay_sinh'] = nv_date('d/m/Y', $student['ngay_sinh']);
        $xtpl->assign('DATA', $student);
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['ho_ten'] = nv_substr($nv_Request->get_title('ho_ten', 'post', ''), 0, 250);
        // truy vấn mã giáo viên

        $ngay_sinh = $nv_Request->get_string('ngay_sinh', 'post', '');
        if (!empty($ngay_sinh) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngay_sinh))
        $ngay_sinh = "";
        if (empty($ngay_sinh)) {
            $row['ngay_sinh'] = 0;
        } else {
            $phour = date('H');
            $pmin = date('i');
            unset($m);
            preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngay_sinh, $m);
            $row['ngay_sinh'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
        }

        if(!empty($arrayclass)) { 

            foreach ($arrayclass as $value) {
                $row['ma_lop'] = $nv_Request->get_int('class_' . $value['ma_lop'], 'post', '');
            }
            for ($i = 0; $i <= 1; ++$i) {
                $row['gioi_tinh'] = nv_substr($nv_Request->get_title('sex_' . $i, 'post', ''), 0, 250);
            }
            $row['gioi_tinh'] = $lang_module['sex' . $row['gioi_tinh']];
        }

        $row['so_tiet_nghi'] = $nv_Request->get_int('so_tiet_nghi', 'post', '');
        $row['anh_dai_dien'] = nv_substr($nv_Request->get_title('anh_dai_dien', 'post', ''), 0, 250);
        $row['dia_chi'] = nv_substr($nv_Request->get_title('dia_chi', 'post', ''), 0, 250);

        //Xu ly luu du lieu  
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_student SET ho_ten=:ho_ten, ngay_sinh=:ngay_sinh
        , gioi_tinh=:gioi_tinh, ma_lop=:ma_lop, dia_chi=:dia_chi, so_tiet_nghi=:so_tiet_nghi, anh_dai_dien=:anh_dai_dien WHERE ma_hoc_sinh=' . $studentid;
        $sth = $db->prepare($_sql);
        $sth->bindParam(':ho_ten', $row['ho_ten'], PDO::PARAM_STR);
        $sth->bindParam(':ngay_sinh', $row['ngay_sinh'], PDO::PARAM_STR);
        $sth->bindParam(':gioi_tinh', $row['gioi_tinh'], PDO::PARAM_STR);
        $sth->bindParam(':ma_lop', $row['ma_lop'], PDO::PARAM_STR);
        $sth->bindParam(':dia_chi', $row['dia_chi'], PDO::PARAM_STR);
        $sth->bindParam(':so_tiet_nghi', $row['so_tiet_nghi'], PDO::PARAM_STR);
        $sth->bindParam(':anh_dai_dien', $row['anh_dai_dien'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=student&classid=' . $row['ma_lop']);
        }
    } 
} else {
    // them moi
    $page_title = $lang_module['add_student'];

    $arrayclass=[];
    // Gọi csdl để lấy dữ liệu
    $queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class');

    // đổ dữ liệu
    $i =0;
    $selectedclass;
    while ($row = $queryclass->fetch()) {
        $arrayclass[$row['ma_lop']] = $row;
        if($i ==0)
        {
            $selectedclass = $row['ma_lop'];
        }
        $i++;
    }

     // hien thi du lieu class drop down
     if(!empty($arrayclass)) { 
        foreach ($arrayclass as $value) {
            $value['key'] = $value['ma_lop'];
            $value['title'] = $value['ten_lop'];
            $value['selected'] = $selectedclass == $value['ma_lop'] ? "selected" : "";

            $xtpl->assign('DATA_CLASS', $value);
            $xtpl->parse('addstudent.loopclass');
        }
    }
     // hien thi du lieu sex drop down
    $selectedsex = $lang_module['sex0'];
    for ($i = 0; $i <= 1; ++$i) {
        $value = [
            'key' => $i,
            'title' => $lang_module['sex' . $i],
            'selected' => $selectedsex == $lang_module['sex' . $i] ? ' selected="selected"' : ''
        ];
        $xtpl->assign('DATA_SEX', $value);
        $xtpl->parse('addstudent.loopsex');
    }

    $row = [];
    if ($nv_Request->isset_request('btnsubmit', 'post')) {

        $row['ho_ten'] = nv_substr($nv_Request->get_title('ho_ten', 'post', ''), 0, 250);
        // truy vấn mã giáo viên

        $ngay_sinh = $nv_Request->get_string('ngay_sinh', 'post', '');
        if (!empty($ngay_sinh) and !preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngay_sinh))
        $ngay_sinh = "";
        if (empty($ngay_sinh)) {
            $row['ngay_sinh'] = 0;
        } else {
            $phour = date('H');
            $pmin = date('i');
            unset($m);
            preg_match("/^([0-9]{1,2})\\/([0-9]{1,2})\/([0-9]{4})$/", $ngay_sinh, $m);
            $row['ngay_sinh'] = mktime($phour, $pmin, 0, $m[2], $m[1], $m[3]);
        }

        if(!empty($arrayclass)) { 

            foreach ($arrayclass as $value) {
                $row['ma_lop'] = $nv_Request->get_int('class_' . $value['ma_lop'], 'post', '');
            }
            for ($i = 0; $i <= 1; ++$i) {
                $row['gioi_tinh'] = nv_substr($nv_Request->get_title('sex_' . $i, 'post', ''), 0, 250);
            }
            $row['gioi_tinh'] = $lang_module['sex' . $row['gioi_tinh']];
        }

        $row['so_tiet_nghi'] = $nv_Request->get_int('so_tiet_nghi', 'post', '');
        $row['anh_dai_dien'] = nv_substr($nv_Request->get_title('anh_dai_dien', 'post', ''), 0, 250);
        $row['dia_chi'] = nv_substr($nv_Request->get_title('dia_chi', 'post', ''), 0, 250);

        //Xu ly luu du lieu  
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_student (
            ho_ten, ngay_sinh, gioi_tinh, ma_lop, dia_chi, so_tiet_nghi, anh_dai_dien) VALUES (
            :ho_ten, :ngay_sinh, :gioi_tinh, :ma_lop, :dia_chi, :so_tiet_nghi, :anh_dai_dien)';
        $sth = $db->prepare($_sql);
        $sth->bindParam(':ho_ten', $row['ho_ten'], PDO::PARAM_STR);
        $sth->bindParam(':ngay_sinh', $row['ngay_sinh'], PDO::PARAM_STR);
        $sth->bindParam(':gioi_tinh', $row['gioi_tinh'], PDO::PARAM_STR);
        $sth->bindParam(':ma_lop', $row['ma_lop'], PDO::PARAM_STR);
        $sth->bindParam(':dia_chi', $row['dia_chi'], PDO::PARAM_STR);
        $sth->bindParam(':so_tiet_nghi', $row['so_tiet_nghi'], PDO::PARAM_STR);
        $sth->bindParam(':anh_dai_dien', $row['anh_dai_dien'], PDO::PARAM_STR);
        $exe = $sth->execute(); 
    
        if ($exe) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=student&classid=' . $row['ma_lop']);
        }
    } 

}


$xtpl->parse('addstudent');
$contents = $xtpl->text('addstudent');


include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
