<?php
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('KbQAojIxyVyVscXVmUhvrvvwhWdsxsT6lKcmGDaORsN0iiXthesiJx2dBTRx05DCYz6LiXscNEs0SrUsyuxkS5u0TaH5CuUWl8qf9MZp914Dh2caSIMkP7nLDk8bE7paFcK5C1N05RA1LerVg47uOAdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '30bbe3ecdfd9aa90dbc95dcafc62ef41']);

/* Line text message structure.
 {
  "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
  "type": "message",
  "timestamp": 1462629479859,
  "source": {
    "type": "user",
    "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
  },
  "message": {
    "id": "325708",
    "type": "text",
    "text": "Hello, world"
  }
}
*/

$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

    $replyToken = $event['replyToken'];
    
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('This message from bot');
    
    $response = $bot->replyMessage($replyToken, $textMessageBuilder);
    if ($response->isSucceeded()) {
        return;
    }
    
    // Failed
    //echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}

echo 'OK';
