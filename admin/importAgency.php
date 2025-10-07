<?php
ob_start();
include('../common.php');
include('IsLogin.php');
$connect = new connect();

if ($_POST['action'] == 'importAgency') {
    $service_url='https://astutemanagement.co.in/herocollections/Employee/getAgency.php';
    $hashKey='astuteCRM';
    $user=$_SESSION['AdminName'];
    $randomPSW=mt_rand();
    $hash_string=$user.'|'.$randomPSW.'|'.$hashKey;
    $strHash=strtolower(hash('sha512', $hash_string));
  
    $curl = curl_init($service_url);
    
    $curl_post_data = array("hashKey" => $hashKey,"user"=>$user,"randNumber"=>$randomPSW,"hash"=>$strHash);
    
    $data_string =  json_encode(array("data" => $curl_post_data));
   
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0 );
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    
    $curl_response = curl_exec($curl);
    
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
       
        curl_close($curl);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $res_array=json_decode($curl_response,true);
    if(count($res_array)>0){
        $deleteAgency=$connect->deleterecord($dbconn,"agency");
        if ($res_array['success']==1) {
            foreach ($res_array['agecnylist']  as $key=>$value) {               
                    
                $strdata="insert into agency values('".implode('\',\'',$value)."')";
                $resInsert=mysqli_query($dbconn,$strdata);

            }
            echo '1';
        }else{
            echo '0';
        }
    }else{
        echo '0';
    }
    
    
}else{
 echo '0'   ;
}
?>
