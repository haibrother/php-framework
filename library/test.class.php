<?php
class Test extends Common
{
    
    
    public function test1()
    {
        Session::set('laobi','2342434');
        
        $v = Session::get('laobi');
        var_dump($v);
    }
    
    public function test2()
    {
        setcookie('laobi','2342434');
        var_dump($_COOKIE['laobi']);
    }
    
    
    /*
     *设置缓存
     **/
     public function setCache()
     {
        RedisDriver::set('username','laobi','100');
     }
     
     /*
      *获取缓存
      **/
      public function getCache()
      {
        $value = RedisDriver::get('username');
        var_dump($value);
      }
      
      public function deleteCache()
      {
        RedisDriver::delete('username');
      }
      
      
      /*
       *设置session
       **/
       public function setSession()
       {
            Session::set('username','laobi22','1000');
       }
       
       /*
        *获取session
        **/
        public function getSession()
        {
            $value = Session::get('username');
            var_dump($value);
        }
        
        public function deleteSession()
        {
            Session::delete('username');
        }
        
        public function getDatas()
        {
            Core::helper('common');
            var_dump(get_client_ip());
        }
        
        /*
         *测试fb
         **/
         public function fb()
         {
            Core::helper('common');
            fb('123test');
         }
    
     
}