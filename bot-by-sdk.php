<?php
require_once('./vendor/autoload.php');

$access_token = '';
$secret_token = '';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $secret_token]);

/* Line text message structure.
 {
  "events": [
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
    },
    {
      "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
      "type": "follow",
      "timestamp": 1462629479859,
      "source": {
        "type": "user",
        "userId": "U206d25c2ea6bd87c17655609a1c37cb8"
      }
    }
  ]
}
*/

$content = file_get_contents('php://input');
$data = json_decode($content, true);

if (!is_null($data['events'])) {
    
    foreach($data['events'] as $event) {

      if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
        
        $replyToken = $event['replyToken'];
        
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('This message from bot');
        
        $response = $bot->replyMessage($replyToken, $textMessageBuilder);

      }
        
    }
}

echo 'OK';
