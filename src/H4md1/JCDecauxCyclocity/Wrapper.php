<?php

namespace H4md1\JCDecauxCyclocityBundle;

class Wrapper
{
    const API_ENDPOINT = "https://api.jcdecaux.com/vls/v1/";
    private $operations = array(
            0 => array( "query" => "contracts?apiKey=%s" ),
            1 => array( "query" => "stations?apiKey=%s" ),
            2 => array( "query" => "stations/%d?contract=%s&apiKey=%s" ),
            3 => array( "query" => "stations?contract=%s&apiKey=%s" )
    );
    private $apiKey = false;
    
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    public function setApiKey($key)
    {
        $this->apiKey = $key;
    }
    
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    public function getStationsByContract($contractName)
    {
        return $this->query(sprintf($this->operations[3]['query'], $contractName, $this->apiKey));
    }
    
    public function getContracts()
    {
        $url = sprintf($this->operations[0]['query'], $this->apiKey);
        return $this->query($url);
    }
    
    public function getStation($contractName, $stationId)
    {
        return $this->query(sprintf($this->operations[2]['query'], $stationId, $contractName, $this->apiKey));
    }
    
    public function setHTTPClient($client)
    {
        $this->HTTPClient = $client;
    }
    private function query($url)
    {
        return $this->HTTPClient->get(self::API_ENDPOINT.$url);
    }
}
