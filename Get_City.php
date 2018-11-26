<?php
use itbdw\Ip\IpLocation;
class Get_City{

	function __construct(){}
	public function City(){
		if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknow")){
		$ip = getenv("HTTP_CLIENT_IP");
		}else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknow")){
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		}else if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknow")){
		$ip = getenv("REMOTE_ADDR");
		}else if(isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"],"unknow")){
		$ip = $_SERVER["REMOTE_ADDR"];
		}else{
		$ip = "0.0.0.0";
		}
        $ip_city = new ipip\db\City(__DIR__ . '/ipiptest.ipdb');
		return $ip_city->findMap($ip,'CN');
    }

}
?>