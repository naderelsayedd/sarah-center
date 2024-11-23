<?php 

namespace Modules\Wallet\Http\Helper;
use Auth;
class WalletHelper
{

	static function getSessionId($data ='')
	{

        $environment = env('MYFATOORAH_ENVIRONMENT', 'apitest');
        $curl = curl_init();
        $url = 'https://'.$environment.'.myfatoorah.com/v2/InitiateSession';
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "SaveToken": false
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$data['ApiKey'],
            'Content-Type: application/json',
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);


	}


	static function makePayment($data = ''){
		$curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://apitest.myfatoorah.com/v2/ExecutePayment',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($data['paymentRequest']),
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. env('MYFATOORAH_API_KEY'),
                'Content-Type: application/json',
              ),
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);
            $responseData = json_decode($response, true);
            curl_close($curl);
            if (isset($responseData['IsSuccess']) && $responseData['IsSuccess'] === true) {  
            	$responseData['request'] = $data['paymentRequest'];          	
            	return $responseData;
            }else{
            	if ($error) {
            		return $error;
            	}
            	return false;
            }
           
	}

	static function ExecutePayment($data='')
    {
    	$api_key = env('MYFATOORAH_API_KEY');
        $api_secret = env('MYFATOORAH_API_SECRET');
        $environment = env('MYFATOORAH_ENVIRONMENT', 'apitest');

        $data = [
        	'PaymentMethodId' 	=> env('MYFATOORAH_EXECUTE_PAYMENT_ID'),
			"Amount" 			=> $data['amount'],
			"Currency" 			=> env('MYFATOORAH_CURRENCY_CODE'),
			"CustomerName" 		=>	Auth::user()->full_name,
			"CustomerEmail" 	=> Auth::user()->email,
			"CustomerMobile" 	=> Auth::user()->mobile_number,
            'InvoiceValue' 		=> $data['amount'],
            'PaymentType' 		=> 'card',
            "UserDefinedField"	=> "CK-123",
            "ProcessingDetails" => [
            	'Bypass3DS' 	=> 'false'
            ],
            "Card" => [
            	"Number" 		=> $data['card_number'],
				"ExpiryMonth" 	=> $data['expiry_month'],
				"ExpiryYear" 	=> $data['expiry_year'],
				"SecurityCode" 	=> $data['security_code'],
				"HolderName" 	=> $data['user_name']
            ]
        ];

        $headers = [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://' . $environment . '.myfatoorah.com/v2/ExecutePayment');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $payment_execution = json_decode($response, true);
        if ($payment_execution['IsSuccess'] == 1) {
        	self::DireactPayment($payment_execution,$data);
        }else{
        	// return false;
        }

    }


    static function DireactPayment($payment_execution,$pre_curl_data)
    {
  
        $api_key = env('MYFATOORAH_API_KEY');
        $api_secret = env('MYFATOORAH_API_SECRET');
        $environment = env('MYFATOORAH_ENVIRONMENT', 'apitest');

        $invoiceKey = $payment_execution['Data']['PaymentURL'];
        $paymentGatewayId = $payment_execution['Data']['PaymentURL'];

        // Extract the invoiceKey and paymentGatewayId from the PaymentURL
        $urlParts = parse_url($payment_execution['Data']['PaymentURL']);
        parse_str($urlParts['query'], $query);
        $invoiceKey = $query['invoiceKey'];
        $paymentGatewayId = $query['paymentGatewayId'];

        $data = [
            'InvoiceKey' => $invoiceKey,
            'PaymentGatewayId' => $paymentGatewayId,
            'Card' => $pre_curl_data['Card'],
            'Amount' => $pre_curl_data['Amount'],
            'Currency' => $pre_curl_data['Currency'],
            'CustomerName' => $pre_curl_data['CustomerName'],
            'CustomerEmail' => $pre_curl_data['CustomerEmail'],
            'CustomerMobile' => $pre_curl_data['CustomerMobile'],
            'InvoiceValue' => $pre_curl_data['InvoiceValue'],
            'PaymentType' => $pre_curl_data['PaymentType'],
            'UserDefinedField' => $pre_curl_data['UserDefinedField'],
            'ProcessingDetails' => $pre_curl_data['ProcessingDetails']
        ];


        $headers = [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json',
        ];



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://demo' . $environment . '.myfatoorah.com/v2/DirectPayment/'.$invoiceKey.'/'.$paymentGatewayId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $direct_payment_response = json_decode($response, true);

        echo "<pre>"; print_r($direct_payment_response);die;
        if ($error) {
            // handle error
            return back()->withErrors(['error' => $error]);
        }

        // Process the direct payment response
        // ...
    }

    static function exicutePaymentGpay($value='')
    {

            $environment = env('MYFATOORAH_ENVIRONMENT', 'apitest');
            $apiKey = "CfIpeEz3XUDvT-G3CDmSjhW2iO2IILZLUkaESyqSL744Npgeg-MEs7766PnXfetBnC7cmJb_a8Sen4XOdosxTxmdJfEnFMUFzEW8NJmT7ZbRM1SWqlFFRLgSAhpY4scSfiJsF0GMj1wB87PJowJL9ZvGCHGDjc7sStIpvCEOL-GOrJQxCeI3vvDjpxoSr2JkgV6fe6tbxjhvHXLEztpHiltv9MvTNrkrwnKMrSEB2nFAibNPzT2y7naGuC0WJJUY9etFTshdbvdXRb1kZymI135s71GlHmKcSgbrE2EnT7ve2cgwEMO9oA2ugsINpaXl7HsB4GEYamXD164Dm_JthRwM2kAqfb0NLXjQ0-Um01Iu8Z-yWW0BSw6z80sS2h-HROGAzBwkiVz90VHPcLY0cHSWBI1EC2ivblPuRLIcuNVdShp7of1eWq7pmxOCHfz-GJACtzdR8ne74nYr2Qu1UO6xWhJNxVSC4DPVgH57DHouROM1hVxSArtPmtC_VcNIAJjdCHVzaL_geHAfEaUY1YGEaDvu7sIsOoWn4Oa555jjUadS-tlaEZPC4OUSsAFV2K7Y-4gAmAar4liBF1dTddC28USyV_RFJHyKvyunSBkM2du6-0arGUxJ2SDRzg9UDfFgA-wnRnKzUgbUfbvdWasFjWw-yBBskyrzkBXSm5AWgoLr";
            $logData = array(
                'SessionId' => $value['data']['sessionId'],
                'InvoiceValue' => $value['data']['InvoiceValue']
            );
            $url = 'https://'.$environment.'.myfatoorah.com/v2/ExecutePayment';

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($logData),
              CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$apiKey
              ),
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);
            $responseData = json_decode($response, true);
            curl_close($curl);
            if (isset($responseData['IsSuccess']) && $responseData['IsSuccess'] == true) {  
                $responseData['request'] = $value['data'];             
                return $responseData;
            }else{
                if ($error) {
                    return $error;
                }
                return false;
            }

    }


}




