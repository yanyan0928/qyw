<?php


namespace CORP\Http;

use mysql_xdevapi\Exception;

class QywApi
{
    public $corpid = 'ww1422b795444cb44b93d';
    //允许的应用凭证
    private static $corpsecrets = [
        1 => 'OnULdCxtSYOZZdy0ytaZcQ2244lQ_VFRcqW4MIcJmnVM4',//通讯录
        2 => 'WDOFUKIAVGYoHw4qkp-gO0FUT44rHRY6yhGAh6N-Q56Xw',//OA-审批
        3 => '72Khv9znQf8sdvp93D_hWtkdb44gjklBjw2wmE3XxSyTU',//自建应用
    ];
    
    
    /**
     * 构造函数
     *
     * 构造函数情况：
     * 1. 一般的时候初始化使用 $ossClient = new QywApi($corpid, $corpsecret)
     *
     * @param string $corpid 企业ID
     * @param string $corpsecret 应用凭证
     * @throws OssException
     */
    public function __construct($secret_code)
    {
        $secret_code = trim($secret_code);
        if (empty($this->corpid)) {
            throw new Exception("access key id is empty");
        }
        if (empty($secret_code)) {
            throw new Exception("access key secret is empty");
        }
        
        if (!array_key_exists($secret_code, self::$corpsecrets)) {
            $corpsecret = self::$corpsecrets[1];
        }else{
            $corpsecret = self::$corpsecrets[$secret_code];
        }
        $this->corpsecret = $corpsecret;
    }
    
    /**
     * Created by PhpStorm.
     * TODO 网页采集工具
     * @parm: $url  , string , 网页或者接口地址
     * @parm: $type , string , 是post请求还是get请求，默认的话是get请求
     * @parm: $res  , string , 网页返回的是什么形式的数据
     * @parm: $arr  , array  , 发送post请求的时候携带的一些参数
     * @return 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function http_curl($url, $type='get', $res='json', $arr = null){
        //1.初始化
        $ch = curl_init();
        //2.设置参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if( $type == 'post' ){
            //如果是post请求的话,设置post的一些参数
            curl_setopt($ch , CURLOPT_POST , 1);
            curl_setopt($ch , CURLOPT_POSTFIELDS, $arr);
        }
        //3.执行
        $result = curl_exec($ch);
        if( curl_errno($ch)){
            //打印错误日志
            var_dump(curl_error($ch));
        }
        //4.关闭
        curl_close($ch);
        
        if( $res == 'json' ){
            //将json转化成数组的形式
            $result = json_decode($result , TRUE);
        }
        return $result;
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取accessToken
     * @return string
     * @author syy
     * @date 2021-12-07
     */
    public function getWxAccessToken(){
        $url ='https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid='.$this->corpid.'&corpsecret='.$this->corpsecret;
        $arr = $this->http_curl($url,'get','json');
        if($arr["errcode"] == 0) return $arr['access_token'];
        echo $arr['errmsg'];
        exit;
    }


    
    /**
     * Created by PhpStorm.
     * TODO 获取accessToken
     * @return string
     * @author syy
     * @date 2021-12-07
     */
    public function getJsApiTicket($access_token){
        $url ='https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token='.$access_token;
        $arr = $this->http_curl($url,'get','json');
        return $arr['ticket'];
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取部门成员
     * @param $access_token 调用接口凭证
     * @param $department_id 获取的部门id
     * @param $fetch_child 是否递归获取子部门下面的成员：1-递归获取，0-只获取本部门
     * @return $arr 返回一个数组类型的数据
     * @author syy
     * @date 2021-12-07
     */
    public function getAllUsers($access_token, $department_id, $fetch_child){
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/simplelist?access_token='.$access_token.'&department_id='.$department_id.'&fetch_child='.$fetch_child;
        $arr = $this->http_curl($url,'get','json');
        return $arr;
    }
    
    /**
     * Created by PhpStorm.
     * TODO 获取审批申请详情
     * @param
     * @return
     * @author syy
     * @date 2021-12-07
     */
    public function getAuditDetail($access_token, $sp_no){
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/oa/getapprovaldetail?access_token='.$access_token.'&&debug=1';
        $arr["sp_no"] = $sp_no;
        $arr = json_encode($arr);
        $arr = $this->http_curl($url,'post','json', $arr);
        return $arr;
    }
    
    public function getTemplateDetail($access_token, $template_id){
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/oa/gettemplatedetail?access_token='.$access_token;
        $arr["template_id"] = $template_id;
        $arr = json_encode($arr);
        $arr = $this->http_curl($url,'post','json', $arr);
        return $arr;
    }
    
    
}
