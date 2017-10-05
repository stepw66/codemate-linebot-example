<?php

$access_token = '';

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

// Linebot API post JSON to here.
$content = file_get_contents('php://input');

$events = json_decode($content, true);

// We know what type of message that user send to us. 
// But now we just interested in text only

if (!is_null($events['events'])) {
	 
	foreach ($events['events'] as $event) {
		 
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			 
			$text = $event['message']['text'];
            
            // Linebot send replyToken to us for set responed message.  
			$replyToken = $event['replyToken'];

			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Post message back to Line Server.
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
            $post = json_encode($data);

            // AccessToken use here. 
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}

echo "OK";
