<?php


namespace Iayoo\IP\source;


use Iayoo\IP\IpFactory;

class TencentMapApi extends IpFactory
{
    protected $uri = "https://apis.map.qq.com/ws/location/v1/ip";

    protected $clientKey = "";

    /**
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * @param string $clientKey
     */
    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;
    }

    public function getIp($ip)
    {
        $this->ip = $ip;
        $query = http_build_query(['key'=>$this->clientKey,'ip'=>$ip]);
        $res = $this->send("GET","{$this->uri}?{$query}",[]);
        $json = json_decode($res,true);
        if ($json && isset($json['status']) && $json['status'] === 0){
            if (isset($json['result']) && isset($json['result']['location'])){
                $this->setLongitude(isset($json['result']['location']['lng'])?$json['result']['location']['lng']:'');
                $this->setLatitude(isset($json['result']['location']['lat'])?$json['result']['location']['lat']:'');
            }
            if (isset($json['result']) && isset($json['result']['ad_info'])){
                $this->setCountry($json['result']['ad_info']['nation']);
                $this->setProvince($json['result']['ad_info']['province']);
                $this->setCity($json['result']['ad_info']['city']);
                $this->setDistrict($json['result']['ad_info']['district']);
            }
        }
        return $this;
    }
}