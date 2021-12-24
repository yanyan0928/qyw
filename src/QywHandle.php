<?php


namespace CORP;

use CORP\http\QywOss;
use CORP\contants\CodeConst;

class QywHandle
{
    private $corpid;
    private $secret;
    public function __construct($corpid, $secret)
    {
        $this->secret = $secret;
        $this->corpid = $corpid;
        if (empty($this->corpid)) {
            throw new \Exception("access key id is empty");
        }
        if (empty($this->secret)) {
            throw new \Exception("access key secret is empty");
        }
        return $this->client = QywOss::getInstance($this->corpid, $this->secret)->client;
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取通讯录部门成员
     * @param $access_token 调用接口凭证
     * @param $department_id 获取的部门id
     * @param $fetch_child 是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function getAllUsers($department_id, $fetch_child)
    {
        $access_token = $this->getWxAccessToken();
        return $this->client->getAllUsers($access_token, $department_id, $fetch_child);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取审批申请详情
     * @param  $sp_no 审批单号
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function getAuditDetail($sp_no)
    {
        $access_token = $this->getWxAccessToken($this->secret);
        return $this->client->getAuditDetail($access_token, $sp_no);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取审批模板详情
     * @param  $template_id 审批模板id
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function getTemplateDetail($template_id)
    {
        $access_token = $this->getWxAccessToken($this->secret);
        return $this->client->getTemplateDetail($access_token, $template_id);
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取accessToken
     * @param $token_code 各应用对应的access_token编号
     * @return string
     * @author syy
     * @date 2021-12-07
     */
    public function getWxAccessToken(){
        //这里使用session来暂时保存access_token，可以使用mysql数据库来保存数据
        if(isset($_SESSION['access_token_'.$this->secret]) && isset($_SESSION['expires_in_'.$this->secret])
                && $_SESSION['expires_in_'.$this->secret]-time()>0 ){
            //如果缓存中已经存在了access_token，并且没有过期，可以直接取用就行
            return $_SESSION['access_token_'.$this->secret];
        }else{
            $info = $this->client->getWxAccessToken();
            if($info["errcode"] == 0){
                $access_token = $info['access_token'];
                $_SESSION['access_token_'.$this->secret] = $access_token;
                $_SESSION['expires_in_'.$this->secret] = time() + 7200;
                //也可写入数据库
                return $access_token;
            };
            return CodeConst::$access_token_Error;
        }
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取jsapi_ticket
     * @param $token_code 各应用对应的access_token编号
     * @return string
     * @author syy
     * @date 2021-12-08
     */
    public function getJsApiTicket(){
        if($_SESSION['jsapi_ticket'] && ($_SESSION['jsapi_ticket_expires_in']-time()>0) ){
            //如果缓存中已经存在了access_token，并且没有过期，可以直接取用就行\
            return $_SESSION['jsapi_ticket'];
        }else{
            $access_token = $this->getWxAccessToken();
            $jsapi_ticket = $this->client->getJsApiTicket($access_token);
            $_SESSION['jsapi_ticket'] = $jsapi_ticket;
            $_SESSION['jsapi_ticket_expires_in'] = time() + 7200;
            //也可写入数据库
            return $jsapi_ticket;
        }
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取jsapi_ticket
     * @param $token_code 各应用对应的access_token编号
     * @return string
     * @author syy
     * @date 2021-12-08
     */
    public function getSignature(){
        $jsapi_ticket = $this->getJsApiTicket();
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "corpid"    => $this->client->corpid,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "agentId" => 1000036
        );
        return $signPackage;
    }
    
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
