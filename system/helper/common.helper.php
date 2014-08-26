<?php
/**
 *公用方法库
 * @filesource
 */

if ( ! function_exists('get_client_ip'))
{
	/**
	* 取得客户端的IP地址
	*/
	 function get_client_ip()
	{
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}
}

if(! function_exists('get_rand_value')){
	/**
	 *获取一个随机字符
	 **/
	function get_rand_value($str_length=6){
		$str = '';  
		for ($i = 0; $i < $str_length; $i++)  {  
			$str .= chr(mt_rand(97, 122));  
		}  
		return strtoupper($str);
	}
}

if(! function_exists('mb_string')){
	/**
	 * 截取中文字符不乱码
	 * @param string
	 * @return string
	 */
	function mb_string($str,$start=0,$length=20,$encoding='utf-8',$ellipsis='...'){
		if(isset ($str) && is_string($str) && trim($str)){
			$string = mb_substr($str, $start, $length, $encoding);
			if(mb_strlen($str,$encoding)>$length){
				$string .= $ellipsis;
			}
			return $string;
		}else{
			return "";
		}
	}
}

/**
 *420 mt4.class.php 
 *curl 请求
 **/
if(! function_exists('curl')){
    function curl( $url, $data = NULL, $method='GET' ) {
        $ch         = curl_init();

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        if($method == 'POST') {
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, TRUE);

            if(!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        } else {
            curl_setopt($ch, CURLOPT_URL, $url . $data);
        }


    //    for($i = 0; $i < 3; $i++) {          // 如果失败，就再尝试 2 次，解决网络偶尔不稳定的问题。
            $info['content'] = curl_exec($ch);
            $info['status']    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //		if($info['status'] == '200') break;
     //   }

        if($info['content'] === false) {
            $info['content'] = 'curl_error: ' . curl_error($ch);
            // echo 'curl_error: ', curl_error($ch);
            // exit;
        } else {   // 处理编码问题
            $info['content'] = mb_convert_encoding($info['content'], 'UTF-8', 'GBK');
        }

        curl_close($ch);

        return $info;
    }
}

/*
 *PHP 头部 链接转向
 **/
 if(! function_exists('redirect')){
    function redirect($url)
	{
		header("Location: $url");
		exit;
	}
 }
 
 /*
  *JS链接转向
  **/
  
  if(! function_exists('jsRedirect')){
  
    function jsRedirect($strurl,$msg='')
	{
	    $html='<script>';
		if($msg!=''){
			$html .= 'alert("'.$msg.'");';
		}
		$html .= "window.location.href='" . $strurl . "';";
		$html .='</script>';
		echo $html;
		exit();
	}
  }
  
  /*
   *fb firefox打印函数
   **/
   if(! function_exists('fb')){
       include_once(SYSTEMPATH.'/library/firephp/fb.php');
    }

/**
 *验证码模板
 **/
if(!function_exists('get_vcode_email_tpl')){
    function get_vcode_email_tpl($vcode){
        $file = BASEPATH.'/htdocs/cn/vcode_email_tpl.html';
        $content = file_get_contents($file);
        if(!$content)return '';
        return str_replace('vcode',$vcode,$content);
    }
}

 
 