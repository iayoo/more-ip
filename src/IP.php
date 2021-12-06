<?php
namespace Iayoo\IP;

use Iayoo\IP\source\FreeapiIpipNet;
use Iayoo\IP\source\IpApiCom;
use Iayoo\IP\source\TaoBaoApi;
use Iayoo\IP\source\TencentMapApi;
use Iayoo\IP\source\WhoisPconlin;

class IP{
    protected $able = [
        FreeapiIpipNet::class,
        IpApiCom::class,
        TencentMapApi::class,
        WhoisPconlin::class,
        TaoBaoApi::class
    ];

    protected $keyList = [
    ];

    protected $clients = [];

    protected $curClient;

    public function __construct($able = [],$keyList = [])
    {
        if (!empty($able)){
            $this->able = $able;
            $this->keyList = $keyList;
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
            if (isset($this->keyList[$client])){
                $this->clients[$client]->setClientKey($this->keyList[$client]);
            }
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
        foreach ($this->clients as $class => $client){
            $tmp = $client->toArray();
            $classEx = explode('\\',$class);
            $tmp['name'] = $this->uncamelize($classEx[count($classEx)-1]);
            $return[] = $tmp;
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

    protected function uncamelize($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}