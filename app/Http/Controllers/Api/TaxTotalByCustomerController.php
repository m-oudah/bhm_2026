<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaxTotalByCustomerController extends Controller
{
    public function getTaxTotalsByCustomer($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.3.3/IfmisService/Service1.svc/getTaxTotalsByCustomer/' . $id,
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
        //return $response;
        curl_close($curl);
        $data = substr($response, 1, -1);
        $data =   json_decode(json_decode($response), true);
        //add action to data returned
        for ($i = 0; $i < count($data); $i++) {
            // $data[$i]['action'] = '<a href="google.com/' . $id .'/' . $data[$i]['taxCode'] . '">Edit</a>';

            $data[$i]['action'] = '<a id="show_tax" data-id="' . $data[$i]['taxCode'] . '" data-customer="' . $id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_tax_model"><i class="fa-regular fa-eye"></i> التفاصيل</a>';
        }

        return $data;
    }

    public function getTaxesByCustomerNo($customer, $taxCode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.3.3/IfmisService/Service1.svc/getTaxesByCustomerNo/' . $customer,
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
        //return $response;
        curl_close($curl);
        $data = substr($response, 1, -1);
        $data =   json_decode($response, true);
        // return $data;
        $list = [];
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['TAX_CODE'] == $taxCode) {
                $list[] = $data[$i];
            }
        }
        return $list;
    }

    // public function getTaxesByCustomerNo($id)
    // {
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'http://192.168.3.3/IfmisService/Service1.svc/getTaxesByCustomerNo/' . $id,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'GET',
    //         CURLOPT_HTTPHEADER => array(
    //             'Accept: application/json'
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     //        return $response;
    //     curl_close($curl);
    //     //        $data = substr($response, 1, -1);
    //     $data =   json_decode($response, true);
    //     // return $data;
    //     return response()->json($data);
    // }
}
