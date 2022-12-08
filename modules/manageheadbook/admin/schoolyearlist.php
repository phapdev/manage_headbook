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

$page_title = $lang_module['school_year_list'];
$page_addschoolyear = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=addyear';
$page_studentlist = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=studentlist';
$array = [];

    //get data
    $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year ORDER BY thoi_gian_bat_dau ASC');

    while ($row = $query->fetch()) {
        $array[$row['ma_nam_hoc']] = $row;
    }

    $xtpl = new XTemplate('schoolyearlist.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('PAGE_ADDSCHOOLYEAR', $page_addschoolyear);
    $xtpl->assign('PAGE_STUDENTLIST', $page_studentlist);

    // hien thi du lieu 
    if(!empty($array)) { 
        foreach ($array as $value) {
            $value['url_week_list'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE .'=weeklist&id=' . $value['ma_nam_hoc'] ;
            $value['checksess'] = md5($value['ma_nam_hoc'] . NV_CHECK_SESSION);
            $value['thoi_gian_bat_dau'] = nv_date('d/m/Y', $value['thoi_gian_bat_dau']);
            $value['thoi_gian_ket_thuc'] = nv_date('d/m/Y', $value['thoi_gian_ket_thuc']);
            $value['nam_hoc'] = $value['tu_nam'] . ' - ' .  $value['den_nam'] ;
            $xtpl->assign('DATA', $value);
            $xtpl->parse('schoolyearlist.loop');
        }
    }

    $xtpl->parse('schoolyearlist');
    $contents = $xtpl->text('schoolyearlist');

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';