<?php

/**
 * Headbook Management System
 * @version 4.x
 * @author Group DNTU
 * @license GNU/GPL version 3 
 * @see https://github.com/phapdev/manage_headbook.git The Manage headbook GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$module_version = [
    'name' => 'Manage_headbook',
    'modfuncs' => 'main',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.5.01',
    'date' => 'Wednesday, Dec 07, 2022 09:00:00 PM GMT+07:00',
    'author' => 'Group DNTU',
    'uploads_dir' => [
        $module_upload
    ]
];
