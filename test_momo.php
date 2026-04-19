<?php
// Test multiple MoMo sandbox credentials to find a working one

$credentials = [
    [
        'name' => 'MOMO (Official Test)',
        'partnerCode' => 'MOMO',
        'accessKey' => 'F8BBA842ECF85',
        'secretKey' => 'K951B6PE1waDMi640xX08PD3vg6EkVlz',
    ],
    [
        'name' => 'MOMOBKUN (2018 Old)',
        'partnerCode' => 'MOMOBKUN20180830',
        'accessKey' => 'klm05TvNBqg7uH6B',
        'secretKey' => 'at67qH6mk8U5YpUA8xyYVsh6As1Y771a',
    ],
    [
        'name' => 'MOMO_ATM (ATM Test)',
        'partnerCode' => 'MOMO_ATM',
        'accessKey' => 'Q8gbQMfMEpBp4QDX',
        'secretKey' => 'vH77mAfSCzL4a3w7luRkRt5YTSOVlUkz',
    ],
];

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

foreach ($credentials as $cred) {
    echo "\n========================================\n";
    echo "Testing: " . $cred['name'] . "\n";
    echo "========================================\n";

    $partnerCode = $cred['partnerCode'];
    $accessKey = $cred['accessKey'];
    $secretKey = $cred['secretKey'];

    $orderInfo = "Test DDH Electronics";
    $amount = "50000";
    $orderId = "DDH_" . time() . "_" . rand(1000, 9999);
    $returnUrl = "http://127.0.0.1:8000/momo-return";
    $notifyUrl = "http://127.0.0.1:8000/momo-return";
    $requestId = (string) time() . rand(100, 999);
    $requestType = "captureWallet";
    $extraData = "";

    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $notifyUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $returnUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    $data = array(
        'partnerCode' => $partnerCode,
        'partnerName' => "DDH Electronics",
        'storeId' => "DDH_Store",
        'requestId' => $requestId,
        'amount' => (int) $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $returnUrl,
        'ipnUrl' => $notifyUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature
    );

    $payload = json_encode($data);
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload)
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "CURL ERROR: " . curl_error($ch) . "\n";
    } else {
        $jsonResult = json_decode($result, true);
        echo "Result Code: " . ($jsonResult['resultCode'] ?? 'N/A') . "\n";
        echo "Message: " . ($jsonResult['message'] ?? 'N/A') . "\n";
        if (isset($jsonResult['payUrl'])) {
            echo "*** SUCCESS! PAY URL: " . $jsonResult['payUrl'] . "\n";
        }
    }
    curl_close($ch);
    sleep(1); // tránh bị rate limit
}
