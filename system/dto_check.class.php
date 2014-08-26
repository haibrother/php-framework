<?php
	class _void{};
	class dto{
		function ggs($obj)
		{		
			$r="\"\"";
			switch(gettype($obj)){
				case "integer":
					$r="$obj";
					break;
				case "double":
					$r="$obj";
					break;
				case "string":
					$obj=str_replace("\\","\\\\ ",$obj);
					$obj=str_replace("\n","\\n",$obj);
					$obj=str_replace("\b","\\b",$obj);
					$obj=str_replace("\t","\\t",$obj);
					$obj=str_replace("\'","\\' ",$obj);
					$obj=str_replace("\r","\\r",$obj);
					$obj=str_replace("\"","\\\" ",$obj);		
					$r="\"$obj\"";
					break;
				case "NULL":
					$r="null";
					break;
				case "array":
					$r="[";
					foreach ($obj as $value)
						$r.=$this->ggs($value).",";
					if($r!="[")
						$r=substr($r,0,-1);
					$r.="]";
					break;
				case "object";
					$r="{";
					$_o=get_object_vars($obj);
					foreach($_o as $k=>$v)
					{
						$r.=$k.":".$this->ggs($v).",";
					}
					if($r!="{")
						$r=substr($r,0,-1);
					$r.="}";
					break;
			}
			return $r;
		}

		function changeHtml($val){
			$search = array ("'<script[^>]*?>.*?</script>'si",  //去掉 javascript
				 "'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 標記
				 "'([\r\n])[\s]+'",                 // 去掉空白符
				 "'&(nbsp|#160);'i",
				 "'&(iexcl|#161);'i",
				 "'&(cent|#162);'i",
				 "'&(pound|#163);'i",
				 "'&(copy|#169);'i",
				 "'&#(\d+);'e",
				 "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isu",
				 "/(<[^>]*)on[a-za-z]+\s*=([^>]*>)/isu");                    // 作為PHP運行代碼
			$replace = array ("","","\\1"," ",chr(161),chr(162),chr(163),chr(169),"chr(\\1)");
			return preg_replace ($search, $replace, $val);
		}
		
		function request($val){
			$val=trim($val);
			if ($val=="") $val=" ";
			$val=str_replace("<","&lt;",$val);
			$val=str_replace(">","&gt;",$val);
			$val=str_replace("\n","<br>",$val);
			$val=str_replace(" ","&nbsp;",$val);
			$val=str_replace("'","&#39;",$val);
			$val=str_replace("&","&amp;",$val);
			$val=str_replace("\t","    ",$val);
			$val=str_replace("\r\n","\n",$val);
			$val=str_replace("\\\\","&#92;",$val);
			$val=str_replace("where","&#94;",$val);
			return $val;
		}

		//生成隨機數 $length 生成隨機的長度,mode是類型
		function getCode ($length=8,$mode=0){
			 switch ($mode) {
				case '1':
					$str = '1234567890';
					break;
				case '2':
					$str = 'abcdefghijklmnopqrstuvwxyz';
					break;
				case '3':
					$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
				case '4':
					$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
					break;
				case '5':
					$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					break;
				case '6':
					$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
					break;
				default:
					$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
					break;
			 }
			 $result = '';
			 $len = strlen($str)-1;
			 for($i = 0;$i <= $length;$i ++){
				   $num = rand(0,$len);
				   $result.= $str[$num];
			 }
			 return $result;
		}
		//生成隨機數
		
		function getIp(){
		   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			   $ip = getenv("HTTP_CLIENT_IP");
		   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			   $ip = getenv("HTTP_X_FORWARDED_FOR");
		   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			   $ip = getenv("REMOTE_ADDR");
		   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			   $ip = $_SERVER['REMOTE_ADDR'];
		   else
			   $ip = "unknown";
		   return($ip);
		}

	}

?>