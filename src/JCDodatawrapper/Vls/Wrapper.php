<?php
namespace JCDodatawrapper\Vls;

class Wrapper{
    const API_ENDPOINT = "https://api.jcdecaux.com/vls/v1/";
    private $operations = array( 
            0 => array( "query" => "contracts?apiKey=%s" ),
            1 => array( "query" => "stations?apiKey=%s" ),
            2 => array( "query" => "stations/%d?contract=%s&apiKey=%s" ),
            3 => array( "query" => "stations?contract=%s&apiKey=%s" )
    );
    private $apiKey = false;
    
    function __construct( $apiKey )
    {
        $this->apiKey = $apiKey;
    }
    public function setApiKey( $key )
    {
        $this->apiKey = $key;
    }
    
    public function getApiKey()
    {
        return $this->apiKey;
    }
    
    public function getStationsByContract( $contract_name )
    {
        return $this->_query( sprintf( $this->operations[3]['query'], $contract_name, $this->apiKey ) );
    }
    
    public function getContracts()
    {
        $url = sprintf( $this->operations[0]['query'], $this->apiKey );
        return $this->_query( $url );
    }
    
    public function getStation( $contract_name, $station_id )
    {
        return $this->_query( sprintf( $this->operations[2]['query'],$station_id, $contract_name , $this->apiKey ) );
    }
    
    public function setHTTPClient( $client )
    {
        $this->HTTPClient = $client;
    }
    private function _query( $url )
    {
        return $this->HTTPClient->get( self::API_ENDPOINT . $url );
    }
}