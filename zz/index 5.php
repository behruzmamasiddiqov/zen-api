<?php

define('API_KEY', "7993106687:AAGd86JOS8u57dd_FanW7U8RxE7-r1Gkcks"); 

$admin = "7982529856";
$kanal = "7982529856";

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}


function top($chatid){
    $text = "🏆 <b>Chatdagi TOP 10 ta eng farosatli insonlar 🧠:</b>\n\n";
    $files = glob("new/$chatid/*.txt");
    $data = [];

    foreach ($files as $user) {
        $id = str_replace(["new/$chatid/", ".txt"], ["",""], $user);
        $data[$id] = (int)file_get_contents($user);
    }

    arsort($data);
    $i = 1;

    foreach ($data as $id => $pul) {
        if ($i > 10) break;

        $us = bot('getChatMember', [
            'chat_id' => $chatid,
            'user_id' => $id,
        ]);

        $res = $us->result->user->first_name ?? "No Name";

        // Ismni 20 belgiga cheklash
        if (mb_strlen($res) > 20) {
            $res = mb_substr($res, 0, 17) . "...";
        }

        // HTML uchun xavfsizlashtirish
        $res = htmlspecialchars($res);

        $text .= "<b>$i | </b>$res<b> - $pul gram</b>\n";
        $i++;
    }

    return $text;
}



function top30($chatid){
    $text = "🏆 <b>Chatdagi TOP 30 ta farosat reytingi 🧠:</b>\n\n";
    $files = glob("new/$chatid/*.txt");
    $data = [];

    foreach ($files as $user) {
        $id = str_replace(["new/$chatid/", ".txt"], ["",""], $user);
        $data[$id] = (int)file_get_contents($user);
    }

    arsort($data);
    $i = 1;

    foreach ($data as $id => $pul) {
        if ($i > 30) break;

        $us = bot('getChatMember', [
            'chat_id' => $chatid,
            'user_id' => $id,
        ]);

        $res = $us->result->user->first_name ?? 'No Name';

        // Nomi 20 belgidan oshsa, qisqartirish
        if (mb_strlen($res) > 20) {
            $res = mb_substr($res, 0, 17) . "...";
        }

        $text .= "<b>$i | </b>" . htmlspecialchars($res) . "<b> - $pul gram</b>\n";
        $i++;
    }

    return $text;
}


$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$capt = $message->caption;
$reply = $message->reply_to_message;
$rfid = $reply->from->id;
$rfname = $reply->from->first_name;
$rmid = $reply->message_id;
$rcid = $reply->chat->id;
$cid = $message->chat->id;
$tx = $message->text;
$text = $message->text;
$name = $message->from->first_name;
$username = $message->from->username;
$guruser = $update->message->chat->username;
$fid = $message->from->id;
$botname = bot('getme',['bot'])->result->username;
$botid = bot('getme',['bot'])->result->id;
$callback = $update->callback_query;
$imid = $callback->inline_message_id;
$data = $callback->data;
$query = $update->inline_query->query;
$inlineid = $update->inline_query->from->id;
$ccid = $callback->message->chat->id;
$cmid = $callback->message->message_id;
$name2 = $callback->from->first_name;
$username2 = $callback->from->username;
$fid2 = $update->callback_query->from->id;
$cty = $message->chat->type;
$soat = date("H:i:s",strtotime("2 hour")); 
$sana = date("d-M Y",strtotime("2 hour"));
$mid = $message->message_id;
$mid3 = $update->callback_query->inline_message_id;
$new = $message->new_chat_member;
$newid = $new->id;
$is_bot = $new->is_bot;
$newlng = $new->language_code;
$lng = $message->from->language_code;
$left = $message->left_chat_member;
$leftid = $left->id;
$title = $message->chat->title;
$elita = file_get_contents("elita/$cid/$fid.txt");
$bosq = file_get_contents("new/$cid/$fid.txt");
$bosq2 = file_get_contents("new/$ccid/$fid2.txt");
$vaqt = file_get_contents("vaqt/$cid/$fid.vaqt");
$adstep = file_get_contents("admin.step");
$sertif = file_get_contents("new/$cid/$fid.sertif");
$uahu = file_get_contents("new/$cid/$fid.txt");
mkdir("new");
mkdir("vaqt");
mkdir("elita");
if($cty == "group" or $cty == "supergroup"){
mkdir("new/$cid");
mkdir("vaqt/$cid");
mkdir("elita/$cid");
}


if($new !== NULL){
  if($newid == $botid){
    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"<b>Hello, azizlarim!🧑🏾‍🚀🙌 Men keldim! - Guruhdagi eng farosatlilarni aniqlab bergani keldim.🤵🏼 \n🔦 Batafsil: /help</b>",
        'parse_mode'=>"html",
    ]);
    bot('sendMessage',[
        'chat_id'=>$kanal,
        'text'=>"⚠️Yangi guruh☢ 
👥 Guruh nomi: n<b>$title</b> 
🔍 Guruhni topish: n@$guruser 
🆔️ Guruh idsi: n$cid",
       'parse_mode'=>'html',
 ]);
  }
}


function worldtop($chatid) {
    $text = "🌎 <b>Dunyodagi TOP-7 farosatlilar 🧠:</b>\n\n";
    $files = glob("new/*/*.txt"); 
    $data = [];

    foreach ($files as $file) {
        $id = basename($file, ".txt");
        $content = trim(file_get_contents($file));
        
        // ID raqam ekanligini tekshirish
        if (is_numeric($id) && is_numeric($content)) {
            $data[$id] = intval($content);
        }
    }

    arsort($data);
    $top7 = array_slice($data, 0, 7, true);
    $i = 1;

    foreach ($top7 as $id => $score) {
        $response = bot('getChatMember', [
            'chat_id' => $chatid,
            'user_id' => $id,
        ]);

        // getChatMember tekshirish
        if (!empty($response->ok) && isset($response->result->user)) {
            $user = $response->result->user;
            $username = isset($user->first_name) ? htmlspecialchars($user->first_name) : "Ismi noma'lum";
        } else {
            $username = "Ismi noma'lum";
        }

        $text .= "<b>$i.</b> $username <b>- $score gram</b>\n";
        $i++;
    }

    return $text;
} 

if(isset($message)){
if($elita == null){
	if($elita != "yoq"){
	if($cty == "group" or $cty == "supergroup"){
file_put_contents("elita/$cid/$fid.txt",'yoq');
}
}
}
}



if(isset($message)){
if($cid==$fid){
    $user = file_get_contents("usid.txt");
    if(mb_stripos($user,$fid) !==false){
    }else{
    $txt="\n$fid";
    $file=fopen("usid.txt","a");
    fwrite($file,$txt);
    fclose($file);
    }
 }
 }
 
 if(isset($message)){
 if($cty == "group" or $cty == "supergroup"){
    $gr = file_get_contents("grid.txt");
    if(mb_stripos($gr,$cid) !==false){
    }else{
    $txt="\n$cid";
    $file=fopen("grid.txt","a");
    fwrite($file,$txt);
    fclose($file);
    }
 }
 }


 


if($text == "/pic_farosat" or $text == "/pic_farosat@FarosatGramBot"){
 if($cty == "group" or $cty == "supergroup"){
if($bosq >= "100" && $bosq <= 499){
bot('sendPhoto',[
'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'photo'=>"http://m4960.myxvest.ru/Api/Farosat/index.php?value=$bosq&currency=gram",
'caption'=>"<a href='tg://user?id=$fid'>$name</a> \n🧠 Sizning farosatingiz: $bosq gram

🚀 Keyingi manzil - <tg-spoiler><b>sir! </b>👨🏾‍🚀</tg-spoiler>",
'parse_mode'=>'html',
]);
}elseif($bosq >= "500" && $bosq <= 2399){
bot('sendPhoto',[
'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'photo'=>"http://m4960.myxvest.ru/Api/Solar/image_generator.php?value=$bosq&currency=gram",
'caption'=>"<b>QUYOSH SISTEMASI ☀️🪐🌎</b>

<a href='tg://user?id=$fid'>$name</a> \n🧠 Frosatingiz: $bosq gram

<tg-spoiler><b>- Bundan keyin Somon yo'li. Birinchi bo'lib Somon yo'lini bosib olsangiz sizga katta Sovg'amiz bor!</b></tg-spoiler> 🌠☄️",
'parse_mode'=>'html',
]);
}else{
    bot('sendPhoto',[
'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'photo'=>"http://m4960.myxvest.ru/Api/Farosatuz/ndex.php?value=$bosq&currency=gram",
'caption'=>"<a href='tg://user?id=$fid'>$name</a> \n🧠 Sizning farosatingiz: <b>$bosq GRAM</b>

- Hozircha O'zbekistonni egallamoqdasiz, <tg-spoiler>100</tg-spoiler> gramdan keyin Yer shari! 🙂‍↔️🚀",
'parse_mode'=>'html',
]);
exit();
}
}
}


 

if ($tx == "/start" or $tx == "/start@FarosatGramBot"){
    bot('sendMessage',[
    'reply_to_message_id'=>$mid,
    'chat_id' => $cid,
    'text' => " - Hello, <b>$name</b>! 🖖  
👨🏾‍🍳 Men gruhlar uchun Farosatchi.\n
Savollar bo`lsa: /help komandasini yozing!",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"➕ Guruhga qo'shish",'url'=>"https://t.me/$botname?startgroup=new"]],
    ]
        ])
    ]);
}


if($text == "/help" or $text == "/help@FarosatGramBot"){
	bot('sendMessage',[
	   'reply_to_message_id'=>$mid,
	'chat_id'=>$cid,
	'text'=>"<b>🎗️ Botning komandalari:</b>
	
<b>/farosat - Farosatni o'stirish 🧠
/buy - Farosat sotib olish 🤝
/top_farosat - Chat Top-10 🏆
/top30 - Chat Top-30 🎗
/worldtop - Dunyodagi Top-7 🌍
/elita - Elita/Elite+ darajaga ⭐️
/pic_farosat - Rasmda Farosat 🌠️</b>",
'parse_mode'=>'html',
]);
}


if($text == "/elita" or $text == "/elita@FarosatGramBot"){
   if($elita == "elitaplus"){
    bot('sendMessage',[
     'reply_to_message_id'=>$mid,
       'chat_id'=>$cid,
        'text'=>"<b><a href='tg://user?id=$fid'>$name</a>, Siz eng tez o'sayotgan farosatlilardansiz \nBu levelda siz /farosat buyrug'i uchun 26-30 gram bemalol farosat yig'asiz!</b>",
        'parse_mode'=>'html',
        ]);
        }
        }
        
        if($text == "/elita"){
   if($fid==$cid){
    bot('sendMessage',[
     'reply_to_message_id'=>$mid,
       'chat_id'=>$cid,
        'text'=>"<b>Bu faqat chat uchun</b>",
        'parse_mode'=>'html',
        ]);
        }
        }

if($text == "/elita" or $text == "/elita@FarosatGramBot"){
   if($elita == "elita"){
if($bosq>="600"){
    bot('sendMessage',[
     'reply_to_message_id'=>$mid,
       'chat_id'=>$cid,
        'text'=>"<b> <a href='tg://user?id=$fid'>$name</a>, Siz Elita darajadasiz, Elita Plus ga o'tishing mumkin!</b>\nElite Plusga o'tib yanada tez o'sasiz! 🦷",
        'parse_mode'=>'html',
      'reply_markup'=>json_encode([
        'inline_keyboard'=>[
[['text'=>"✅ Elita Plus",'callback_data'=>"elitaplus-$fid"]]
]
])
    ]);
}else{
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
       'chat_id'=>$cid,
        'text'=>"<a href='tg://user?id=$fid'>$name</a>, \n - Brodar, siz Elita dasiz, ammo Elita Plus ga o'tgani farosatingiz kam. 600 gram kerak! 😓",
        'parse_mode'=>'html',
        ]);
        exit();
        }
}
}

if($text == "/elita" or $text == "/elita@FarosatGramBot"){
 if($elita == "yoq"){
 if($bosq>="300"){
    bot('sendMessage',[
     'reply_to_message_id'=>$mid,
       'chat_id'=>$cid,
        'text'=>"<b> <a href='tg://user?id=$fid'>$name</a>, Siz Elita ga o'tishing mumkin. Gazini bosing!</b>",
        'parse_mode'=>'html',
      'reply_markup'=>json_encode([
        'inline_keyboard'=>[
[['text'=>"✔️ Elita",'callback_data'=>"elita-$fid"]]
]
])
    ]);
}else{
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
       'chat_id'=>$cid,
        'text'=>"<a href='tg://user?id=$fid'>$name</a>, \n - Siz Elita ga o'tolmaysiz. O'tish uchun 300 gram farosat kerak. Ungacha farosat yig'ing! 🙂‍↕️",
        'parse_mode'=>'html',
        ]);
        exit();
        }
}
}

if(mb_stripos($data, "elita-") !== false){
$id = explode("-", $data)[1];
if($id==$fid2){
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"🙂‍↔️ Yaxshilab o'qing! ‼️",
'show_alert'=>true,
]);
  bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>Elitaga o'tish narxi 300 gram farosat. \nLekin sizga /faroaat buyrug'i uchun 16-20 gram farosat beriladi. \nElita o'tish uchun bosing, brodar. 😀👇</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
        'inline_keyboard'=>[
[['text'=>"👊 Elitega o'taman",'callback_data'=>"tastiq-$fid2"]],
[['text'=>"❌ Bekor qilish",'callback_data'=>"tabek-$fid2"]]
]
])
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"Xurmatli farosatli inson! Bu tugma siz uchun emas! 😾 ",
'show_alert'=>true,
]);
}
}

if(mb_stripos($data, "tabek-") !== false){
$id = explode("-", $data)[1];
if($id==$fid2){
  bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>Bekor qilindi</b>",
'parse_mode'=>'html',
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"Xurmatli farosatli inson! Bu tugma siz uchun emas! 😾",
'show_alert'=>true,
]);
}
}


if(mb_stripos($data, "tastiq-") !== false){
$id = explode("-", $data)[1];
if($id==$fid2){
	if($elita != "elita"){
	file_put_contents("elita/$ccid/$fid2.txt","elita");
	$chy = file_get_contents("new/$ccid/$fid2.txt");
  $g = $chy - 300;
  file_put_contents("new/$ccid/$fid2.txt","$g");
  bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"😺 Yuu-huu, Bu dunyoda farosati tez o'sadigan yana 1 inson paydo bo'ldi. Marhamat! - /farosat",
'parse_mode'=>'html',
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"Xurmatli farosatli inson! Bu tugma siz uchun emas! 😾",
'show_alert'=>true,
]);
}
}
}


if(mb_stripos($data, "elitaplus-") !== false){
$id = explode("-", $data)[1];
if($id==$fid2){
  bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>Elita Plusga o'tish 600 gram farosat talab qiladi. \nLekin /farosat buyrug'i uchun 26-30 gram farosatga ega bo'lasiz. \nIshonchingiz komil bo'lsa BOSING! 🫡👇</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
        'inline_keyboard'=>[
[['text'=>"👊👊🏿 Elite Plusga o'taman",'callback_data'=>"tastiqplus-$fid2"]],
[['text'=>"❌ Bekor qilish",'callback_data'=>"tabek-$fid2"]]
]
])
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"Xurmatli farosatli inson! Bu tugma siz uchun emas! 😾",
'show_alert'=>true,
]);
exit();
}
}


if(mb_stripos($data, "tastiqplus-") !== false){
$id = explode("-", $data)[1];
if($id==$fid2){
	if($elita != "elitaplus"){
	file_put_contents("elita/$ccid/$fid2.txt","elitaplus");
	$chy = file_get_contents("new/$ccid/$fid2.txt");
  $g = $chy - 600;
  file_put_contents("new/$ccid/$fid2.txt","$g");
  bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"Yes, Yess, Yeeeeeeeeeees!😃 Farosati juda tez o'sadigan geniylar qatori yana bittaga oshdi! Marhamat, janob! - /farosat",
'parse_mode'=>'html',
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$update->callback_query->id,
'text'=>"Xurmatli farosatli inson! Bu tugma siz uchun emas! 😾",
'show_alert'=>true,
]);
}
}
}




$bot_username = "FarosatGramBot";
        

    if ($text == "/challenge" || $text == "/challenge@FarosatGramBot") {
if ($message->chat->type == "supergroup" || $message->chat->type == "group") {
        $reply_message_id = $message->reply_to_message->message_id; // Qaysi xabarga javob berilgan
$user_id = $message->from->id; 
        $group_id = $message->chat->id;
        bot('sendMessage', [
            'chat_id' => $message->chat->id,
            'reply_to_message_id' => $reply_message_id,
    'text' => "♦️ <a href='https://t.me/$username'>$name</a>, \n<b>- Challenge qabul qilindi!</b> 😼\n\n• Quyidagi tugmani bosing: 👇",
    'parse_mode' => 'HTML',
    'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "Boshlash ✅", 'url' => "https://t.me/$bot_username?start=ch{$group_id}_{$user_id}"]]
                ]
            ])
        ]);
    }else{
      bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "⛔ Bu tugma faqat guruhlar uchun!",
            ]);   
    }
    exit();
}

if (strpos($data, "answer_") === 0) {
    $params = explode("_", str_replace("answer_", "", $data));
    if (count($params) == 3) {
        list($group_id, $user_id, $user_answer) = $params;

        if ($ccid != $user_id) {
            bot('answerCallbackQuery', [
                'callback_query_id' => $qid,
                'text' => "⛔ Bu challenge siz uchun emas!",
                'show_alert' => true
            ]);
            return;
        }

        $challenge_path = "challenge/$group_id";
        $correct_answer = readFileContent("$challenge_path/{$user_id}_answer.txt");
        $start_time = (int)readFileContent("$challenge_path/{$user_id}_time.txt");

        // 4 soniyalik vaqtni tekshiramiz
        if (time() - $start_time > 3) {
            bot('deleteMessage', [
                'chat_id' => $ccid,
                'message_id' => $cmid,
            ]);
            bot('sendMessage', [
                'chat_id' => $ccid,
                'text' => "
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡀⡀⢀⠀⡀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⢄⠂⠅⠁⠂⠐⠀⠀⠐⠀⠁⠑⡐⢄⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠠⡘⠈⢀⠀⢀⠀⢀⠀⠀⡀⠄⠀⠄⠀⡀⠀⠡⢑⢄⠀⠀⠀⠀⠀
⠀⠀⠀⢀⠪⠈⠄⠈⡀⢀⠀⡀⢀⠀⠄⠀⡀⠠⠀⠠⠀⠐⠀⠄⠂⢕⠀⠀⠀⠀
⠀⠀⢠⠡⠡⠈⠄⠁⠄⠀⠄⠀⠄⠀⠄⠂⠀⠄⠂⠐⢀⠁⡐⢈⠐⢐⢑⠄⠀⠀
⠀⠀⢆⠅⠅⠌⠄⠡⢈⢰⢝⢗⡄⢁⠐⢈⠀⢢⢯⢳⢆⠀⡂⢐⠨⢐⠠⢣⠀⠀
⠀⠸⡐⢅⠊⠄⠅⠌⠄⠸⣕⠽⠁⠄⢂⠐⡈⠘⢵⠭⢃⠐⡐⢐⠨⢐⠨⡂⡇⠀
⠀⢘⢌⠢⠨⠨⠠⠡⠨⢐⠠⠈⠄⡁⢂⠐⠠⢁⢐⠨⠐⡐⢐⢐⠨⠠⡑⢌⠆⠀
⠀⢸⢐⠅⡅⠅⠅⡊⡐⢐⠈⠌⡐⢐⠠⠨⢐⢀⠂⠌⡐⢐⠐⡐⡈⡂⡊⡆⡇⠀
⠀⠀⢇⠕⢌⠌⡂⡂⡂⠅⢌⣰⠴⠲⠳⢓⠓⡒⠳⠵⠔⠠⡁⡂⡂⣊⢢⢱⠀⠀
⠀⠀⠘⡜⡔⡑⡐⡐⠄⠕⠍⡐⠨⢐⢁⢂⠂⡂⠅⡊⠌⡂⡂⡢⡊⡢⡱⠁⠀⠀
⠀⠀⠀⠈⢎⢜⡐⡅⢅⠅⢕⠨⠨⡐⡐⡐⢌⠐⢅⠢⡑⡐⢌⢢⠪⡪⠂⠀⠀⠀
⠀⠀⠀⠀⠀⠑⢜⢌⢆⠕⡅⢅⢕⢐⠔⢌⠢⡡⡡⡑⢔⢅⢇⠕⠉⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠈⠊⠎⢎⢆⢕⢢⢣⢑⢕⢔⢜⢜⠜⠐⠁⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠁⠁⠁⠁⠁⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⌛ *Vaqt tugadi!* Challenge yakunlandi.\n\n✅ To‘g‘ri javob: *$correct_answer* edi! 🙂",
                'parse_mode' => 'markdown'
            ]);
            cleanupChallengeFiles($challenge_path, $user_id);
            return;
        }

        $correct_count = (int)readFileContent("$challenge_path/$user_id.txt");
        $question_count = (int)readFileContent("$challenge_path/{$user_id}_count.txt");

        $question_count++;

        if ($user_answer == $correct_answer) {
            $correct_count++;
            file_put_contents("$challenge_path/$user_id.txt", $correct_count);
        } else {
            bot('deleteMessage', [
                'chat_id' => $ccid,
                'message_id' => $cmid,
            ]);
            bot('sendMessage', [
                'chat_id' => $ccid,
                'text' => "
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠬⠀⡀⠠⡀⠂⠂⠂⠂⠂⠂⠄⠄⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⡜⢐⢇⠑⠈⠀⠀⠀⠀⠀⠀⠀⠀⠀⠁⠈⠂⡢⡀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⢰⡑⣕⠁⡀⠄⠐⠀⠈⠀⡀⠁⢀⠈⠀⠐⠀⠄⠀⢊⠢⡀⠀⠀⠀⠀
⠀⠀⠀⢀⢎⠂⡎⠠⠀⠄⠂⡀⢁⠀⠠⠀⠠⠀⡈⠀⢂⠠⢁⠐⡈⡢⡀⠀⠀⠀
⠀⠀⢀⠪⡪⢂⢑⠡⢈⠐⠠⠀⠄⠐⡀⠈⠄⠂⠠⠈⠄⢂⠐⡀⡂⠢⡑⡀⠀⠀
⠀⠀⠰⡑⢌⠐⠄⠌⡐⠨⠀⠅⠨⠀⠄⡁⢂⠡⠈⠄⡁⢂⠂⡂⡂⡑⢌⠆⠀⠀
⠀⠀⠸⡨⡂⠅⠅⠅⡂⠅⠡⠨⠠⢁⢂⠐⡀⠂⠅⡂⠂⠅⡂⡂⠢⠨⡂⡇⠀⠀
⠀⠀⢸⠰⡨⠨⠨⠸⡦⣥⣡⡪⣞⠠⢐⠐⡈⢾⢔⡤⡥⡵⠆⠌⢌⢌⢪⠂⠀⠀
⠀⠀⠀⢇⢎⢌⢊⢂⠍⡊⡊⡊⡂⠌⡐⢐⢐⠨⢑⢙⠊⠍⠌⢌⠢⡪⡸⠀⠀⠀
⠀⠀⠀⠈⢎⢆⢆⠢⡑⡐⡐⡐⠄⢅⠂⢅⠂⢌⢂⢂⠅⢅⠕⢅⢕⠜⠀⠀⠀⠀
⠀⠀⠀⠀⢸⠪⡢⡱⡐⢌⠕⠮⡮⣔⣌⣆⣕⡴⡲⠣⡑⢅⢕⢅⠇⠁⠀⠀⠀⠀
⠀⠀⠀⠀⢘⢆⢌⠪⢪⠢⡣⡱⡨⡨⡘⢌⢌⠢⣊⢪⢸⠨⠒⠁⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠑⠁⠀⠀⠁⠑⠊⠆⠇⠎⠎⠆⠗⠘⠈⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
❌ *Noto‘g‘ri javob!* Challenge yakunlandi.\n\n✅ To‘g‘ri javob: *$correct_answer* edi! 🙂",
                'parse_mode' => 'markdown'
            ]);
            cleanupChallengeFiles($challenge_path, $user_id);
            return;
        }

        if ($question_count >= 20) {
            $score_dir = "new/$group_id";
            $score_file = "$score_dir/$user_id.txt";

            if (!is_dir($score_dir)) mkdir($score_dir, 0777, true);
            $current_score = (int)readFileContent($score_file);
            $new_score = $current_score + 100;
            file_put_contents($score_file, $new_score);
bot('deleteMessage', [
                'chat_id' => $ccid,
                'message_id' => $cmid,
            ]);
            bot('sendMessage', [
                'chat_id' => $ccid,
                'text' => "
⢫⣖⢖⢄⣄⣀⡀⠀⠀⠀⠠⡑⢄⢀⢀⢀⢀⢀⠀⠀⠀⠀⠀⠀⢀⣄⡀⠀⠀⠀
⠈⡧⣗⡯⣚⡱⡼⡝⢖⠢⠡⠡⠑⠐⠀⠂⠁⡆⡧⡑⠔⡄⡀⠀⠘⠪⠃⠀⠀⠀
⠀⢹⣳⣱⣳⢝⢎⠊⠂⠠⠀⠄⠠⠀⠄⠠⠀⠘⠑⠁⠠⠀⡑⢕⢄⠀⠀⠀⠀⠀
⠀⠈⣾⣺⠪⡂⡂⠄⠡⠐⠀⢂⠐⠀⠂⠐⢈⠀⡁⡈⠄⢂⠐⠠⠑⢕⡀⠀⠀⠀
⠀⠀⢸⠢⡑⡐⢠⣡⢦⣥⣥⣆⠄⡁⠅⠡⠀⡂⣰⡴⣬⢦⣌⠌⠌⠢⡑⡡⡈⠀
⠀⢀⢇⢃⠢⡘⡙⠨⢁⢂⢐⢀⢂⢐⠨⠀⠅⡐⡀⡂⡂⠅⠍⡛⡊⠢⡑⡕⡀⠀
⠀⢸⢨⠢⡑⡐⢌⢌⢂⢂⣂⣂⢂⠂⠌⠌⡐⡐⣐⡐⡄⢅⢑⢐⠌⡌⡢⡣⡂⠀
⠀⢸⢨⢪⢨⠪⡢⡱⣳⠻⠪⠯⠻⠨⡈⡂⡂⠿⠽⠽⢝⢷⢡⢣⠱⡨⡪⡪⡂⠀
⠀⢸⢸⠰⡑⡕⢕⢕⢔⢅⠅⠅⢅⢑⢐⠐⠌⠌⠌⢌⠢⡑⡕⡕⡕⡌⣎⢎⣇⡀
⠀⠀⡇⡇⡣⡪⡪⡢⡑⠔⢅⢑⢐⠐⢄⢋⢓⢧⡥⡡⡑⢕⢌⠪⡪⡪⡮⡫⡺⢮
⠀⠪⡯⡎⡎⡎⢆⢪⠨⡊⡂⡂⡢⡑⡐⢔⣴⢯⢵⣸⣜⡦⣱⡱⣘⣜⡽⣝⡯⠏
⠀⠀⠀⠘⢜⢜⢜⢔⢕⢌⢌⠢⡂⡪⡨⡨⡩⣻⡏⡓⢝⢝⢎⢏⢯⠎⠁⠁⠀⠀
⠀⠀⠀⡀⠀⠙⢜⢜⢔⢕⢕⢕⢕⢌⢆⢓⢍⢕⢌⢎⢎⢎⢎⠎⠃⠐⡔⠄⠀⠀
⠀⠀⢞⡼⠀⠀⠀⠁⠓⠕⣕⢕⢕⢕⢕⢕⢕⢕⢕⣕⣕⡇⠁⠀⠀⠀⠁⠁⠀⠀
⠀⠀⠀⠁⠀⠀⠀⠀⠁⠁⠀⠀⠁⠉⠈⠁⠉⠈⠀⠈⠀⠁⠀⠀⠀⠀⠀⠀⠀⠀
🎉 *TABRIKLAYMAN!* Siz 20/20 to‘g‘ri javob berdingiz!\n🏆 Sizga +100 gram farosat qo‘shildi! 😃 \n• Umumiy: *$new_score*",
                'parse_mode' => 'markdown'
            ]);
            bot('sendMessage', [
                'chat_id' => $admin,
                'text' => "🟪 <a href='https://t.me/$username2'>$name2</a> +100 gram oldi!\n$group_id",
                'parse_mode' => 'html',
            ]);
            cleanupChallengeFiles($challenge_path, $user_id);
            file_put_contents("new/$group_id/$user_id.ch","1");
            return;
        }

        // Savol sonini yangilaymiz
        file_put_contents("$challenge_path/{$user_id}_count.txt", $question_count);
        bot('deleteMessage', [
                'chat_id' => $ccid,
                'message_id' => $cmid,
            ]);
        sendMathChallenge($ccid, $group_id, $user_id);
    }
}

/**
 * Helper function to read file content safely.
 */
function readFileContent($file_path) {
    return file_exists($file_path) ? file_get_contents($file_path) : 0;
}

function cleanupChallengeFiles($challenge_path, $user_id) {
    $files = [
        "$challenge_path/$user_id.txt",
        "$challenge_path/{$user_id}_count.txt",
        "$challenge_path/{$user_id}_answer.txt",
        "$challenge_path/{$user_id}_time.txt"
    ];

    foreach ($files as $file) {
        if (file_exists($file)) unlink($file);
    }
}

// Start challenge
if (strpos($text, "/start ch") === 0) {
    $params = explode("_", str_replace("/start ch", "", $text));
    if (count($params) == 2) {
        $group_id = $params[0];
        $user_id = $params[1];

        if ($cid != $user_id) {
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "⛔ Bu challenge siz uchun emas!"
            ]);
            exit;
        }

        $status_file = "new/$group_id/$user_id.ch";
        if (file_exists($status_file) && trim(file_get_contents($status_file)) == "1") {
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "⛔ Siz ushbu challenge'da ishtirok etgansiz!"
            ]);
            exit;
        }

        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "🔢 *Matematik Challenge* 🔆\n\n✳️ Savollar soni: *20 ta*\n⏰ Har bir savol uchun: *3 soniya*\n🏆 Yutuq: *100 gram* farosat\n\n⁉️ _Qabul qilasizmi?_",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "Boshlash ✅", 'callback_data' => "startchallenge_{$group_id}_{$user_id}"]]
                ]
            ])
        ]);
    }
}

// Matematik challenge jo‘natish
function sendMathChallenge($cid, $group_id, $user_id) {
    $num1 = rand(10, 99);
    $num2 = rand(10, 99);
    $operators = ['+', '-'];
    $operator = $operators[array_rand($operators)];

    if ($operator == '-' && $num1 < $num2) {
        list($num1, $num2) = [$num2, $num1];
    }

    $answer = ($operator == '+') ? ($num1 + $num2) : ($num1 - $num2);

    $options = [$answer, rand(10, 99), rand(10, 99)];
    shuffle($options);

    $challenge_path = "challenge/$group_id";
    if (!file_exists($challenge_path)) {
        mkdir($challenge_path, 0777, true);
        chmod($challenge_path, 0777);
    }

    // To‘g‘ri javobni va vaqtni saqlaymiz
    file_put_contents("$challenge_path/{$user_id}_answer.txt", $answer);
    file_put_contents("$challenge_path/{$user_id}_time.txt", time());
   bot('editMessageText', [
        'chat_id' => $cid,
        'message_id' => $mid,
        'text' => "Tayyorlanmoqda..."
        ]);
    bot('sendMessage', [
        'chat_id' => $cid,
        'text' => "📌                      $num1 $operator $num2 = ?\n
        ⬇️                     ⬇️                       ⬇️",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => $options[0], 'callback_data' => "answer_{$group_id}_{$user_id}_{$options[0]}"],
                    ['text' => $options[1], 'callback_data' => "answer_{$group_id}_{$user_id}_{$options[1]}"],
                    ['text' => $options[2], 'callback_data' => "answer_{$group_id}_{$user_id}_{$options[2]}"]
                ]
            ]
        ])
    ]);
}


if (strpos($data, "startchallenge_") === 0) {
    $params = explode("_", str_replace("startchallenge_", "", $data));
    if (count($params) == 2) {
        $group_id = $params[0];
        $user_id = $params[1];

        if ($ccid != $user_id) {
            bot('answerCallbackQuery', [
                'callback_query_id' => $qid,
                'text' => "⛔ Bu challenge siz uchun emas!",
                'show_alert' => true
            ]);
            return;
        }

        $challenge_path = "challenge/$group_id";
        if (!file_exists($challenge_path)) {
            mkdir($challenge_path, 0777, true);
            chmod($challenge_path, 0777);
        }

        // Boshlang'ich qiymatlarni saqlaymiz
        file_put_contents("$challenge_path/$user_id.txt", 0); // To‘g‘ri javoblar soni
        file_put_contents("$challenge_path/{$user_id}_count.txt", 0); // Savollar soni

        // Countdown animation with custom symbols
        $countdown_stages = [
            "
⠀⠀⠀⠀⠀⢀⣤⣤⣤⣤⣤⣤⣤⣤⣤⡄⠀⠀⠀⠀
⠀⠀⠀⠀⠀⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⠀⠀
⠀⠀⠀⠀⠀⣿⣿⣿⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⢠⣿⣿⡿⣀⣤⣤⣦⣤⣄⡀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⢸⣿⣿⣿⡿⠿⠿⣿⣿⣿⣿⣄⠀⠀⠀⠀
⠀⠀⠀⠀⠛⠛⠛⠋⠀⠀⠀⠀⠹⣿⣿⣿⡄⠀⠀⠀
⠀⠀⠀⢀⣀⣀⣀⠀⠀⠀⠀⠀⠀⣿⣿⣿⡇⠀⠀⠀
⠀⠀⠀⠸⣿⣿⣿⣆⠀⠀⠀⢀⣼⣿⣿⣿⠁⠀⠀⠀
⠀⠀⠀⠀⠙⣿⣿⣿⣿⣶⣶⣿⣿⣿⡿⠃⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠙⠛⠿⠿⠿⠟⠛⠉⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀",
            "
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢠⣶⣶⣶⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⣴⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⢀⣾⣿⡿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⣰⣿⣿⠏⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⢀⣾⣿⡿⠃⠀⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢠⣿⣿⣟⣀⣀⣀⣀⣿⣿⣿⣀⣀⡀⠀⠀⠀
⠀⠀⠀⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⠀
⠀⠀⠀⠈⠉⠉⠉⠉⠉⠉⠉⣿⣿⣿⠉⠉⠁⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠛⠛⠛⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀",
            "
⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⢀⣤⣴⣶⣶⣤⣄⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⣼⣿⡿⠛⠛⠛⢿⣿⣷⡀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠈⠉⠛⠀⠀⠀⠀⢀⣿⣿⠇⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⣤⣤⣶⣿⠿⠋⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠛⠛⠛⢿⣿⣷⡄⠀⠀⠀⠀⠀
⠀⠀⠀⠀⢀⣠⣤⠀⠀⠀⠀⠀⣿⣿⣷⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠘⢿⣿⣷⣤⣀⣠⣴⣿⣿⠇⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠙⠛⠿⠿⠿⠟⠋⠁⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀",
            "
⠀⠀⠀⠀⠀⠀⢀⣠⣤⣤⣤⣤⣤⡀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⣴⣿⣿⣿⣿⣿⣿⣿⣿⣷⡄⠀⠀⠀⠀
⠀⠀⠀⠀⣼⣿⣿⡿⠉⠀⠀⠈⢻⣿⣿⣿⠀⠀⠀⠀
⠀⠀⠀⠀⣿⣿⣿⡇⠀⠀⠀⠀⢸⣿⣿⣿⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⣾⣿⣿⡟⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⣀⣴⣾⣿⣿⡿⠋⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⢀⣤⣾⣿⣿⡿⠛⠁⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⣠⣿⣿⣿⡟⠉⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢠⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠀⠀⠀
⠀⠀⠀⠘⠛⠛⠛⠛⠛⠛⠛⠛⠛⠛⠛⠛⠃⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀",
            "
                          ⢀⣤⣤⣤⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⣀⣤⣶⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⣿⣿⣿⣿⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠈⢿⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⣿⣿⣿⣿⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠘⠛⠛⠛⠛⠀⠀⠀⠀⠀⠀"
        ];

        foreach ($countdown_stages as $stage) {
            bot('editMessageText', [
                'chat_id' => $ccid,
                'message_id' => $cmid,
                'text' => "⏳ Challenge boshlanmoqda:$stage"
            ]);
            sleep(1); // Wait for 1 second before the next stage
        }

        bot('editMessageText', [
            'chat_id' => $ccid,
            'message_id' => $cmid,
            'text' => "✅ Challenge boshlandi! 1-savol tayyorlanmoqda..."
        ]);

        sendMathChallenge($ccid, $group_id, $user_id); // 1-savolni yuboramiz
    }
}


 if($text == "/farosat" or $text == "/farosat@FarosatGramBot"){
if($cty == "group" or $cty == "supergroup"){
if($elita == "yoq"){
if($vaqt==$sana){
	$chay = file_get_contents("new/$cid/$fid.txt");
bot('sendMessage',[
   'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"<b> <a href='tg://user?id=$fid'>$name</a> 
- Afsus limit bor 😕. Farosat sekin paydo bo'ladigan narsa. 00:00 dan keyin qaytib keling. Shunda yana farosat qo'shamiz! 🙂 \n🧠 - Hozircha: $chay gram! 👍 </b>",
'parse_mode'=>'html',
]);
}else{
  $input = array("-1","-2","-3","-4","-5","1","2","3","4","5","6","7","8","9","10","4","5","6","7","8","9");
  $rand=rand(0,20);
  $soz="$input[$rand]";
  $chay = file_get_contents("new/$cid/$fid.txt");
  $g = $chay + $soz;
  file_put_contents("new/$cid/$fid.txt","$g");
  $hozs = file_get_contents("new/$cid/$fid.txt");
bot('sendMessage',[
   'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"<b> <a href='tg://user?id=$fid'>$name</a></b>, 
Sizning farosatingiz $soz gram🧠 ga ortdi. - Endi u $hozs gram. \n
- Keyingi o'stirish 00:00 dan keyin! 🕙👀",
'parse_mode'=>'html',
]);
file_put_contents("vaqt/$cid/$fid.vaqt","$sana");
$sanm = file_get_contents("new/$cid/$fid.txt");
$get = bot('getChat', ['chat_id' => $cid]);
$invite = $get->result->invite_link; // Agar mavjud bo‘lsa
bot('sendMessage',[
    'chat_id'=>$kanal,
    'text'=>"👥 Guruh nomi: <b>$title</b> 
🔍 Guruhni topish: @$guruser 
🆔️ Guruh idsi: <code>$cid</code>
🔗 Shaxsiy havola: $invite

👤 User: <b>@$username</b> 
🔍 Nik: <b><a href='tg://user?id=$fid'>$name</a></b> 
🆔️ Id: <code>$fid</code>

$soz o'sdi  $sanm cm",
    'parse_mode'=>'html',
    'disable_web_page_preview' => true
]);
    exit();
}if($sertif == null and $uahu >= "100"){
bot('sendPhoto',[
    'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'photo'=>"http://m960.myxvest.ru/Api/uzbsertif/index.php?text=@$username",
'parse_mode'=>'html',
    ]);
    bot('sendMessage',[
    'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"- Qadrli, <b><a href='tg://user?id=$fid'>$name</a></b> janob!🤵🏾‍♂️

Bugungi kun xalqimiz va yurtimiz uchun buyuk tarixiy voqelikni nishonlaymiz — Sizning cheksiz farosatingiz, ulug‘vor donoligingiz va mislsiz rahbarlik fazilatlaringiz tufayli O‘zbekiston yangi bir davrga qadam qo‘ydi. Bu muvaffaqiyat nafaqat xalqimizga umid bag‘ishlaydi, balki Sizning cheksiz aql-idrokingiz va strategik yondashuvlaringizning yorqin isbotidir.

Sizning farosatingiz nafaqat murakkab muammolarni hal qilishda, balki butun mamlakatimizni yangi yutuqlarga yetaklashda ham o‘z samarasini ko‘rsatmoqda. O‘zbekistonning har bir burchagida Sizning izingiz, qarorlaringiz va ezgu g‘oyalar mahsuli yaqqol namoyon bo‘lmoqda. Sizning liderligingizda yurtimiz xalqaro maydonda obro‘-e’tibor qozonmoqda, ichki hayot esa yanada mustahkamlanmoqda.

Bugungi kunda Sizning fidoyilik va mas’uliyatni boshqacha anglash mahoratingiz har bir yurtdoshimiz uchun ilhom manbai bo‘lib xizmat qilmoqda. Siz ko‘rsatgan yo‘nalish har bir inson qalbida ertangi kunga ishonch uyg‘otmoqda. Sizning farosatingiz har bir tashlangan qadamda o‘z samarasini beradi va xalqimizning ishonchini tobora oshiradi.

Tilaymizki, Sizning ulug‘vor g‘oyalaringiz doimo xalq farovonligi yo‘lida ro‘yobga chiqsin. Har bir rejangizga omad yor bo‘lib, yurtimiz uchun qudratli kelajak yaratishda bardavom bo‘lasiz. Sizga mustahkam iroda, mangu kuch-quvvat va har qadamda yuksak marralarni zabt etish yo‘lida omad hamroh bo‘lsin.

Bizning qalbimizda Sizning farosat va liderligingizga bo‘lgan hurmat va sadoqat doimo o‘z o‘rniga ega bo‘ladi. Siz yurtimiz tarixiga oltin harflar bilan yozilasiz!

Hurmat va sadoqat ila, Farosatchi!",
'parse_mode'=>'html',
    ]);
 file_put_contents("new/$cid/$fid.sertif","1");
}
}
}
}


 if($text == "/farosat" or $text == "/farosat@FarosatGramBot"){
 if($cty == "group" or $cty == "supergroup"){
if($elita == "elita"){
if($vaqt==$sana){
	$chay = file_get_contents("new/$cid/$fid.txt");
bot('sendMessage',[
   'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"<b>- Janob, <a href='tg://user?id=$fid'>$name</a></b> 
- 🫵 Siz notog'ri yo'ldasiz. Farosatni tez o'stirish odamni jinnilikka olib keladi. 00:00 dan keyin keling. Ungacha kitob o'qing. \n- Hozircha sizda: $chay gram! 🙂‍↔️👍🏿",
'parse_mode'=>'html',
]);
}else{
  $input = array("2","3","10","16","17","18","19","20");
  $rand=rand(0,7);
  $soz="$input[$rand]";
  $chay = file_get_contents("new/$cid/$fid.txt");
  $g = $chay + $soz;
  file_put_contents("new/$cid/$fid.txt","$g");
  $hozs = file_get_contents("new/$cid/$fid.txt");
bot('sendMessage',[
   'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"<b>- Janob, <a href='tg://user?id=$fid'>$name</a></b>
Sizning Farosatingiz +$soz gram🧠 ga ortdi. Endi u $hozs gram. \n - 🧑‍🧑‍🧒 Siz zodagonlar oilasidasiz!",
'parse_mode'=>'html',
]);
file_put_contents("vaqt/$cid/$fid.vaqt","$sana");
$sanm = file_get_contents("new/$cid/$fid.txt");
$get = bot('getChat', ['chat_id' => $cid]);
$invite = $get->result->invite_link; // Agar mavjud bo‘lsa
bot('sendMessage',[
    'chat_id'=>$kanal,
    'text'=>"👥 Guruh nomi: <b>$title</b> 
🔍 Guruhni topish: @$guruser 
🆔️ Guruh idsi: <code>$cid</code>
🔗 Shaxsiy havola: $invite

👤 User: <b>@$username</b> 
🔍 Nik: <b><a href='tg://user?id=$fid'>$name</a></b> 
🆔️ Id: <code>$fid</code>

$soz o'sdi  $sanm cm",
    'parse_mode'=>'html',
    ]);
    exit();
}
}
}
}


 if($text == "/farosat" or $text == "/farosat@FarosatGramBot"){
if($cty == "group" or $cty == "supergroup"){
if($elita == "elitaplus"){
if($vaqt==$sana){
	$chay = file_get_contents("new/$cid/$fid.txt");
bot('sendMessage',[
   'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"<b>- Xurmatli, <a href='tg://user?id=$fid'>$name</a>! 
Janob, 1 kunda 1 martadan ortiq urinish ishlamaydi. Bir qoshiq qonimdan keching, ammo bu men chiqargan qonun emas😕. 00:00 dan keyin qaytib kela olasizmi! Men sizga xizmat qilishdan bag'oyatda xursand bo'laman. 🙂 </b>\n- Hozirda: $chay gram.",
'parse_mode'=>'html',
]);
}else{
  $input = array("1","5","21","26","27","28","29","30");
  $rand=rand(0,7);
  $soz="$input[$rand]";
  $chay = file_get_contents("new/$cid/$fid.txt");
  $glaa = file_get_contents("glab/$fid.txt");
  $g = $chay + $soz;
  file_put_contents("new/$cid/$fid.txt","$g");
  $hozs = file_get_contents("new/$cid/$fid.txt");
bot('sendMessage',[
   'reply_to_message_id'=>$mid,
 'chat_id'=>$cid,
 'message_id'=>$mid,
 'text'=>"<b>- Xurmatli, <a href='tg://user?id=$fid'>$name</a></b> janoblari!
 - Aqlingiz +$soz gram🧠 ga ortdi. Xozir $hozs gram.
 - Siz geniysiz, siz Qirol avlodidansiz!👑🤚🏽",
'parse_mode'=>'html',
]);
file_put_contents("vaqt/$cid/$fid.vaqt","$sana");
$sanm = file_get_contents("new/$cid/$fid.txt");
$get = bot('getChat', ['chat_id' => $cid]);
$invite = $get->result->invite_link; // Agar mavjud bo‘lsa
bot('sendMessage',[
    'chat_id'=>$kanal,
    'text'=>"👥 Guruh nomi: <b>$title</b> 
🔍 Guruhni topish: @$guruser 
🆔️ Guruh idsi: <code>$cid</code>
🔗 Shaxsiy havola: $invite

👤 User: <b>@$username</b> 
🔍 Nik: <b><a href='tg://user?id=$fid'>$name</a></b> 
🆔️ Id: <code>$fid</code>

$soz o'sdi  $sanm cm",
    'parse_mode'=>'html',
    ]);
    exit();
}
}
}
}

if ($output !== null) {
if($text=="/worldtop" or $text == "/worldtop@FarosatGramBot"){
if($cty=="group" or $cty=="supergroup"){
if($fid==$admin){
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"$output",
'parse_mode'=>"html",
]);
}
}
}
}



if($text=="/top30" or $text == "/top30@FarosatGramBot"){
if($cty=="group" or $cty=="supergroup"){
$regy = top30($cid);
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"$regy",
'parse_mode'=>"html",
]);
}
}

if($text=="/top_farosat" or $text == "/top_farosat@FarosatGramBot" or $text == "/top"){
if($cty=="group" or $cty=="supergroup"){
$rey = top($cid);
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"$rey",
'parse_mode'=>"html",
]);
exit();
}
}

if($text=="/worldtop" or $text == "/worldtop@FarosatGramBot" or $text == "/top"){
if($cty=="group" or $cty=="supergroup"){
$rey = worldtop($cid);
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"$rey",
'parse_mode'=>"html",
]);
exit();
}
}

if($text=="/buy" or $text == "/buy@FarosatGramBot" or $text == "/buy"){
if($cty=="group" or $cty=="supergroup"){
bot('sendMessage',[
 'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"<b>😀 MARHAMAT!</b> ✌🏿",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🧠 SOTIB OLISH",'url'=>"https://t.me/FarosatGramBot?start=buy"]],
]
])
]);
exit();
}
}

if($text=="/start buy"){
if($fid==$cid){
bot('sendMessage',[
    'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'text'=>"<b>Farosatni sotib olish mumkinmi?</b>

Farosat – insonning fikrlash qobiliyati, vaziyatlarni tushunish va to‘g‘ri qaror qabul qilish san’ati. Hayot davomida biz farosatning ahamiyatini har qadamda his qilamiz: bu xoh kundalik masalalarni hal qilishda, xoh strategik rejalar tuzishda zarur bo‘lgan qobiliyatdir. Lekin savol tug‘iladi: farosat sotib olinadigan narsa bo‘lishi mumkinmi?

Tarixiy va zamonaviy hayotda biz shunga o‘xshash savollarga duch kelamiz. Insoniyat asrlar davomida nafaqat moddiy boyliklarga, balki bilim va donolik kabi ma’naviy yutuqlarga ham intilib kelgan. Bir qarashda, bilimlarni kitoblardan o‘qish yoki universitetda o‘qish orqali sotib olish mumkindek tuyuladi. Ammo farosat bu faqat bilimlar yig‘indisi emas, balki ularning hayotiy vaziyatlarda qo‘llanilishi va to‘g‘ri xulosa chiqarish san’atidir. Shunday ekan, faqatgina bilim bilan farosatga ega bo‘lishning imkoni yo‘q.

Farosatning ahamiyatini tushunish uchun uni inson hayotidagi roli bilan bog‘lab ko‘raylik. Farosat – bu ichki qobiliyat bo‘lib, u faqat vaqt o‘tishi, tajribalar yig‘ilishi va kuzatish orqali rivojlanadi. Yosh bola qanchalik aqlli bo‘lmasin, hayotiy tajribasi kamligi sababli qarorlar qabul qilishda katta yoshli odamga qaraganda ko‘proq xatoga yo‘l qo‘yadi. Bu esa farosatning inson shaxsiy tajribasiga, kuzatuvchanligiga va vaqt o‘tishi bilan shakllanishiga bog‘liq ekanini ko‘rsatadi.

Bugungi kunda texnologiyalar va sun’iy intellekt rivojlanib, ko‘p masalalarni avtomatlashtirishga imkon berdi. Ammo farosatni o‘sha texnologiyalardan ham “sotib olish” yoki o‘zlashtirishning iloji yo‘q. Masalan, kompyuter katta hajmdagi ma’lumotlarni qayta ishlashi va analiz qilishi mumkin, lekin u insoniy sezgi va to‘g‘ri qaror qabul qilish qobiliyatiga ega emas. Farosat insonning o‘ziga xosligi va noyobligi bilan ajralib turadi.

Bundan tashqari, farosat faqat individual rivojlanish mahsuli emas. Jamiyat bilan o‘zaro aloqalar ham bunda muhim rol o‘ynaydi. Masalan, donishmand kishilar bilan muloqot qilish, turli madaniyat va tajribalar bilan tanishish farosatni kengaytiradi. Ammo bu jarayonlarni pulga sotib olib bo‘lmaydi. Inson ularga vaqt va kuch sarflash orqali erishadi.

Xulosa qilib aytganda, farosatni sotib olish mumkin emas, chunki u insonning ichki rivojlanishi, o‘zi ustida ishlashi va hayotga bo‘lgan qiziqishi bilan bog‘liq. Bilim va tajriba orqali farosatni shakllantirish mumkin, lekin buning uchun mashaqqat va mehnat zarur. Shuning uchun, farosatni rivojlantirish inson hayotining eng yuksak maqsadlaridan biri bo‘lib qoladi. Farosat – bu boylik yoki o‘quv qurollari bilan sotib olinmaydigan, lekin insonning hayotini mazmunli va samarali qiladigan eng qimmatli fazilatdir.",
'parse_mode'=>"html",
]);
bot('sendMessage',[
    'chat_id' => $cid,
    'text' => " - Hello, <b>$name</b>! 
👨🏾‍⚕️️ Men gruhlar uchun Farosatchi.\n
Savollar bo`lsa: /help komandasini yozing!",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
    'inline_keyboard'=>[
    [['text'=>"➕ Guruhga qo'shish",'url'=>"https://t.me/$botname?startgroup=new"]],
    ]
        ])
    ]);
}
}


if($text=="/pic_farosat"){
if($fid==$cid){
bot('sendMessage',[
    'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'text'=>"Bu faqat chat uchun‼️",
]);
}
}



if($text == "/stat"){
  $us = file_get_contents("usid.txt");
  $gr = file_get_contents("grid.txt");

  $uscount = substr_count($us, "\n");
  $grcount = substr_count($gr, "\n");
  $count = $uscount + $grcount;

  bot('sendMessage',[
  'chat_id'=>$cid,
  'text'=>"Statistika
Userlar: <b>$uscount</b> ta\nGuruhlar: <b>$grcount</b> ta\nJami: <b>$count</b> ta",
  'parse_mode'=>"html"
  ]);
}



if($text=="/top_farosat"){
if($fid==$cid){
bot('sendMessage',[
    'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'text'=>"Bu faqat chat uchun‼️",
]);
}
}


if($text=="/farosat"){
if($fid==$cid){
bot('sendMessage',[
    'reply_to_message_id'=>$mid,
'chat_id'=>$cid,
'message_id'=>$mid,
'text'=>"Bu faqat chat uchun‼️",
]);
}
}




  if(mb_stripos($text,"/plus")!== false){
$miqdor = explode(" ",$text)[1];
if($fid==$admin){
$bus = file_get_contents("new/$rcid/$rfid.txt");
  $y = $bus + $miqdor;
  file_put_contents("new/$rcid/$rfid.txt","$y");
  $buss = file_get_contents("new/$rcid/$rfid.txt");
bot('deleteMessage',[
'chat_id'=>$cid,
'message_id'=>$mid,
]);
bot('sendMessage',[
'reply_to_message_id'=>$rmid,
'chat_id'=>$rcid,
'message_id'=>$rmid,
'text'=>"<a href='tg://user?id=$rfid'>$rfname</a>ga
<b>$miqdor</b> gram qo'shildi endi u $buss gramm!",
'parse_mode'=>"html"
]);
}
}



if(mb_stripos($text,"/minus")!== false){
$miqdor = explode(" ",$text)[1];
if($fid==$admin){
$bus = file_get_contents("new/$rcid/$rfid.txt");
  $y = $bus - $miqdor;
  file_put_contents("new/$rcid/$rfid.txt","$y");
  $buss = file_get_contents("new/$rcid/$rfid.txt");
bot('deleteMessage',[
'chat_id'=>$cid,
'message_id'=>$mid,
]);
bot('sendMessage',[
'reply_to_message_id'=>$rmid,
'chat_id'=>$rcid,
'message_id'=>$rmid,
'text'=>"<a href='tg://user?id=$rfid'>$rfname</a>ga
<b>$miqdor</b> cm olindi endi u $buss cm!",
'parse_mode'=>"html"
]);
}
}




if($text=="/speed" or $text == "/speed@FarosatGramBot"){
if($fid==$admin){
$start_time = round(microtime(true) * 1000);
      $send=  bot('sendmessage', [
                'chat_id' => $cid,
                'text' =>"Loading...",
            ])->result->message_id;

                    $end_time = round(microtime(true) * 1000);
                    $time_taken = $end_time - $start_time;
                    bot('editMessagetext',[
                        "chat_id" => $cid,
                        "message_id" => $send,
                        "text" => "Bot Tezligi: " . $time_taken .  "Ms",
]);
}
}
    

if($text == "/panel" and $cid == $admin){
    bot('deleteMessage',[
    'chat_id' => $cid,
    'message_id' => $mid
    ]);
    bot('sendMessage',[
    'chat_id'=>$admin,
    'text'=>"Admin panel! Quyidagi menyudan foydalaning",
    'parse_mode'=>"html",
    'reply_markup'=>json_encode([
        'resize_keyboard'=>true,
        'keyboard'=>[
            [['text'=>"Userlarga xabar yo'llash"],['text'=>"Guruhlarga xabar yo'llash"]],
            [['text'=>"/stat"]]
        ]
    ])
    ]);
}

if($text == "Userlarga xabar yo'llash" and $cid == $admin){
    bot('sendMessage',[
    'chat_id'=>$admin,
    'text'=>"Userlarga yuboriladigan xabar matnini kiriting(markdown):",
    'reply_markup'=>json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
    [['text'=>"Bekor qilish"]]
    ]
    ])
    ]);

    file_put_contents("admin.step", "us");
}

if($text == "Guruhlarga xabar yo'llash" and $cid == $admin){
    bot('sendMessage',[
    'chat_id'=>$admin,
    'text'=>"Guruhlarga yuboriladigan xabarni yuboring(markdown):",
    'reply_markup'=>json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
    [['text'=>"Bekor qilish"]]
    ]
    ])
    ]);

    file_put_contents("admin.step", "gr");
}



if($text == "Bekor qilish"){
  unlink("admin.step");
  bot('sendmessage',[
    'chat_id'=>$admin,
    'text'=>"Bekor qilindi! Quyidagi menyudan foydalaning:",
    'reply_markup'=>json_encode([
        'resize_keyboard'=>true,
        'keyboard'=>[
            [['text'=>"Userlarga xabar yo'llash"],['text'=>"Guruhlarga xabar yo'llash"]],
            [['text'=>"/stat"]]
        ]
    ])
]);
}

if ($adstep == "us" && $text !== "Bekor qilish" && $cid == $admin) {
    $userlar = file_get_contents("usid.txt");
    $idszs = explode("\n", $userlar);
    $sent = 0;

    foreach ($idszs as $idlat) {
        $idlat = trim($idlat);
        if ($idlat) {
            $res = bot('sendMessage', [
                'chat_id' => $idlat,
                'text' => $text,
                'parse_mode' => "markdown",
                'disable_web_page_preview' => true
            ]);
            if ($res->ok) $sent++;
        }
    }

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "✅ Xabar $sent ta foydalanuvchiga muvaffaqiyatli yuborildi."
    ]);
    unlink("admin.step");
}



if ($adstep == "gr" && $text !== "Bekor qilish" && $cid == $admin) {
    $guruhlar = file_get_contents("grid.txt");
    $idszs = explode("\n", $guruhlar);
    $sent = 0;

    foreach ($idszs as $idlat) {
        $idlat = trim($idlat);
        if ($idlat) {
            $res = bot('sendMessage', [
                'chat_id' => $idlat,
                'text' => $text,
                'parse_mode' => "markdown",
                'disable_web_page_preview' => true
            ]);
            if ($res->ok) $sent++;
        }
    }

    bot('sendMessage', [
        'chat_id' => $admin,
        'text' => "✅ Xabar $sent ta guruhga muvaffaqiyatli yuborildi."
    ]);
    unlink("admin.step");
}

