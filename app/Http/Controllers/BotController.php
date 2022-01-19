<?php

namespace App\Http\Controllers;

use CURLFile;
use Illuminate\Http\Request;

class BotController extends Controller
{




    public function sendMessage($pesan)
    {
        // $BOT_TOKEN  = '5025114128:AAEQpSGt2sPS8199pzeSs0Vg5PheGygd1XI';
        // $CHAT_ID ='-546571972';
        // $query = [
        //     'text' =>"<b>Halo</b> \n Oke",
        //     'chat_id' => $CHAT_ID,
        //     "parse_mode"=>"HTML"
        // ];
        // $API = "https://api.telegram.org/bot".$BOT_TOKEN."/sendmessage?".http_build_query($query);
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($ch, CURLOPT_URL, $API);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // return $result;


        $BOT_TOKEN  = '5025114128:AAEQpSGt2sPS8199pzeSs0Vg5PheGygd1XI';
        $CHAT_ID ='-546571972';
        $query = [
            'photo'     => "https://doswiteljambi.com/public/storage/foto_dos/16fa893e-fcee-4d30-a7e0-d9964c7e0a84_1642562217.png",
            'chat_id' => $CHAT_ID,
            'caption' => "test"
        ];



        $post_fields = array(
            'chat_id'   => $CHAT_ID,
            'photo'     => new CURLFile(realpath("storage/foto_dos/85f60782-4ae2-4595-8d71-110982a30eb0_1638430232.jpg")),
            'caption' => 'okee'
        );

        $API = "https://api.telegram.org/bot".$BOT_TOKEN."/sendPhoto?chat_id=".$CHAT_ID;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $API);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
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

        if (strpos($message, "/start") == 0) {
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks dicoffeean.com.&parse_mode=HTML");
        }else{
            file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks dicoffeean.com.&parse_mode=HTML");

        }
    }
}
