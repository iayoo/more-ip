<?php


namespace Iayoo\IP\source;


class TaoBaoApi extends \Iayoo\IP\IpFactory
{
    protected $uri = "https://ip.taobao.com/outGetIpInfo";

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
        $query = http_build_query(['accessKey'=>$this->clientKey,'ip'=>$ip]);
        // ?accessKey=alibaba-inc
        $res = $this->send("GET","{$this->uri}?{$query}",[]);
        $json = json_decode($res,true);
        if ($json && isset($json['code']) && $json['code'] === 0){
            if (isset($json['data'])){
                $this->setCountry($json['data']['country']);
                $this->setProvince($json['data']['region']);
                $this->setCity($json['data']['city']);
                $this->setOperator($json['data']['isp']);
            }
        }
        return $this;
    }
}