<?php

// توکن بات تلگرام خود را وارد کنید
$TOKEN = '7092326613:AAHdIqJ15kkICEfyCyM6pysZfWio-lofXVI';

// آدرس URL برای ارسال درخواست‌ها
$apiURL = "https://api.telegram.org/bot$TOKEN/";

function sendMessage($chat_id, $text, $reply_markup = null) {
    global $apiURL;
    
    $postData = array(
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_markup' => json_encode($reply_markup)
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiURL . "sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

// دریافت داده‌های ورودی (وب‌هوک)
$update = json_decode(file_get_contents('php://input'), TRUE);

if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $user = $update['message']['from'];
    $username = $user['username'];
    $user_id = $user['id'];
    
    if (isset($update['message']['text'])) {
        $text = $update['message']['text'];
        
        // هنگامی که دستور /start ارسال شد
        if ($text == "/start") {
            $button_url = "https://sakine2023.github.io/F_test_W/index.html?username=$username&userid=$user_id";
            $keyboard = array(
                'inline_keyboard' => array(
                    array(
                        array(
                            'text' => 'Play',
                            'url' => $button_url
                        )
                    )
                )
            );
            sendMessage($chat_id, "برای شروع بازی روی Play کلیک کنید:", $keyboard);
        }
    }
}

?>
