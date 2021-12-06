<?php


namespace Iayoo\IP\source;


class WhoisPconlin extends \Iayoo\IP\IpFactory
{
    protected $uri = "https://whois.pconline.com.cn/ipJson.jsp";

    public function getIp($ip)
    {
        $this->ip = $ip;
        $query = http_build_query(['json'=>'true','ip'=>$ip]);
        $res = $this->send("GET","{$this->uri}?{$query}",[]);
        $res = mb_convert_encoding($res, 'utf-8','GB2312');
        $res = str_replace("\n",'',str_replace("\r\n",'',$res));
        $json = json_decode($res,true);
        if ($json && empty($json['err'])){
//            $this->set(isset($json[0])?$json[0]:'');
            $this->setProvince(isset($json['pro'])?$json['pro']:'');
            $this->setCity(isset($json['city'])?$json['city']:'');
            $this->setDistrict(isset($json['region'])?$json['region']:'');
            $this->setAddress(isset($json['addr'])?$json['addr']:'');
        }else{
            $this->isSuccess = false;
        }
        return $this;
    }
}