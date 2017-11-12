<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// LINEBot 
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class RobotController extends Controller
{
    public function index() {

    	//Token
		$channel_token = 'tFjmP/fFD+ykyqTmymYgweAZBdHw2lQQFO2d3TY3rOn6Mxw15Z6AmV1xBz3KfL1EL1Lr/PYJXNyxGFG0Mtw78pz0/dqu7hoyA7OGk9NfYrD3GggXb3OgGezjLIknJQEZjf6xAGCY4/Z60lW0+inyzAdB04t89/1O/w1cDnyilFU=';
		$channel_secret = 'e4231788b61ba4311b188f1f8fc7d374';

		// Get message from Line API
		$content = file_get_contents('php://input');
		$events = json_decode($content, true);

		if(!is_null($events['events'])) {

			// Loop through each event
			foreach($events['events'] as $event) {



				// Line API send a lot of event type, we interested in message only
				if($event['type'] == 'message') {
					// Get replyToken
					$replyToken = $event['replyToken'];

					switch ($event['message']['type']) {
						case 'text':
							$respMessage = 'Hello, your message is ====> '. $event['message']['text'];
							$httpClient = new CurlHTTPClient($channel_token);
							$bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
							$TextMessageBuilder = new TextMessageBuilder($respMessage);
							$response = $bot->replyMessage($replyToken, $TextMessageBuilder);
							break;
					}
						
				}
			}
		}
    }


}
