<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/9
 * Time: 10:40
 */

namespace CORP;

use CORP\QywHandle;

class QywController
{
    /**
     * Created by PhpStorm.
     * TODO 获取通讯录部门成员
     * @param  $department_id 获取的部门id
     * @param $fetch_child 是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门
     * @param $token_code 不同的应用对应标识
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function actionGetAllUsers()
    {
        $obj = new QywHandle(1);
        $department_id = 62;
        $fetch_child = 0;
        $token_code = 1;
        $data = $obj->getAllUsers($department_id, $fetch_child);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取审批申请详情
     * @param  $sp_no 审批单号
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function actionGetAuditDetail()
    {
        $obj = new QywHandle(2);
        $sp_no = "202112070001";
        $data = $obj->getAuditDetail($sp_no);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取审批模板详情
     * @param  $template_id 审批模板id
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function actionGetTemplateDetail()
    {
        $obj = new QywHandle(2);
        $template_id = "3WK7BPGeEdfoMUmqeFRg5834cySmmb3j6gzZnYE1"; //OKR
        $data = $obj->getTemplateDetail( $template_id);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 提交审批申请
     * @param  $template_id 审批模板id
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function actionGetTemplateDetails()
    {
        $obj = new QywHandle(2);
        $template_id = "3WK7BPGeEdfoMUmqeFRg5834cySmmb3j6gzZnYE1"; //OKR
        $data = $obj->getTemplateDetail($template_id);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 审批流签名
     * @param
     * @return
     * @author syy
     * @date 2021-12-08
     */
    public function actionGetSignature()
    {
        $obj = new QywHandle(3);
        return json_encode($obj->getSignature(), true);
        
    }
}