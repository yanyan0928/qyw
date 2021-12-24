<?php

/**
 * Created by PhpStorm
 * User:yanyan
 * Email:1932314889@qq.com
 * Date:2021/12/17
 */

require_once '../vendor/autoload.php';

use CORP\QywHandle;
use CORP\contants\Common;
$corpid='';
$secret='';
$ob = new QywHandle($corpid, $secret);
session_start();
//获取通讯录部门成员
$department_id = 62;
$fetch_child = 0;//是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门
$data = $ob->getAllUsers($department_id, $fetch_child);

//获取审批申请详情
$sp_no = "202112070001";
$data = $ob->getAuditDetail($sp_no);

$template_id = "3WK7BPGe1EdfoMUmqeFRg5834cySmmb3j6gzZnYE1";
$data = $ob->getTemplateDetail($template_id);

//获取审批模板详情
$template_id = "3WK7BPGe1EdfoMUmqeFRg5834cySmmb3j6gzZnYE1";
$data = $ob->getTemplateDetail( $template_id);

//生成签名
$data = $ob->getSignature();
Common::writeLog('日志调试');

//可在自建应用中发起审批请看audit.php

?>


