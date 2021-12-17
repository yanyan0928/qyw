<?php

/**
 * Created by PhpStorm
 * User:yanyan
 * Email:1932314889@qq.com
 * Date:2021/12/17
 */

require_once '../vendor/autoload.php';

use CORP\QywHandle;
$ob = new QywHandle(1);
session_start();
$department_id = 62;
$fetch_child = 0;
$token_code = 1;
$data = $ob->getAllUsers($department_id, $fetch_child);
print_r($data);

?>


