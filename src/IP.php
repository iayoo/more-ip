<?php
namespace Iayoo\IP;

use Iayoo\IP\source\FreeapiIpipNet;
use Iayoo\IP\source\IpApiCom;
use Iayoo\IP\source\TencentMapApi;

class IP{
    protected $able = [
        FreeapiIpipNet::class,
        IpApiCom::class,
        TencentMapApi::class
    ];

    protected $clients = [];

    protected $curClient;

    public function __construct($able = [])
    {
        if (!empty($able)){
            $this->able = $able;
        }
        $this->initClient();
    }

    /**
     * @param string|int $curClient
     */
    public function setCurClient($curClient)
    {
        if (is_numeric($curClient)){
            $index = 1;
            foreach ($this->clients as $class => $client){
                if ($index === (int)$curClient){
                    $this->curClient = $class;
                    return $this;
                }
                $index++;
            }
        }
        $this->curClient = $curClient;
        return $this;
    }


    protected function initClient(){
        foreach ($this->able as $client){
            $this->clients[$client] = new $client();
        }
    }

//    public function

    public function getIp($ip){
        foreach ($this->clients as $class => $client){
            $client->getIp($ip);
        }
        return $this;
    }

    public function getAll(){
        $return = [];
        foreach ($this->clients as $client){
            $return[] = $client->toArray();
        }
        return $return;
    }

    public function get($clientName)
    {
        $index = 0;
        foreach ($this->clients as $class => $client) {
            if (is_numeric($clientName)) {
                if ($index === (int)$clientName) {
                    return $client;
                }
                $index++;
            }else{
                if ($class === $clientName){
                    return $client;
                }
            }
        }
    }

    public function __call($name, $arguments)
    {
        if (!empty($this->curClient)){

            return call_user_func_array([$this->clients[$this->curClient],$name],$arguments);
        }
//        dump($this->clients);
        foreach ($this->clients as $class => $client){
            return call_user_func_array([$client,$name],$arguments);
        }
    }
}