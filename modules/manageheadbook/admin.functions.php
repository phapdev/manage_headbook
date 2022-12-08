<?php

/**
 * Headbook Management System
 * @version 4.x
 * @author Group DNTU
 * @license GNU/GPL version 3 
 * @see https://github.com/phapdev/manage_headbook.git The Manage headbook GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

$allow_func = [
    'main',
    'school_info',
    'addclass',
    'class',
    'delclass',
    'student',
    'delstudent',
    'subject',
    'addsubject',
    'delsubject',
    'schoolyearlist',
    'addyear',
    'addstudent'
];

define('NV_IS_FILE_ADMIN', true);