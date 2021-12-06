<?php


namespace Iayoo\IP\source;


use Iayoo\IP\IpFactory;

class FreeapiIpipNet extends IpFactory
{
    protected $uri = "https://freeapi.ipip.net/";

    public function getIp($ip)
    {
        $this->ip = $ip;
        $res = $this->send("GET","{$this->uri}{$ip}",[]);
        $json = json_decode($res,true);
        if ($json){
            $this->setCountry(isset($json[0])?$json[0]:'');
            $this->setProvince(isset($json[1])?$json[1]:'');
            $this->setCity(isset($json[2])?$json[2]:'');
            $this->setDistrict(isset($json[3])?$json[3]:'');
        }else{
            $this->isSuccess = false;
        }
        return $this;
    }
}