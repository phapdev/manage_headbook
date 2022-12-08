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

