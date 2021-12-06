<?php
namespace Iayoo\IP\source;

use Iayoo\IP\IpFactory;

class IpApiCom extends IpFactory
{

    protected $uri = "http://ip-api.com/json/";

    public function getIp($ip)
    {
        $this->ip = $ip;
        $res = $this->send("GET","{$this->uri}{$ip}?lang=zh-CN",[]);
        $json = json_decode($res,true);
        if ($json && isset($json['status']) && $json['status'] == 'success'){
            $this->setCountry(isset($json['country'])?$json['country']:'');
            $this->setProvince(isset($json['regionName'])?$json['regionName']:'');
            $this->setCity(isset($json['city'])?$json['city']:'');
            $this->setLatitude(isset($json['lat'])?(string)$json['lat']:'');
            $this->setLongitude(isset($json['lon'])?(string)$json['lon']:'');
        }else{
            $this->isSuccess = false;
        }
        return $this;
    }
}