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

$ma_nam_hoc_get = $nv_Request->get_int('manamhoc', 'post,get');
$ma_tuan_get = $nv_Request->get_int('matuan', 'post,get');
$ma_lop_get = $nv_Request->get_int('malop', 'post,get');
$ma_buoi_get = $nv_Request->get_int('mabuoi', 'post,get');



$page_title = $lang_module['manage_headbook'];

$xtpl = new XTemplate('headbook.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('MANAMHOC', $ma_nam_hoc_get);
$xtpl->assign('MATUAN', $ma_tuan_get);
$xtpl->assign('MALOP', $ma_lop_get);
$xtpl->assign('MABUOI', $ma_buoi_get);

$display_form = 'style="display: none"';
//nam hoc

if($nv_Request->isset_request("change_schoolyear","post,get")) {
    $manamhoc = $nv_Request->get_int('manamhoc','get',0);
    // Subject
    if ($manamhoc > 0) {
        $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_nam_hoc='.$manamhoc.' ORDER BY tu_ngay ASC');
        $html = '';
        while ($row = $queryweek->fetch()) {
            $html .= '<option value="' . $row['ma_tuan'] . '">' . $row['ten_tuan'].' ('.nv_date('d/m/Y', $row['tu_ngay']). ' - '.nv_date('d/m/Y', $row['den_ngay']).')' . '</option>';
        }
        die($html);
    } else {
        die("ERR");
    }
}

// năm học
$queryschoolyear = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year ORDER BY tu_nam ASC');

$selectedschoolyear=$ma_nam_hoc_get ? $ma_nam_hoc_get : 0;
$arrayschoolyear = [];
while ($row = $queryschoolyear->fetch()) {
    $arrayschoolyear[$row['ma_nam_hoc']] = $row;
}

// hien thi du lieu hocsinh
if(!empty($arrayschoolyear)) {
    foreach ($arrayschoolyear as $value) {
        $value['key'] = $value['ma_nam_hoc'];
        $value['title'] = $value['tu_nam'] . ' - ' . $value['den_nam'];
        $value['selected'] = $selectedschoolyear == $value['ma_nam_hoc'] ? "selected" : "";
        $xtpl->assign('DATA_SCHOOLYEAR', $value);
        $xtpl->parse('headbook.loopschoolyear');
    }
}

// lop 
$queryclass = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_class ORDER BY ten_lop ASC');

$selectedclass= $ma_lop_get ? $ma_lop_get : 0;
$arrayclass = [];
while ($row = $queryclass->fetch()) {
    $arrayclass[$row['ma_lop']] = $row;
}

// hien thi du lieu hocsinh
if(!empty($arrayclass)) {
    foreach ($arrayclass as $value) {
        $value['key'] = $value['ma_lop'];
        $value['title'] = $value['ten_lop'];
        $value['selected'] = $selectedclass == $value['ma_lop'] ? "selected" : "";
        $xtpl->assign('DATA_CLASS', $value);
        $xtpl->parse('headbook.loopclass');
    }
}

$selectedday = $ma_buoi_get ? $ma_buoi_get : 0;
$data=[];
for ($i=1; $i <=2 ; $i++) { 
    $data['key'] = $i;
    $data['title'] = $lang_module['daystatus'.$i];
    $data['selected'] = $selectedday == $i ? "selected" : "";
    $xtpl->assign('DATA_DAYSTUS', $data);
    $xtpl->parse('headbook.loopdaystatus');
}

// tuan
if($ma_tuan_get) {
    $queryweek = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_nam_hoc ='.$ma_nam_hoc_get .' ORDER BY tu_ngay ASC');
    // o day phai doi tim duoc hoc sinh nghi
    $selectedweek=$ma_tuan_get;
    $arrayweek = [];
    while ($row = $queryweek->fetch()) {
        $arrayweek[$row['ma_tuan']] = $row;
    }

    // hien thi du lieu hocsinh
    if(!empty($arrayweek)) {
        foreach ($arrayweek as $value) {
            $value['key'] = $value['ma_tuan'];
            $value['title'] = $value['ten_tuan'] .' ('.nv_date('d/m/Y', $value['tu_ngay']). ' - '.nv_date('d/m/Y', $value['den_ngay']).')';
            $value['selected'] = $selectedweek == $value['ma_tuan'] ? "selected" : "";
            
            $xtpl->assign('DATA_WEEK', $value);
            $xtpl->parse('headbook.loopweek');
        }
    }
}

$querytungay = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_week WHERE ma_nam_hoc ='.$ma_nam_hoc_get . ' AND ma_tuan='.$ma_tuan_get);

$datatungay = $querytungay->fetch();
$currenttime = $datatungay['tu_ngay'];
// cho nay lay trang thai tuan do



if($ma_nam_hoc_get > 0 && $ma_lop_get > 0 && $ma_buoi_get >0 && $ma_tuan_get >0) {
    if($datatungay['trang_thai'] == 1) {
        $xtpl->assign('DISPLAY_INFO', 'style="display:none"');
        $xtpl->assign('DISPLAY_FUNC_TITLE', '');
        $xtpl->assign('DISPLAY_FUNC', '');
    } else {
        $xtpl->assign('DISPLAY_INFO', '');
        $xtpl->assign('DISPLAY_FUNC_TITLE', 'display:none;');
        $xtpl->assign('DISPLAY_FUNC', 'style="display:none;"');
    }
    for ($i=2; $i <= 8; $i++){
        $array = [];
        // Gọi csdl để lấy dữ liệu
        $query = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_headbook WHERE ma_tuan=".$ma_tuan_get." AND ma_lop=".$ma_lop_get." AND ma_buoi=".$ma_buoi_get." AND thu LIKE 'Th%". $i ."' ORDER BY tiet ASC");
        // đổ dữ liệu 
        while ($row = $query->fetch()) {
            $array[$row['tiet']] = $row;
        }
    
        if ($array) {
            for ($j = 1; $j <= 5; $j++) {
                $value = $array[$j];
                $day = '';
                if ($j == 1) {
                    $day = '<td rowspan="5" align="center" style="vertical-align:middle; font-weight:600">'. $lang_module['day'.$i] .'<br />'.nv_date('d/m/Y',$currenttime).'</td>';
                }
                if ($value) {
                    $value['checksess'] = md5($value['ma_so'] . NV_CHECK_SESSION);
                    $value['edit_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&manamhoc='.$ma_nam_hoc_get.'&matuan=' . $ma_tuan_get . '&malop='.$ma_lop_get. '&mabuoi='.$ma_buoi_get. '&thu='.$i . '&tiet='.$value['tiet'] . '&id='.$value['ma_so'];
    
                    // lay ra mon hoc
                    $querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject WHERE ma_mon_hoc=' . $value['ma_mon']);
                    $datasubject = $querysubject->fetch();
                    $value['ten_mon_hoc'] = $datasubject['ten_mon_hoc'];
    
                    // chuyen thanh array
                    $arrabsent1 = explode(",", $value['co_phep']);
                    $arrabsent2 = explode(",", $value['khong_phep']);
                    $value['tenhocsinhnghi'] = '';
                    // lay ra may thang nghi
                    if ($arrabsent1[0]  != 0) {
                        $last_key1 = end(array_keys($arrabsent1));
                        foreach ($arrabsent1 as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_hoc_sinh=' . $mahocsinh);
                            $dataabsent = $queryabsent->fetch();
                            if ($key == $last_key1) {
                                $value['tenhocsinhnghi'] .= $dataabsent['ho_ten'] . ': CP';
                            } else {
                                $value['tenhocsinhnghi'] .= $dataabsent['ho_ten'] . ', ';
                            }
                        }
                    }
                    
                    if ($arrabsent2[0]  != '') {
                        if ($arrabsent1[0] != '')
                            $value['tenhocsinhnghi'] .= ', ';
                        $last_key2 = end(array_keys($arrabsent2));
                        foreach ($arrabsent2 as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $queryabsent = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_student WHERE ma_hoc_sinh=' . $mahocsinh);
                            $dataabsent = $queryabsent->fetch();
                            if ($key == $last_key2) {
                                $value['tenhocsinhnghi'] .= $dataabsent['ho_ten'] . ': K';
                            } else {
                                $value['tenhocsinhnghi'] .= $dataabsent['ho_ten'] . ', ';
                            }
                        }
                    }
                    
                    
                    // lay di may thang di hoc mon 

                    $arrlate = explode(",", $value['di_muon']);
                    $value['tenhocsinhdi_muon'] = '';
                    if($arrlate[0] != '') {
                        $last_key3 = end(array_keys($arrlate));
                        foreach ($arrlate as $key => $mahocsinh) {
                            // die('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $querylate = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_studentlist WHERE maHocSinh=' . $mahocsinh);
                            $datalate = $querylate->fetch();
                            if ($key == $last_key3) {
                                $value['tenhocsinhdi_muon'] .= $datalate['ho_ten'];
                            } else {
                                $value['tenhocsinhdi_muon'] .= $datalate['ho_ten'] . ', ';
                            }
                        }
                    }
    
                    
                    $xtpl->assign('DISPLAY_ADD', 'none');
                    $xtpl->assign('DISPLAY_EDIT', 'block');
    
                    $xtpl->assign('DISPLAY_ADD', 'none');
                    $xtpl->assign('DISPLAY_EDIT', 'block');
                    $xtpl->assign('DISPLAY_IMG', 'block');
                } else {
    
                    $value['add_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&ma_nam_hoc='.$ma_nam_hoc_get.'&ma_tuan='.$ma_tuan_get.'&ma_lop='.$ma_lop_get.'&ma_buoi='.$ma_buoi_get.'&thu='.$i . '&tiet='.$j;
                    $xtpl->assign('DISPLAY_ADD', 'block');
                    $xtpl->assign('DISPLAY_EDIT', 'none');
                    $xtpl->assign('DISPLAY_IMG', 'none');
                }
                $xtpl->assign('DATA', $value);
                $xtpl->assign('DAY', $day);
                $xtpl->assign('LESSON', $j);
                
                $xtpl->parse('headbook.loopday.looplesson');
            }

        } else {
            for ($j=1; $j <= 5; $j++) {
                $day = '';
                $value = [];
                if ($j== 1) {
                    $day = '<td rowspan="5" align="center" style="vertical-align:middle;font-weight:600">'. $lang_module['day'.$i] .'<br />'.nv_date('d/m/Y',$currenttime).'</td>';
                }
                $value['add_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addheadbook&ma_nam_hoc='.$ma_nam_hoc_get.'&ma_tuan='.$ma_tuan_get.'&ma_lop='.$ma_lop_get.'&ma_buoi='.$ma_buoi_get.'&thu='.$i . '&tiet='.$j;
    
                $xtpl->assign('DATA', $value);
                $xtpl->assign('DAY', $day);
                $xtpl->assign('LESSON', $j);
                $xtpl->assign('DISPLAY_ADD', 'block');
                $xtpl->assign('DISPLAY_IMG', 'none');
                $xtpl->assign('DISPLAY_EDIT', 'none');

                $xtpl->parse('headbook.loopday.looplesson');
            }
        }
        $xtpl->parse('headbook.loopday');
        $currenttime += 86400;
    }
    $display_form = '';
}
else {
    $xtpl->assign('DISPLAY_INFO', 'style="display:none"');
}

$xtpl->assign('DISPLAY_FORM', $display_form);

$xtpl->parse('headbook');
$contents = $xtpl->text('headbook');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
