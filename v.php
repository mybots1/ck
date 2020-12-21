<?php
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot1461445115:AAGac3RSbwwZ0Uc1n0CHSTZSwgfValjvPUM/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res,true);
}
function getupdates($up_id){
  $get = bot('getupdates',[
    'offset'=>$up_id
  ]);
  return end($get['result']);

}

function run($update){
$message = $update['message'];
$chat_id = $message['chat']['id'];
$text = $message['text'];
$name = $message['from']['first_name'];
$username = $message['chat']['username'];
$from_id = $message['from']['id'];
$userID = $message['from']['id'];
$admin = 280911803;
$chat_id2 = $update['callback_query']['message']['chat']['id'];
$message_id = $update['callback_query']['message']['message_id'];
$data = $update['callback_query']['data'];
$mid = $message['message_id'];
$get_ids = file_get_contents('memb.txt');
$ids = explode("\n", $get_ids);
$c = count($ids)-1;
$modxe = file_get_contents("usr.txt");
$bot ="@Ydl20bot";


if($text == '/start'){
	bot('sendMessage',[
			'chat_id'=>$chat_id,
			'text'=>"~ 𝗪𝗲𝗹𝗰𝗼𝗺𝗲 $name

~ 𝗜 𝗰𝗮𝗻 𝗗𝗼𝘄𝗻𝗹𝗼𝗮𝗱 𝗩𝗶𝗱𝗲𝗼/𝗔𝘂𝗱𝗶𝗼 𝗳𝗿𝗼𝗺 𝗬𝗼𝘂𝗧𝘂𝗯𝗲 𝗮𝗻𝗱 𝘂𝗽𝗹𝗼𝗮𝗱 𝘁𝗵𝗲𝗺 𝘁𝗼 𝗧𝗲𝗹𝗲𝗴𝗿𝗮𝗺",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
          [['text'=>'📡 𝗖𝗵𝗮𝗻𝗻𝗲𝗹 ~','url'=>'https://t.me/rambo_syr']],
[["text"=>"⚙ 𝗛𝗼𝘄 𝘁𝗼 𝘂𝘀",'callback_data'=>'help']]
			]	
				])		
	]);
if ($update && !in_array($chat_id, $ids)) {
    file_put_contents("memb.txt", $chat_id."\n",FILE_APPEND);
  }
}
if($data == 'help'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"⚙️ How to use ?


➡️ Send me a text message ( search query ) and i will show the most relevant results from Youtube. 

 OR 

➡️ Send me a valid Youtube link.",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'• رجوع - Back','callback_data'=>'rami']]    
]    
])
]);
}
if($data == 'rami'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id,
'text'=>"~ 𝗪𝗲𝗹𝗰𝗼𝗺𝗲 $name

~ 𝗜 𝗰𝗮𝗻 𝗗𝗼𝘄𝗻𝗹𝗼𝗮𝗱 𝗩𝗶𝗱𝗲𝗼/𝗔𝘂𝗱𝗶𝗼 𝗳𝗿𝗼𝗺 𝗬𝗼𝘂𝗧𝘂𝗯𝗲 𝗮𝗻𝗱 𝘂𝗽𝗹𝗼𝗮𝗱 𝘁𝗵𝗲𝗺 𝘁𝗼 𝗧𝗲𝗹𝗲𝗴𝗿𝗮𝗺",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,
'parse_mode'=>'Markdown',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'📡 𝗖𝗵𝗮𝗻𝗻𝗲𝗹 ~','url'=>'https://t.me/rambo_syr']],
[["text"=>"⚙ 𝗛𝗼𝘄 𝘁𝗼 𝘂𝘀",'callback_data'=>'help']]
]
])
]);
}
if(preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $text, $matches)){
	
	$s = shell_exec('youtube-dl "'.$text.'" --id --write-info-json --no-progress -f mp4');
	if(file_exists("{$matches[1]}.mp4")){
		$info = json_decode(file_get_contents("{$matches[1]}.info.json"));
		bot('sendPhoto',[
				'chat_id'=>$chat_id,
				'photo'=>$info->thumbnail,
				'caption'=>"- 𝑽𝒊𝒅𝒆𝒐 𝑵𝒂𝒎𝒆 ➢ {$info->title}",
				'reply_markup'=>json_encode([
					'inline_keyboard'=>[
						[['text'=>'🎥 𝗩𝗶𝗱𝗲𝗼','callback_data'=>'vi^'.$matches[1]]],
						[['text'=>'🎧 𝗔𝘂𝗱𝗶𝗼 𝗙𝗶𝗹𝗲 𝗠𝗣3','callback_data'=>'au^'.$matches[1]]]
						]	
				])		
		]);
	} else {
		bot('sendMessage',[
			'chat_id'=>$chat_id,
			'text'=>' I can not download this video'
		]);
	}
} elseif($text != null and $text != '/start' and '/help') {
	$items = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q=".urlencode($text)."&type=video&key=AIzaSyCxJD2YxpZEAsTgX3RJ5FiNbT7keJ0udtY&maxResults=7"))->items;
	foreach($items as $item){
		$rep['inline_keyboard'][] = [['text'=>$item->snippet->title,'callback_data'=>'ph^'.$item->id->videoId]];
	}
	bot('sendMessage',['chat_id'=>$chat_id,'text'=>'search result 💡',
		'reply_markup'=>(json_encode($rep))]);
	}

if($data != null){
	$edata = explode('^', $data);
	if($edata[0] == 'ph'){
		$s = shell_exec('youtube-dl "'.$edata[1].'" --id --write-info-json --no-progress -f mp4');
	if(file_exists("{$edata[1]}.mp4")){
		$info = json_decode(file_get_contents("{$edata[1]}.info.json"));
		bot('sendPhoto',[
				'chat_id'=>$chat_id2,
				'photo'=>$info->thumbnail,
				'caption'=>"- 𝑽𝒊𝒅𝒆𝒐 𝑵𝒂𝒎𝒆 ➢ {$info->title}",
				'reply_markup'=>json_encode([
					'inline_keyboard'=>[
						[['text'=>'🎥 𝗩𝗶𝗱𝗲𝗼','callback_data'=>'vi^'.$edata[1]]],
						[['text'=>'🎧 𝗔𝘂𝗱𝗶𝗼 𝗙𝗶𝗹𝗲 𝗠𝗣3','callback_data'=>'au^'.$edata[1]]]
						]	
				])		
		]);
	}
	}
	if($edata[0] == 'vi'){
		if(file_exists($edata[1].'.mp4')){
			if(filesize($edata[1].'.mp4') <= 32505856){
				bot('deleteMessage',[
					'chat_id'=>$chat_id2,
					'message_id'=>$message_id
				]);
				$m = bot('sendMessage',[
					'chat_id'=>$chat_id2,
					'text'=>'Please wait a few seconds to download...'
				])['result']['message_id'];
				
				$ok = bot('sendVideo',[
					'chat_id'=>$chat_id2,
					'video'=>new CURLFile($edata[1].'.mp4')
				])['ok'];
				if($ok == true){
					bot('deleteMessage',[
						'chat_id'=>$chat_id2,
						'message_id'=>$m
					]);
				} else {
					bot('deleteMessage',[
						'chat_id'=>$chat_id2,
						'message_id'=>$m
					]);
					bot('sendMessage',[
						'chat_id'=>$chat_id2,
						'text'=>' I can not download this video'
					]);
				}
				unlink($edata[1].'.mp4');
				unlink($edata[1].'.info.json');
			} else {
				bot('sendMessage',[
						'chat_id'=>$chat_id,
						'text'=>' I can not download this video'
					]);
					unlink($edata[1].'.mp4');
				unlink($edata[1].'.info.json');
			}
		} else {
			bot('sendMessage',[
			'chat_id'=>$chat_id2,
			'text'=>'I can not download this video please Send me a different link'
		]);
		}
	} elseif($edata[0] == 'au'){
		if(file_exists($edata[1].'.mp4')){
				bot('deleteMessage',[
					'chat_id'=>$chat_id2,
					'message_id'=>$message_id
				]);
				$m = bot('sendMessage',[
					'chat_id'=>$chat_id2,
					'text'=>'Please wait a few seconds to download.'
				])->result->message_id;
				$mp = str_replace('-', '', $edata[1]);
				rename($edata[1].'.mp4',str_replace('-', '', $edata[1].'.mp4'));
				$s = shell_exec('ffmpeg -i "'.$mp.'.mp4" "'.$mp.'.mp3"');
				if(file_exists($mp.'.mp3')){
					$info = json_decode(file_get_contents("{$edata[1]}.info.json"));
					$ok = bot('sendaudio',[
						'chat_id'=>$chat_id2,
						'audio'=>new CURLFile($mp.'.mp3'),
						'title'=>$info->title,
						'performer'=>$info->creator.' - '.$bot,
						'duration'=>$info->duration,
						'thumb'=>$info->thumbnail,
			'caption'=>"$bot - ".sprintf("%4.2f MB", filesize($mp.'.mp3')/1048576).' , '.gmdate('i:s',$info->duration)
					]);
					if($ok['ok'] == true){
						bot('deleteMessage',[
							'chat_id'=>$chat_id2,
							'message_id'=>$m
						]);
					} else {
						bot('deleteMessage',[
							'chat_id'=>$chat_id2,
							'message_id'=>$m
						]);
						bot('sendMessage',[
							'chat_id'=>$chat_id2,
							'text'=>' I can not download this video'.$ok['description']
						]);
					}
				}else {
						bot('deleteMessage',[
							'chat_id'=>$chat_id2,
							'message_id'=>$m
						]);
						bot('sendMessage',[
							'chat_id'=>$chat_id2,
							'text'=>' I can not download this video'
						]);
					}
				unlink($mp.'.mp4');
				unlink($mp.'.mp3');
				unlink($mp.'.info.json');
			
		} else {
			bot('sendMessage',[
			'chat_id'=>$chat_id2,
			'text'=>'I can not download this video please Send me a different link'
		]);
		}
	}
}
if ($text == "/admin" and $chat_id == $admin ) {
    bot('sendMessage',[
        'chat_id'=>$chat_id,
      'text'=>"
☑️￤اهلا عزيزي :- المطور .
▫️￤اليك الاوامر الان حدد ماتريده 📩
-
عدد مشتركين البوت📢 :- [ $c ]
/send - للاذاعه",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,

]);
}
if($text == "/send"){ 
    file_put_contents("usr.txt","yas");
        bot('sendMessage',[
        'chat_id'=>$chat_id,
      'text'=>"▪️ ارسل رسالتك الان 📩 وسيتم نشرها لـ [ $c ] مشترك . 
   - /cn - للالغاء",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,

]);
    
}
if($text == "/cn" and $modxe == "yas" and $chat_id == $admin ){
    bot('sendMessage',[
        'chat_id'=>$chat_id,
      'text'=>"تمالالغاء",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,

]);

file_put_contents("usr.txt","no");
} 
if($text != "/cn" and $modxe == "yas" and $chat_id == $admin ){
    for ($i=0; $i < count($ids); $i++) { 
        bot('sendMessage',[
          'chat_id'=>$ids[$i],
          'text'=>"$text",
'parse_mode'=>"MarkDown",
'disable_web_page_preview'=>true,

]);
    

} 
file_put_contents("usr.txt","no");
} 


$name = $message['from']['first_name'];
$username = $update['message']['from']['username'];

$t =$message['chat']['title']; 
$user = $username; 
if($text == "/start") {
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"
 ",
'reply_to_message_id'=>$message['message_id'],
]);
bot('sendMessage',[
'chat_id'=>$admin,
'text'=>"
  ٭ تم دخول شخص الى البوت الخاص بك 🔰؛

• معلومات العضو ، 👋🏻.

• الاسم ؛ $name ،

• المعرف ؛ @$username ،

• الايدي ؛ $from_id ،

• اليوم ؛ " . date("j") . "\n" . " 



",
]);
}


}

while(true){
  $last_up = $last_up??0;
  $get_up = getupdates($last_up+1);
  $last_up = $get_up['update_id'];
  run($get_up);
  sleep(0);
}
