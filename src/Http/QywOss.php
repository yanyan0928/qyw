<?php


namespace CORP\Http;

class QywOss
{
    private static $_instance = null;
    public $client;
    
    private function __construct($secret_code)
    {
        $this->client = new \CORP\Http\QywApi($secret_code);
    }
    
    public static function getInstance($secret_code)
    {
        if (!self::$_instance) {
            self::$_instance = new self($secret_code);
        }
        return self::$_instance;
    }
    
    private function __clone()
    {
    }
    
    
}
