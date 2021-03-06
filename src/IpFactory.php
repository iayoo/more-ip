<?php


namespace Iayoo\IP;


abstract class IpFactory
{
    /** @var string 经度 */
    public $longitude;
    /** @var string 纬度 */
    public $latitude;
    /** @var string ip */
    public $ip;
    /** @var string 国家 */
    public $country;
    /** @var string 省份 */
    public $province;
    /** @var string 城市 */
    public $city;
    /** @var string 区 */
    public $district;

    public $address;

    /** @var string 运营商 */
    public $operator;

    protected $uri;

    protected $appKey;

    protected $isSuccess = false;

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp($ip){}

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param string $district
     */
    public function setDistrict($district)
    {
        $this->district = $district;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    protected function send($method = "GET",$url="" ,$requestData=[]){

//        $headers = array();
//        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
//        $headers[] = 'Accept-Language: zh-CN,zh;q=0.9';
//        $headers[] = 'Cache-Control: no-cache';
//        $headers[] = 'Content-Type: text/html; charset=GBK';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_ACCEPT_ENCODING, "gzip,deflate");

        if (strtoupper($method) === "POST"){
            //普通数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestData));
        }
        $res = curl_exec($curl);
        //$info = curl_getinfo($ch);
        curl_close($curl);
        return $res;
    }

    public function toArray(){
        if($this->isSuccess === false){
            return null;
        }
        return [
            'longitude' => $this->longitude,
            'latitude'  => $this->latitude,
            'ip'        => $this->ip,
            'country'   => $this->country,
            'province'  => $this->province,
            'city'      => $this->city,
            'district'  => $this->district,
            'operator'  => $this->operator,
            'address'   => $this->address,
        ];
    }
}