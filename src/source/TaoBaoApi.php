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
        $queryArr = ['ip'=>$ip];
        if (!empty($this->clientKey)){
            $queryArr['accessKey'] = $this->clientKey;
        }
        $query = http_build_query($queryArr);
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