<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class Demo {

	public function test()
	{
		$json = $data = [];
		$data = Request::instance()->param();

		if(isset($data) && !empty($data['content'])) {
			$json = ['code'=>200, 'msg'=>'success'];
		}else {
			$json = ['code'=>400, 'msg'=>'failed'];
		}

		return json_encode($json);
	}

	function http_down($url, $filename, $timeout = 60) {
		$url = 'http://tupian.tupianzy.com/pic/upload/vod/2018-01-24/201801241516773218.jpg';
	    $path = dirname($filename);
	    if (!is_dir($path) && !mkdir($path, 0755, true)) {
	        return false;
	    }
	    $fp = fopen($filename, 'w');
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_FILE, $fp);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	    curl_exec($ch);
	    curl_close($ch);
	    fclose($fp);
	    return $filename;
	}
}