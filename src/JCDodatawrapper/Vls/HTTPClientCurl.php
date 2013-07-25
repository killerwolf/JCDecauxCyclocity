<?php
namespace JCDodatawrapper\Vls;

class HTTPClientCurl implements Interfaces\HTTPClientInterface
{
    public function get( $url )
    {
        //$url = self::API_ENDPOINT . $url;
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