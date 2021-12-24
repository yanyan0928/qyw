<?php


namespace CORP\http;

class QywOss
{
    private static $_instance = null;
    public $client;
    
    private function __construct($corpid, $secret)
    {
    
        $this->client = new \CORP\http\QywApi($corpid, $secret);
    }
    
    public static function getInstance($corpid, $secret)
    {
        if (!self::$_instance) {
    
            self::$_instance = new self($corpid, $secret);
        }
        return self::$_instance;
    }
    
    private function __clone()
    {
    }
    
    
}
