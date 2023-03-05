<?php


function fsdapikey_fetch_external_api_data($req) {

  $example_value = $req["exampleValue"];
  $test_mode = $req["testMode"];

  $data_encryption = new fsdapikey_Data_Encryption();
  $api_key = $data_encryption->decrypt(get_option( 'our_api_key' ));

  if(empty($api_key)){
    return new WP_Error( 'error', 'Please enter an API key in settings to use this feature', array( 'status' => 403 ) );
  }

  if($test_mode){
    $res = new WP_REST_Response("Your API key is: {$api_key}");
    $res->set_status(200);
  
    return $res;
  }

  $curl = curl_init();

  curl_setopt_array($curl, [
    // URL for example purposes only, this request will fail as-is even if API key valid - replace with your own request
    CURLOPT_URL => "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key={$api_key}&option={$example_value}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
  ]);
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  
  if ($err) {

    return new WP_Error( 'error', 'Invalid Request', array( 'status' => 404 ) );

  } else {

    $res = new WP_REST_Response($response);
    $res->set_status(200);
  
    return $res;
  }
}