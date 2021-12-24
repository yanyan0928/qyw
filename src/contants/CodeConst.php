<?php
namespace CORP\contants;

/**
 * config.php
 *
 * @author        yanyan <yanyan.shen@ht-med.com>
 * @copyright (c) 2021/12/24, HT-MED
 * @since         version 1.0
 * Created on 2021/12/24 下午3:52
 */
class CodeConst{
    /**
     * @var array 成功
     */
    public static $success = [
        'msg'  => 'success',
        'code' => 200,//根据实际业务需要调整
    ];
    
    /**
     * @var array 失败
     */
    public static $error = [
        'msg'  => '系统繁忙',
        'faq'  => '请稍后重试',
        'code' => -1001,
    ];
    
    public static $exception = [
        'msg'  => '系统异常',
        'faq'  => '查看系统异常日志',
        'code' => -1002,
    ];
    
    public static $signFailed = [
        'msg'  => '签名验证失败',
        'faq'  => '请检查生成签名参数',
        'code' => -1003,
    ];
    
    public static $corpError = [
        'msg'  => '企业corpid错误',
        'faq'  => '检查企业ID',
        'code' => -1004,
    ];
    
    public static $secretError = [
        'msg'  => '企业secret错误',
        'faq'  => '检查应用密钥',
        'code' => -1005,
    ];
    
    public static $templateError = [
        'msg'  => '模板id错误',
        'code' => -1006,
    ];
    
    public static $access_token_Error = [
        'msg'  => 'access_token错误',
        'code' => -40013,
    ];
    
   
}

