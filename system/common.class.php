<?php
/*
 *common
 **/
 class Common{
    public $client=null;
    
    public function __construct()
    {
       
    }
    
    /*
     *初始化
     **/
     public function init($class='',$type='frontend')
     {
        require(BASEPATH.'/config/webservice.config.php');
        $soap['location'] = $soap['uri'].'/'.$type.'/'.$class;
        $this->client = new SoapClient(null, $soap);
     }
     
     /*
      *获取post get cookie的值
      **/
      public function getData($param='')
      {
        require_once(BASEPATH.'/system/library/htmldata.class.php');
        $htmldata = new htmldata();
        $data = $htmldata->fetch();
        
        if($param)
        {
            $data = isset($data->$param) && $data->$param?$data->$param:'';
        }
        
        return $data;
        
      }
      
	  /*
		return formchecker's result
		封装formchecker 类， 具体详见:
			system/library/formchecker.class.php
	  */
	  public function getFormCheck($data,$rules){
		if(isset($data) && isset($rules)){
			require_once(BASEPATH.'/system/library/formchecker.class.php');
			$formChk = new formchecker($data);
			return $formChk->check($rules);
		}
		
	  }
     
     public function __destory()
     {
        $this->client=null;
     }
    
    
    
    
    
 }
 
 
/*
 *redis的连接和调用
 **/
class RedisDriver
{
    public static $redisConfig=null;
    public static $redisServices=null;
    
    
    /*
     *连接redis
     **/
    static public function connetc()
    {
        self::$redisConfig = require(BASEPATH.'/config/redis.config.php');
        require_once(BASEPATH.'/system/library/redis.class.php');
        if(empty(self::$redisConfig))
        {
            Error::show('redis.config not found');
        }
        self::$redisServices =new RedisCluster();

        self::$redisServices->connect(array('host'=>self::$redisConfig['host'],'port'=>self::$redisConfig['port']));
        if(!self::$redisServices)
        {
             Error::show('redis not connect service.');
        }
    }
    
    /*
     *设置redis
     **/
      public static function set($key,$value,$expire=0)
     {
        self::connetc();
        $key = self::$redisConfig['prefix'].$key;
        self::$redisServices->set($key,$value,$expire);
     }
     
     /*
      *获取redis
      **/
       public static function get($key)
      {
        self::connetc();
        $key = self::$redisConfig['prefix'].$key;
        return self::$redisServices->get($key);
      }
     
      /*
       *删除redis
       **/
        public static function delete($key)
       {
         self::connetc();
         $key = self::$redisConfig['prefix'].$key;
         self::$redisServices->remove($key);
       }
    
}


/*
 *session 的
 **/
class Session
{
    public static $domain='.hx9999.com';
    public static $path = '/';
    
    /*
     *生成一个sessionid
     **/
      public static function sessionid()
     {
        $key = rand(10000,99999);
        $keyMd5 = md5($key);
        setcookie('PHPSESSIONID',$keyMd5,0,self::$path,self::$domain);
        return $keyMd5;
     }
     
     
     /*
      *设置session
      **/
      public static function set($key,$value='',$expire=0)
     {
        if(!$key || !$value)
        {
            return false;
        }
        
        $sessionKey = isset($_COOKIE['PHPSESSIONID']) && $_COOKIE['PHPSESSIONID'] ? $_COOKIE['PHPSESSIONID']:self::sessionid();
        
        $key = $sessionKey.$key;
        RedisDriver::set($key,$value,$expire);
        
        return true;
     }
     
     /*
      *获取session
      **/
       public static function get($key)
      {
        if(!$key)
        {
            return false;
        }
        
        if(!isset($_COOKIE['PHPSESSIONID']))
        {
           return false; 
        }
        
        $sessionKey = $_COOKIE['PHPSESSIONID'];
        $key = $sessionKey.$key;

        return RedisDriver::get($key);
        
      }
      
      /*
       *删除session
       **/
        public static function delete($key)
       {
            if(!$key)
            {
                return false;
            }
            
             if(!isset($_COOKIE['PHPSESSIONID']))
            {
               return true; 
            }
            
            $sessionKey = $_COOKIE['PHPSESSIONID'];
            $key = $sessionKey.$key;
            RedisDriver::delete($key);
            return true;
       }
}


/*
 *错误提示
 **/
 class Error{
    
     public static function show($msg)
    {
        exit($msg);
    }
 }
 
 
 /*
  *扩展
  **/
 class Core
 {
    /*
     *公共函数的加载
     **/
    static public function helper($param)
    {
        include_once(SYSTEMPATH."/helper/{$param}.helper.php");
    }
 }