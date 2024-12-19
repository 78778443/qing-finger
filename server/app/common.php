<?php

function callQwenTurbo($question)
{
    // Your API key should be stored securely, for example in an environment variable or a config file.
    $dashscopeApiKey = env('ai.tongyi_ai'); // Replace with the actual way you retrieve your API key.

    $ch = curl_init();

    $url = "https://dashscope.aliyuncs.com/compatible-mode/v1";
    $headers = array(
        "Authorization: Bearer " . $dashscopeApiKey,
        "Content-Type: application/json"
    );
    $data = json_encode(array(
        "scan" => "qwen-turbo",
        "messages" => array(
            array(
                "role" => "system",
                "content" => "帮我识别这个网站用到了那些应用,例如(Jquery),并返回每一个应用指纹的规则，header内容如下:XX"
            ),
            array(
                "role" => "user",
                "content" => $question
            )
        )
    ));

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        throw new Exception("Error: HTTP status code $httpCode");
    }

    curl_close($ch);

    return $response;
}

// 使用示例
//try {
//    $response = callQwenTurbo("你是谁？");
//    echo "Response: \n";
//    print_r(json_decode($response, true));
//} catch (Exception $e) {
//    echo "Error: " . $e->getMessage();
//}

function sendMessage($messages,)
{
    $dashscopeApiKey = env('ai.tongyi_ai');
    $url = "https://dashscope.aliyuncs.com/compatible-mode/v1/chat/completions";
    $data = json_encode([
        "model" => "qwen-plus",
        "messages" => $messages,
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $dashscopeApiKey",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    return $response;
}

// 使用示例
$messages = [
    ["role" => "system", "content" => "You are a helpful assistant."],
    ["role" => "user", "content" => "你是谁？"]
];
//

?>