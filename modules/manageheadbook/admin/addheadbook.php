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

$matuan = $nv_Request->get_int('matuan', 'post,get');
$manamhoc = $nv_Request->get_int('manamhoc', 'post,get');
$malop = $nv_Request->get_int('malop', 'post,get');
$mabuoi = $nv_Request->get_int('mabuoi', 'post,get');
$thu = $nv_Request->get_int('thu', 'post,get');
$tiet = $nv_Request->get_int('tiet', 'post,get');

$id = $nv_Request->get_int('id', 'post,get');

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
// xu ly chon ten bai hoc

if($nv_Request->isset_request("change_subject","post,get")) {
    $mamonhoc = $nv_Request->get_int('mamonhoc','get',0);
    $khoi = $nv_Request->get_int('khoi','get',0);
    // Subject
    if ($mamonhoc > 0 && $khoi > 0) {
        $queryppct = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_ppct WHERE ma_mon_hoc='.$mamonhoc.' AND khoi='.$khoi.' ORDER BY tiet ASC');
        $html = '<option value="0">Chọn tên bài học</option>';
        while ($row = $queryppct->fetch()) {
            $html .= '<option value="' . $row['id'] . '">' . $row['ten_bai_hoc'] . '</option>';
        }
        die($html);
    } else {
        die("ERR");
    }
}

if($nv_Request->isset_request("change_name_lesson","post,get")) {
    $mappct = $nv_Request->get_int('ma_ppct','get',0);
    // Subject
    if ($mappct > 0) {
        $queryppct = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_ppct WHERE id=' . $mappct);

        $data = $queryppct->fetch();
        die((string)($data['tiet']));
        
    } else {
        die("ERR");
    }
}

$xtpl = new XTemplate('addheadbook.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

// lay khoi ra 
$queryunit = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class WHERE ma_lop='.$malop);
$dataunit = $queryunit->fetch();

$khoi = $dataunit['khoi'];

$xtpl->assign('KHOI', $khoi);

if($id) {
    // sua form 
    $page_title = $lang_module['edit_headbook'];

    $queryheadbook = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_headbook WHERE ma_so=' . $id);
    $dataheadbook = $queryheadbook->fetch();

    $xtpl->assign('DATA', $dataheadbook);

    $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_tuan='.$matuan);
    $dataweek = $queryweek->fetch();

    $queryschoolyear = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year WHERE ma_nam_hoc='.$dataweek['ma_nam_hoc']);
    $dataschoolyear = $queryschoolyear->fetch();

    $queryclasslist = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class WHERE ma_lop ='.$malop);
    $dataclasslist = $queryclasslist->fetch();

    $info = [
        'tuan' => $dataweek['ten_tuan'],
        'namhoc' => $dataschoolyear['tu_nam'] . ' - ' . $dataschoolyear['den_nam'],
        'tungay' => nv_date('d/m/Y', $dataweek['tu_ngay']),
        'denngay' => nv_date('d/m/Y', $dataweek['den_ngay']),
        'tenlop' => $dataclasslist['ten_lop'],
        'buoi' => $mabuoi == 1 ?'sáng' : 'chiều',
        'thu' => $lang_module['day'.$thu],
        'tiet' => $tiet
    ];
    $xtpl->assign('INFO', $info);

    // Subject
    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject');
    // o day phai doi tim duoc mon hoc 

    $selectedsubject= $dataheadbook['ma_mon'];
    $arraysubject = [];
    while ($row = $querysubject->fetch()) {
        $arraysubject[$row['ma_mon_hoc']] = $row;
    }

    // hien thi du lieu subject drop down
    if(!empty($arraysubject)) {
        foreach ($arraysubject as $value) {
            $value['key'] = $value['ma_mon_hoc'];
            $value['title'] = $value['ten_mon_hoc'];
            $value['selected'] = $selectedsubject == $value['ma_mon_hoc'] ? "selected" : "";

            $xtpl->assign('DATA_SUBJECT', $value);
            $xtpl->parse('addheadbook.loopsubject');
        }
    }

    // hocsinh
    $querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_lop ='.$malop);
    // o day phai doi tim duoc hoc sinh nghi
    $arraystudent = [];
    while ($row = $querystudent->fetch()) {
        $arraystudent[$row['ma_hoc_sinh']] = $row;
    }
    
    $arrabsentper = explode(",", $dataheadbook['co_phep']);
    // hien thi du lieu hócinh vang phep
    if(!empty($arraystudent)) {
        foreach ($arraystudent as $value) {
            $value['key'] = $value['ma_hoc_sinh'];
            $value['title'] = $value['ho_ten'];
            $value['selected'] =  "";

            $last_key = end(array_keys($arrabsentper));
                foreach ($arrabsentper as $key => $mahocsinh) {
                    if ($mahocsinh == $value['ma_hoc_sinh']) {
                        $value['selected'] = "selected";
                    }
                }
            
            $xtpl->assign('DATA_STUDENT_ABSENT_PER', $value);
            $xtpl->parse('addheadbook.loopstudentabsentper');
        }
    }

    $arrabsentnoper = explode(",", $dataheadbook['khong_phep']);
    // hien thi du lieu hócinh vang phep
    if(!empty($arraystudent)) {
        foreach ($arraystudent as $value) {
            $value['key'] = $value['ma_hoc_sinh'];
            $value['title'] = $value['ho_ten'];
            $value['selected'] =  "";

            $last_key = end(array_keys($arrabsentnoper));
                foreach ($arrabsentnoper as $key => $mahocsinh) {
                    if ($mahocsinh == $value['ma_hoc_sinh']) {
                        $value['selected'] = "selected";
                    }
                }
            
            $xtpl->assign('DATA_STUDENT_ABSENT_NOPER', $value);
            $xtpl->parse('addheadbook.loopstudentabsentnoper');
        }
    }

    $arrlate = explode(",", $dataheadbook['di_muon']);
    // hien thi du lieu hócinh vang phep
    if(!empty($arraystudent)) {
        foreach ($arraystudent as $value) {
            $value['key'] = $value['ma_hoc_sinh'];
            $value['title'] = $value['ho_ten'];
            $value['selected'] =  "";

            $last_key = end(array_keys($arrlate));
                foreach ($arrlate as $key => $mahocsinh) {
                    if ($mahocsinh == $value['ma_hoc_sinh']) {
                        $value['selected'] = "selected";
                    }
                }
            
            $xtpl->assign('DATA_STUDENT_LATE', $value);
            $xtpl->parse('addheadbook.loopstudentlate');
        }
    }

     $querynamelesson = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_ppct WHERE ma_mon_hoc ='.$dataheadbook['ma_mon'] .' ORDER BY tiet ASC');
     $selectednamelesson=$dataheadbook['tiet_ppct'];
     $arraynamelesson = [];
     while ($row = $querynamelesson->fetch()) {
         $arraynamelesson[$row['tiet']] = $row;
     }
 
     // hien thi du lieu hócinh
     if(!empty($arraynamelesson)) {
         foreach ($arraynamelesson as $value) {
             $value['key'] = $value['tiet'];
             $value['title'] = $value['ten_bai_hoc'];
             $value['selected'] = $selectednamelesson == $value['tiet'] ? "selected" : "";
 
             $xtpl->assign('DATA_NAMELESSON', $value);
             $xtpl->parse('addheadbook.loopnamelesson');
         }
     }



} else {
    //them form
    $page_title = $lang_module['add_headbook'];

    $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_tuan='.$matuan);
    $dataweek = $queryweek->fetch();

    $queryschoolyear = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year WHERE ma_nam_hoc='.$dataweek['ma_nam_hoc']);
    $dataschoolyear = $queryschoolyear->fetch();

    $queryclasslist = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class WHERE ma_lop ='.$malop);
    $dataclasslist = $queryclasslist->fetch();

    $info = [
        'tuan' => $dataweek['ten_tuan'],
        'namhoc' => $dataschoolyear['tu_nam'] . ' - ' . $dataschoolyear['den_nam'],
        'tungay' => nv_date('d/m/Y', $dataweek['tu_ngay']),
        'denngay' => nv_date('d/m/Y', $dataweek['den_ngay']),
        'tenlop' => $dataclasslist['ten_lop'],
        'buoi' => $mabuoi == 1 ?'sáng' : 'chiều',
        'thu' => $lang_module['day'.$thu],
        'tiet' => $tiet
    ];

    $xtpl->assign('INFO', $info);

    
    // Subject
    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject');

    $selectedsubject=0;
    $arraysubject = [];
    while ($row = $querysubject->fetch()) {
        $arraysubject[$row['ma_mon_hoc']] = $row;
    }

    // hien thi du lieu subject drop down
    if(!empty($arraysubject)) {
        foreach ($arraysubject as $value) {
            $value['key'] = $value['ma_mon_hoc'];
            $value['title'] = $value['ten_mon_hoc'];
            $value['selected'] = $selectedsubject == $value['ma_mon_hoc'] ? "selected" : "";

            $xtpl->assign('DATA_SUBJECT', $value);
            $xtpl->parse('addheadbook.loopsubject');
        }
    }

    // hocsinh
    $querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_lop ='.$malop);

    $selectedstudent=0;
    $arraystudent = [];
    while ($row = $querystudent->fetch()) {
        $arraystudent[$row['ma_hoc_sinh']] = $row;
    }

    // hien thi du lieu hócinh phép
    if(!empty($arraystudent)) {
        foreach ($arraystudent as $value) {
            $value['key'] = $value['ma_hoc_sinh'];
            $value['title'] = $value['ho_ten'];
            $value['selected'] = $selectedstudent == $value['ma_hoc_sinh'] ? "selected" : "";

            $xtpl->assign('DATA_STUDENT_ABSENT_PER', $value);
            $xtpl->parse('addheadbook.loopstudentabsentper');
        }
    }

    // hien thi du lieu hócinh không phép
    if(!empty($arraystudent)) {
        foreach ($arraystudent as $value) {
            $value['key'] = $value['ma_hoc_sinh'];
            $value['title'] = $value['ho_ten'];
            $value['selected'] = $selectedstudent == $value['ma_hoc_sinh'] ? "selected" : "";

            $xtpl->assign('DATA_STUDENT_ABSENT_NOPER', $value);
            $xtpl->parse('addheadbook.loopstudentabsentnoper');
        }
    }

    // hien thi du lieu hócinh muộn
    if(!empty($arraystudent)) {
        foreach ($arraystudent as $value) {
            $value['key'] = $value['ma_hoc_sinh'];
            $value['title'] = $value['ho_ten'];
            $value['selected'] = $selectedstudent == $value['ma_hoc_sinh'] ? "selected" : "";

            $xtpl->assign('DATA_STUDENT_LATE', $value);
            $xtpl->parse('addheadbook.loopstudentlate');
        }
    }
}

$row = [];
if ($nv_Request->isset_request('btnsubmit', 'post')) {
    $row['matuan'] = $matuan;
    $row['malop'] = $malop;
    $row['mabuoi'] = $mabuoi;
    $row['thu'] = $lang_module['day'.$thu] ;
    $row['tiet'] = $tiet;
    $row['mamon'] = $nv_Request->get_int('mamon', 'post', '');

    $row['cophep'] = '';
    $last_key = end(array_keys($_POST['cophep']));
    foreach ($_POST['cophep'] as $key => $value) {
        if ($key == $last_key) {
            $row['cophep'] .= $value . '';
        } else {
            $row['cophep'] .= $value . ', ';
        }
        // dong thoi update lai sotiet nghi cua hoc sinh
        // moi dau la phai lay ve dc so tiet nghi 
        $querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_hoc_sinh=' . $value);
        $datastudent = $querystudent->fetch();

        $sotietnghi = $datastudent['so_tiet_nghi'] + 0.5;
        

        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_student
        SET so_tiet_nghi = '.$sotietnghi.' WHERE ma_hoc_sinh=' . $value;
        $sth = $db->prepare($_sql);
        $exe = $sth->execute();
    }

    $row['khongphep'] = '';
    $last_key = end(array_keys($_POST['khongphep']));
    foreach ($_POST['khongphep'] as $key => $value) {
        if ($key == $last_key) {
            $row['khongphep'] .= $value . '';
        } else {
            $row['khongphep'] .= $value . ', ';
        }
        // dong thoi update lai sotiet nghi cua hoc sinh
        // moi dau la phai lay ve dc so tiet nghi 
        $querystudent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_hoc_sinh=' . $value);
        $datastudent = $querystudent->fetch();

        $sotietnghi = $datastudent['so_tiet_nghi'] + 1;
        

        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_student
        SET so_tiet_nghi = '.$sotietnghi.' WHERE ma_hoc_sinh=' . $value;
        $sth = $db->prepare($_sql);
        $exe = $sth->execute();
    }

    $row['dimuon'] = '';
    $last_key = end(array_keys($_POST['dimuon']));
    foreach ($_POST['dimuon'] as $key => $value) {
        if ($key == $last_key) {
            $row['dimuon'] .= $value . '';
        } else {
            $row['dimuon'] .= $value . ', ';
        }
    }
    
    $row['tenbaihoc'] = nv_substr($nv_Request->get_int('tenbaihoc', 'post', ''), 0, 250);
    // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_ppct WHERE id=' . $row['tenbaihoc']);
    $queryppct = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_ppct WHERE ma_ppctr=' . $row['tenbaihoc']);

    $datappct = $queryppct->fetch();

    $row['tenbaihoc'] = $datappct['tenbaihoc'];
    $row['tietppct'] = $datappct['tiet'];
    
    $row['nhanxet'] = nv_substr($nv_Request->get_title('nhanxet', 'post', ''), 0, 250);
    $row['diemhoctap'] = $nv_Request->get_float('diemhoctap', 'post', '');
    $row['diemkyluat'] = $nv_Request->get_float('diemkyluat', 'post', '');
    $row['diemvesinh'] = $nv_Request->get_float('diemvesinh', 'post', '');

    $row['tongdiem'] = round(($row['diemhoctap'] + $row['diemkyluat'] + $row['diemvesinh']) / 3.0, 2);;
    $row['giaovienbmkiten'] = nv_substr($nv_Request->get_title('giaovienbmkiten', 'post', ''), 0, 250);
    $fromdate = $dataweek['tu_ngay'];
    for ($i=1; $i <=7; $i++) {
        if (date('w',$fromdate) == $thu-1) {
            $row['ngay'] = $fromdate;
        }
        $fromdate += 86400;
    }
    $_sql;
    //Xu ly luu du lieu 
    if ($id) {
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_headbook SET
            ma_tuan=:matuan, ma_lop=:malop, ma_buoi=:mabuoi, thu=:thu, tiet=:tiet, 
            ma_mon=:mamon, tiet_ppct=:tietppct, co_phep=:cophep, khong_phep=:khongphep, di_muon=:dimuon, ten_bai_hoc=:tenbaihoc, 
            nhan_xet=:nhanxet, hoc_tap=:diemhoctap, ky_luat=:diemkyluat, ve_sinh=:diemvesinh, 
            tong_diem=:tongdiem, ki_ten=:kiten, ngay=:ngay WHERE ma_so ='.$id;
    } else {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_headbook (
            matuan, malop, mabuoi, thu, tiet, mamon, tietppct, dimuon, cophep, khongphep, tenbaihoc, nhanxet, diemhoctap, diemkyluat, diemvesinh, tongdiem, giaovienbmkiten, ngay) VALUES (
            :matuan, :malop, :mabuoi, :thu, :tiet, :mamon, :tietppct, :dimuon, :cophep, :khongphep, :tenbaihoc, :nhanxet, :diemhoctap, :diemkyluat, :diemvesinh, :tongdiem, :giaovienbmkiten, :ngay)';
    }

    $sth = $db->prepare($_sql);
    $sth->bindParam(':matuan', $row['matuan'], PDO::PARAM_STR);
    $sth->bindParam(':malop', $row['malop'], PDO::PARAM_STR);
    $sth->bindParam(':mabuoi', $row['mabuoi'], PDO::PARAM_STR);
    $sth->bindParam(':thu', $row['thu'], PDO::PARAM_STR);
    $sth->bindParam(':tiet', $row['tiet'], PDO::PARAM_STR);
    $sth->bindParam(':mamon', $row['mamon'], PDO::PARAM_STR);
    $sth->bindParam(':tietppct', $row['tietppct'], PDO::PARAM_STR);
    $sth->bindParam(':dimuon', $row['dimuon'], PDO::PARAM_STR);
    $sth->bindParam(':cophep', $row['cophep'], PDO::PARAM_STR);
    $sth->bindParam(':khongphep', $row['khongphep'] , PDO::PARAM_STR);
    $sth->bindParam(':tenbaihoc', $row['tenbaihoc'], PDO::PARAM_STR);
    $sth->bindParam(':nhanxet', $row['nhanxet'], PDO::PARAM_STR);
    $sth->bindParam(':diemhoctap', $row['diemhoctap'], PDO::PARAM_STR);
    $sth->bindParam(':diemkyluat', $row['diemkyluat'], PDO::PARAM_STR);
    $sth->bindParam(':diemvesinh', $row['diemvesinh'], PDO::PARAM_STR);
    $sth->bindParam(':tongdiem', $row['tongdiem'], PDO::PARAM_STR);
    $sth->bindParam(':giaovienbmkiten', $row['giaovienbmkiten'], PDO::PARAM_STR);
    $sth->bindParam(':ngay', $row['ngay'], PDO::PARAM_STR);
    $exe = $sth->execute(); 

    if ($exe) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=headbook&manamhoc='.$manamhoc.'&matuan='.$matuan.'&malop='.$malop.'&mabuoi='.$mabuoi);
    }
} 

$xtpl->parse('addheadbook');
$contents = $xtpl->text('addheadbook');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
