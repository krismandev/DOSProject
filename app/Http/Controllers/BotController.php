<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{




    public function sendMessage($pesan)
    {
        $BOT_TOKEN  = '5025114128:AAEQpSGt2sPS8199pzeSs0Vg5PheGygd1XI';
        $CHAT_ID ='1388645301';
        $pesan = json_encode($pesan);
        $API = "https://api.telegram.org/bot".$BOT_TOKEN."/sendmessage?chat_id=".$CHAT_ID."&text=$pesan";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, $API);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function hook()
    {
        $TOKEN = "5025114128:AAEQpSGt2sPS8199pzeSs0Vg5PheGygd1XI";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];

        if (strpos($message, "/start") === 0) {
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks dicoffeean.com.&parse_mode=HTML");
        }else{
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks dicoffeean.com.&parse_mode=HTML");

        }
    }
}
