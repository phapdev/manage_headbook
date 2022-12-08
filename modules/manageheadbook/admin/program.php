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

include dirname(__FILE__) . '/../plugins/PHPExcel/Classes/PHPExcel/IOFactory.php';

$page_title = $lang_module['program'];
$error = '';
$success = '';

$action = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

// Hiển thị
$xtpl = new XTemplate('program.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('FORM_ACTION', $action);

// Subject
$querysubject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject');
$i = 0;
$selectedsubject;
while ($row = $querysubject->fetch()) {
	$arraysubject[$row['ma_mon_hoc']] = $row;
	if($i ==0)
	{
		$selectedsubject = $row['ma_mon_hoc'];
	}
	$i++;
}
// hien thi du lieu subject drop down
if(!empty($arraysubject)) { 
	foreach ($arraysubject as $value) {
		$value['key'] = $value['ma_mon_hoc'];
		$value['title'] = $value['ten_mon_hoc'];
		$value['selected'] = $selectedsubject == $value['ma_mon_hoc'] ? "selected" : "";

		$xtpl->assign('DATA_SUBJECT', $value);
		$xtpl->parse('main.loopsubject');
	}
}

$queryschool_year = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_school_year');
$i = 0;
$selectedschool_year;
while ($row = $queryschool_year->fetch()) {
	$arrayschool_year[$row['ma_nam_hoc']] = $row;
	if($i ==0)
	{
		$selectedschool_year = $row['ma_nam_hoc'];
	}
	$i++;
}

if(!empty($arrayschool_year)) { 
	foreach ($arrayschool_year as $value) {
		$value['key'] = $value['ma_nam_hoc'];
		$value['title'] = $value['tu_nam'] . ' - ' . $value['den_nam'];
		$value['selected'] = $selectedschool_year == $value['ma_nam_hoc'] ? "selected" : "";
		$xtpl->assign('DATA_SCHOOL_YEAR', $value);
		$xtpl->parse('main.loopschool_year');
	}
}

$selectedgrade = $lang_module['grade'];
for ($i = 1; $i <= 12; ++$i) {
	$value = [
		'key' => $i,
		'title' => $lang_module['grade' . $i],
		'selected' => $selectedgrade == $lang_module['grade' . $i] ? ' selected="selected"' : ''
	];
	$xtpl->assign('DATA_GRADE', $value);
	$xtpl->parse('main.loopgrade');
}

for ($i = 1; $i <= 12; ++$i) {
	$grade = nv_substr($nv_Request->get_title('grade_' . $i, 'post', ''), 0, 250);
}
$grade = $lang_module['grade' . $grade];

if(!empty($arraysubject)) { 
	foreach ($arraysubject as $value) {
		$ma_mon_hoc = $nv_Request->get_int('subject_' . $value['ma_mon_hoc'], 'post', '');
	}
}	

if(!empty($arrayschool_year)) { 
	foreach ($arrayschool_year as $value) {
		$ma_nam_hoc = $nv_Request->get_int('school_year_' . $value['ma_nam_hoc'], 'post', '');
	}
}	

// Khi nhấn Import
if ($nv_Request->isset_request('do', 'post')) {
	if (isset($_FILES['ufile']) && is_uploaded_file($_FILES['ufile']['tmp_name'])) {
		$filename = nv_string_to_filename($_FILES['ufile']['name']);
        $file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $filename;
        if(file_exists($file)){
            unlink($file);
        }
        if (move_uploaded_file($_FILES['ufile']['tmp_name'], $file)) {
			if (file_exists($file)) {
	            try {
	                $fileType = PHPExcel_IOFactory::ma_chuong_trinhentify($file);
	                $objReader = PHPExcel_IOFactory::createReader($fileType);
	                $objPHPExcel = $objReader->load($file);
	            } catch(Exception $e) {
	                $error = $lang_module['error_cannot_read_file'].' '.pathinfo($file,PATHINFO_BASENAME).'": '.$e->getMessage();
	            }

	            if (empty($error)) {
	            	$sheet = $objPHPExcel->getSheet(0); 
		            $highestRow = $sheet->getHighestRow();
		            $highestColumn = $sheet->getHighestColumn();
					
					for ($row = 1; $row <= $highestRow; $row++){
		            	$dataRow = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
						$data[] = $dataRow;
		            }	
							
		            // Bắt đầu import vào database		
					$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program WHERE ma_mon_hoc = ' . $ma_mon_hoc . ' AND ma_nam_hoc = ' . $ma_nam_hoc . ' AND grade = ' . $grade);	
					for($i = 1; $i <= $highestRow - 1; $i++) {
						$tiet = $data[$i][0][0];
						$lesson = $data[$i][0][1];	
						$_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_program
							(ma_nam_hoc, grade, ma_mon_hoc, tiet, lesson) VALUES
							(:ma_nam_hoc, :grade, :ma_mon_hoc, :tiet, :lesson)';						
						$sth = $db->prepare($_sql);
						$sth->bindParam(':ma_nam_hoc', $ma_nam_hoc, PDO::PARAM_INT);
						$sth->bindParam(':grade', $grade, PDO::PARAM_INT);
						$sth->bindParam(':ma_mon_hoc', $ma_mon_hoc, PDO::PARAM_INT);
						$sth->bindParam(':tiet', $tiet, PDO::PARAM_INT);
						$sth->bindParam(':lesson', $lesson, PDO::PARAM_INT);
						$sth->execute();
						// die($sth);
					}	
					$success = $lang_module['import_success'];
					unlink($file);
	            }
	        } else {
	        	$error = $lang_module['error_upload_file'];
	        }
		} else {
        	$error = $lang_module['error_upload_file'];
        }
	} else {
		$error = $lang_module['error_dont_have_file'];
	}
}

// Xem tất cả
if ($nv_Request->isset_request('showall', 'post')) {		
	// Gọi csdl để lấy dữ liệu
	$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program');
	// Đổ dữ liệu
	while ($row = $query->fetch()) {
		$array[$row['ma_chuong_trinh']] = $row;
	}
	// hien thi du lieu 
	if($array) { 
		$i = 1;
		foreach ($array as $value) {
			$value['stt'] = $i++;
			$query_selected_subject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject WHERE ma_mon_hoc = ' . $value['ma_mon_hoc'] );
			$row_selected_subject = $query_selected_subject->fetch();
			$value['mon_hoc'] = $row_selected_subject['ten_mon_hoc'];

			$query_school_year = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_school_year WHERE ma_nam_hoc=". $value['ma_nam_hoc']);              
			$data_school_year = $query_school_year->fetch();
			$value['nam_hoc'] = $data_school_year['tu_nam'] . ' - ' . $data_school_year['den_nam'];

			$xtpl->assign('DATA', $value);
			$xtpl->parse('main.show.loop');
		}
	}
	$xtpl->parse('main.show');
}

// Khi nhấn Xem
if ($nv_Request->isset_request('show', 'post')) {
	// Gọi csdl để lấy dữ liệu
	$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program WHERE ma_mon_hoc = ' . $ma_mon_hoc . ' AND ma_nam_hoc = "' . $ma_nam_hoc . '" AND grade = ' . $grade);
	// Đổ dữ liệu
	while ($row = $query->fetch()) {
		$array[$row['ma_chuong_trinh']] = $row;
	}
	// hien thi du lieu 

		$i = 1;
		foreach ($array as $value) {
			$value['stt'] = $i++;
			$query_selected_subject = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_subject WHERE ma_mon_hoc = ' . $value['ma_mon_hoc']);
			$row_selected_subject = $query_selected_subject->fetch();
			$value['mon_hoc'] = $row_selected_subject['ten_mon_hoc'];

			$query_school_year = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_school_year WHERE ma_nam_hoc=". $value['ma_nam_hoc']);              
			$data_school_year = $query_school_year->fetch();
			$value['nam_hoc'] = $data_school_year['tu_nam'] . ' - ' . $data_school_year['den_nam'];

			$xtpl->assign('DATA', $value);
			$xtpl->parse('main.show.loop');
		}
	
	$xtpl->parse('main.show');
}

if ($nv_Request->isset_request('del', 'post')) {
	if($ma_mon_hoc && $ma_nam_hoc && $grade) {
		$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program WHERE ma_mon_hoc = ' . $ma_mon_hoc . ' AND ma_nam_hoc = "' . $ma_nam_hoc . '" AND grade = ' . $grade);		
		if($query) {
			while ($row = $query->fetch()) {
				$array[$row['ma_lop']] = $row;
			}
			if($array) {
				$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program WHERE ma_mon_hoc = ' . $ma_mon_hoc . ' AND ma_nam_hoc = "' . $ma_nam_hoc . '" AND grade = ' . $grade);		
				$success = $lang_module['delete_success'];
			}
			else
				$error = $lang_module['error_delete_null'];
		}
	}	
	else
		$error = $lang_module['error_delete_null'];
}

if ($nv_Request->isset_request('delall', 'post')) {
	$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program');		
	if($query) {
		while ($row = $query->fetch()) {
			$array[$row['ma_lop']] = $row;
		}
		if($array) {
			$db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_program');		
			$success = $lang_module['delete_success'];
		}
		else
			$error = $lang_module['error_delete_null'];
	}
	
}

if ($error) {
	$xtpl->assign('ERROR', $error);
	$xtpl->parse('main.error');
}

if ($success) {
	$xtpl->assign('SUCCESS', $success);
	$xtpl->parse('main.success');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');
 
include (NV_ROOTDIR . "/includes/header.php");
echo nv_admin_theme($contents);
include (NV_ROOTDIR . "/includes/footer.php");