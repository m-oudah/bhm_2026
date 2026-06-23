<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function getFileData($file_number)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'http://192.168.3.13/archive/public/getFileData/' . $file_number,
            CURLOPT_URL => 'http://152.53.237.131/archive/getFileData/' . $file_number,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
//        //return $response;
//        curl_close($curl);
//        $data = substr($response, 1, -1);
//        $data =   json_decode(json_decode($response), true);
//
        return $response;
    }

}
