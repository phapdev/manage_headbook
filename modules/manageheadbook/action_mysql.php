<?php

/**
 * Headbook Management System
 * @version 4.x
 * @author Group DNTU
 * @license GNU/GPL version 3 
 * @see https://github.com/phapdev/manage_headbook.git The Manage headbook GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . ';';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_school_info;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_class;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_subject;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_student;';

$sql_create_module = $sql_drop_module;


$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_school_info(
    id int(11) NOT NULL AUTO_INCREMENT,
    ten_so varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    ten_phong varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    ten_truong varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    tu_nam int(11) NOT NULL DEFAULT 0,
    den_nam int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_class (
    ma_lop int(11) NOT NULL AUTO_INCREMENT,
    ma_gvcn int(11) DEFAULT NULL,
    ten_lop varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
    khoi int(2) NOT NULL,
    PRIMARY KEY (ma_lop)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_student (
    ma_hoc_sinh int(11) NOT NULL AUTO_INCREMENT,
    ma_lop int(11) DEFAULT NULL,
    ho_ten varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    ngay_sinh int(11) NOT NULL,
    gioi_tinh varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    dia_chi varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    so_tiet_nghi float(11) NOT NULL DEFAULT 0,
    anh_dai_dien varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (ma_hoc_sinh)
) ENGINE=MyISAM;";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_subject (
    ma_mon_hoc int(11) NOT NULL AUTO_INCREMENT,
    ten_mon_hoc varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (ma_mon_hoc)
) ENGINE=MyISAM";
