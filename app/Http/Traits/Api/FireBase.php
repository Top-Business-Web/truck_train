<?php
namespace App\Http\Traits\Api;
use App\Models\FirebaseToken;

trait FireBase{

    public $serverToken = 'AAAAkE0SKTs:APA91bGkmewO9BdS7JPaReQFZ2MF5dg_Vd8PmED4U5r3Ve6z_tDmTLC9aulND92PVkMSoiEpECXNLkVBLPAwBSlR79eEeDCgGilSwEFB_LV9Ci4vbGea1pwbqJrDPq6vAovTBU74oJlK';

    private function sendGCM($tokens, $data)
    {
        $headers = [
            'Authorization: key='.$this->serverToken,
            "Content-Type: application/json"
        ];
        // ------------- recieve $token , $message -------------
        $fields = ['registration_ids' => $tokens, 'data' => $data];
        // ---------------------------- CURL ---------------------------------
        $url = 'https://fcm.googleapis.com/fcm/send';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function sendGCMIOS($tokens, $msg, $not, $sound = "default")
    {
        // API access key from Google API's Console
        // prep the bundle
        $not['sound'] = $sound;
        $fields = ['registration_ids' => $tokens, 'sound' => $sound, 'notification' => $not, 'data' => $msg];
        $headers = [
            'Authorization: key='.$this->serverToken,
            "Content-Type: application/json"
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result ;
    }

    private function sendNote($tokens, $tokensIOS, $msg, $not, $sound = "default")
    {
        $not_android = "no android tokens ";
        $not_ios = "no ios tokens ";
        if (!empty($tokens)) {
            $not_android = $this->sendGCM($tokens, $msg);
        }
        if (!empty($tokensIOS)) {
            $not_ios = $this->sendGCMIOS($tokensIOS, $msg, $not, $sound);
        }
        return ["android" => $not_android, "ios" => $not_ios, "data" => $msg, "notification" => $not];
    }

    public  function getFireBaseTokens($whereIn){
        $data["androind"] = FirebaseToken::whereIn('user_id', $whereIn)->where('software_type', 'android')->pluck('phone_token')->toArray();
        $data["ios"] = FirebaseToken::whereIn('user_id', $whereIn)->where('software_type','ios')->pluck('phone_token')->toArray();
        return $data ;
    }

    /*public function sendRoomNotification($roomMsg, $to_user_id = [], $room = [])
    {
        $allTokens = $this->getFireBaseTokens($to_user_id);
        $Androind =  $allTokens['androind'];
        $Ios =  $allTokens['ios'];
        $msg = [];
        $not["title"] = (isset($roomMsg->user_data->name))? $roomMsg->user_data->name:"رسالة جديدة";
        $not['body'] = (isset($roomMsg->message))? $roomMsg->message:'رسالة جديدة';
        return $this->sendNote($Androind , $Ios , $msg , $not);
    }*/

    /*
     * ================================================================================================
     *
     *
     * ================================================================================================
     */
    public function sendNotificatios($to_user_ids,$note,$type){
        $allTokens = $this->getFireBaseTokens($to_user_ids);
        $Androind =  $allTokens['androind'];
        $Ios =  $allTokens['ios'];
        $data = $note;
        $data["noti_type"] = $type ;
        $data["to_user_ids"] = json_encode($to_user_ids);
        $notification["title"] = $data["title"];
        $notification['body'] = $data['message'];
        return $this->sendNote($Androind , $Ios , $data , $notification);
    }

      /*
     * ================================================================================================
     *
     *
     * ================================================================================================
     */

     public function confirmUser($to_user_ids, $notification){
         $allTokens = $this->getFireBaseTokens($to_user_ids);
          $Androind =  $allTokens['androind'];
          $Ios =  $allTokens['ios'];
          //$data["noti_type"] = 'confirm' ;
          //$data["to_user_ids"] = json_encode($to_user_ids);
        $response_android = $this->sendGCMIOS($Androind, $notification , $notification, $sound = "default");
        $response_ios     = $this->sendGCMIOS($Ios, $notification , $notification, $sound = "default");

        return [ "ad"=>$response_android,"io"=> $response_ios];

     }




}
