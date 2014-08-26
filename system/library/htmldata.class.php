<?php
class htmldata
{
	public $htmlEditorVars = array();
	public $data = array();
	
	public function fetch()
	{
		global $_COOKIE,$_POST,$_GET;
		$_datas = array($_COOKIE,$_POST,$_GET);
		foreach($_datas as $_request) {
			foreach($_request as $_key => $_value) {
				//if(in_array($_key,$this->htmlEditorVars))
				//{
				//	$this->data[$_key] = $this->_stripslashes($_value);
				//	continue;
				//}
				$_key{0} != '_' && $this->data[$_key] = $this->filter($this->_addslashes($_value));
			}
		}
		return (object)$this->data;
	}
	
	//public function setHtmlEditorVars($array)
	//{
	//	$this->htmlEditorVars = $array;
	//}
	
	private function _addslashes($string, $force = 0)
	{
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = $this->_addslashes($val, $force);
				}
			} else {
				$string = addslashes($string);
			}
		}
		return $string;
	}
	
	
	/**
	* 内容过滤(过滤javascript脚本标签)
	*/
	private function filter($string)
	{
		if(is_string($string)){
			$string = trim(preg_replace("/<[\/]*script[^>]*>/",'',$string));
			$string = preg_replace("/'/",'`',$string);
		}
		
		return $string;
	}
	
	public function save_session_data($names_array)
	{
		$_SESSION['prepost']=array();
		foreach($names_array as $name)
		{
			$_SESSION['prepost'][$name] = $this->data[$name];
		}
	}
	
	public function load_session_data()
	{
		$obj = (object)$_SESSION['prepost'];
		unset($_SESSION['prepost']);
		return $obj;
	}
}
?>