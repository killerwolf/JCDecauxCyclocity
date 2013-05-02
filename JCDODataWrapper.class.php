<?php
class JCDODataWrapper{
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
    
    private function _query( $url )
    {
        $url = self::API_ENDPOINT . $url;
        // First try CURL
        if ( extension_loaded( 'curl' ) )
        {
            $ch = curl_init( $url );
            // Options used to perform in a similar way than PHP's fopen()
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false
                )
            );

            // Getting data
            ob_start();
            if ( !curl_exec( $ch ) )
            {
                curl_close( $ch );
                ob_end_clean();
                return false;
            }

            curl_close ( $ch );
            $data = ob_get_contents();
            ob_end_clean();

            return json_decode( $data );
        }

        // Open and read url
        $fid = fopen( $url, 'r' );
        if ( $fid === false )
        {
            return false;
        }

        $data = "";
        do
        {
            $dataBody = fread( $fid, 8192 );
            if ( strlen( $dataBody ) == 0 )
                break;
            $data .= $dataBody;
        } while( true );

        fclose( $fid );
        return json_decode( $data );
    }
}