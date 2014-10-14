<?php

namespace Killerwolf\JCDecauxCyclocityBundle;

use Killerwolf\JCDecauxCyclocityBundle\Interfaces\HTTPClientInterface;

class HTTPClientCurl implements HTTPClientInterface
{
    public function get($url)
    {
        //$url = self::API_ENDPOINT . $url;
        // First try CURL
        if (extension_loaded('curl')) {
            $cch = curl_init($url);
            // Options used to perform in a similar way than PHP's fopen()
            curl_setopt_array(
                $cch,
                array(
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false
                )
            );

            // Getting data
            ob_start();
            if (!curl_exec($cch)) {
                curl_close($cch);
                ob_end_clean();
                return false;
            }

            curl_close($cch);
            $data = ob_get_contents();
            ob_end_clean();

            return json_decode($data);
        }

        // Open and read url
        $fid = fopen($url, 'r');
        if ($fid === false) {
            return false;
        }

        $data = "";
        do {
            $dataBody = fread($fid, 8192);
            if (0  == strlen($dataBody)) {
                break;
            }
            $data .= $dataBody;
        } while (true);

        fclose($fid);
        return json_decode($data);
    }
}
