<?php
    // Bắt đầu session
    session_start();

    // Kiểm tra xem form có được submit không
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy các giá trị từ POST
        $name = $_POST['name'];
        $phone = $_POST['phonenum'];
        $address = $_POST['address'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];

        // Lưu các giá trị vào session
        $_SESSION['user_data'] = [
            'name' => $name,
            'phonenum' => $phone,
            'address' => $address,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'payment' =>  $_SESSION['room']['payment']// Ví dụ giá trị payment, bạn cần tính toán hoặc lấy giá trị này từ một nơi khác
        ];

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        // Thông tin thanh toán
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo ATM";
        $amount = $_SESSION['user_data']['payment'];
        $orderId = 'ORD_'.$_SESSION['uId'].random_int(11111, 9999999);
        $redirectUrl = "http://localhost/HotelManagement/pay_now.php";
        $ipnUrl = "http://localhost/HotelManagement/pay_now.php";
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        // Chuyển hướng tới URL thanh toán
        header('Location: ' . $jsonResult['payUrl']);
        exit;
    }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
?>


