<?php
/*
 *单入口
 **/
class Framework{
    private $server = array();
	private $class 	= null;
	private $method	= null;
    
    public function __construct($server = null)
    {
		if(empty($server))
        {
			$this->server = $_SERVER;
		}else{
			$this->server = $server;
		}
        print($this->load());
    }
    
    /*
     *加载
     **/
     public function load()
     {
		$request_uri = $this->server['REQUEST_URI'];
        $request_uri = preg_replace("/[\?|#].*$/",'',$request_uri);
        $request_arr = explode('/',$request_uri);
        $class_file  = isset($request_arr[1]) && $request_arr[1]?$request_arr[1]:'index';
        $method = isset($request_arr[2]) && $request_arr[2]?$request_arr[2]:'index';
		$classspath = LIBRARY_DIR.strtolower($class_file)  . '.class.php';
		if( is_file($classspath) ){
			require_once($classspath);
			$class = ucfirst($class_file);
			if (class_exists($class)) {
				$this->class = $class;
			}else{
                $this->halt('Object isnot exist');
			}
		}else{
            $this->halt('404 not found');
		}
		
		if (class_exists($this->class)) {
			if(method_exists($this->class, $method)){
				$obj = new $this->class;
				$obj->$method();
			}else{
                $this->halt('Method isnot exist');
			}
		}
     }
     
     
     
     /*
      *终止
      **/
      public function halt($msg='')
      {
        exit($msg);
      }
     
}