<?php 

    error_reporting(E_ALL);
    ini_set("display_errors", 1);


    echo "POST BAŞLADI <br>";


    $username = "TestUser";
    $password = "test1215";
    $usercode = "2713";
    $accountID = "489";
    $originator = "ASIST BT";
    $telefon = "905554443322";
    $message = "Test Message";



    $url = "https://webservice.asistiletisim.com.tr/SmsProxy.asmx?WSDL";
    $request_headers = array(
        "Content-Type: text/xml; charset=utf-8",
        "SOAPAction: https://webservice.asistiletisim.com.tr/SmsProxy/sendSms",
        "Accept: text/xml"
    );

    $xml = '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns="https://webservice.asistiletisim.com.tr/SmsProxy">
     <soapenv:Header/>
         <soapenv:Body>
             <sendSms>
                 <requestXml>
                 <![CDATA[
                     <SendSms>
                         <Username>'.$username.'</Username>
                         <Password>'.$password.'</Password>
                         <UserCode>'.$usercode.'</UserCode>
                         <AccountId>'.$accountID.'</AccountId>
                         <Originator>'.$originator.'</Originator>
                         <SendDate></SendDate>
                         <ValidityPeriod>60</ValidityPeriod>
                         <MessageText>'.$message.'</MessageText>
                         <IsCheckBlackList>0</IsCheckBlackList>
                         <ReceiverList>
                            <Receiver>'.$telefon.'</Receiver>
                         </ReceiverList>
                     </SendSms>
                 ]]>
                 </requestXml>
             </sendSms>
         </soapenv:Body>
    </soapenv:Envelope>
    ';



    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

    if (curl_errno($ch)){
        echo "HATA <br>";
        echo curl_errno($ch) ;
        echo curl_error($ch);
    }else{
        echo "SONUC <br>";
        $response = curl_exec($ch);
        print_r($response);
        curl_close($ch);


        $xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $response);
        $xml = simplexml_load_string($xml);
        $xml = json_decode(json_encode($xml), TRUE);
        $error_code = $xml["Body"]["sendSmsResponse"]["sendSmsResult"]["ErrorCode"];

        if($error_code == 0){
            echo "başarılı<br>";
        }else if($error_code == -1){
            echo "Girilen bilgilere sahip bir kullanıcı bulunamadı.<br>";
        }else if($error_code == -2){
            echo "Kullanıcı pasif durumda.<br>";
        }else if($error_code == -3){
            echo "Kullanıcı bloke durumda.<br>";
        }else if($error_code == -4){
            echo "Kullanıcı hesabı bulunamadı.<br>";
        }else if($error_code == -5){
            echo "Kullanıcı hesabı pasif durumda.<br>";
        }else if($error_code == -6){
            echo "Kayıt bulunamadı.<br>";
        }else if($error_code == -7){
            echo "Hatalı xml istek yapısı.<br>";
        }else if($error_code == -8){
            echo "Alınan parametrelerden biri veya birkaçı hatalı.<br>";
        }else if($error_code == -9){
            echo "Prepaid hesap bulunamadı.<br>";
        }else if($error_code == -10){
            echo "Operatör servisinde geçici kesinti.<br>";
        }else if($error_code == -11){
            echo "Başlangıç tarihi ile şu an ki zaman arasındaki fark 30 dakikadan az.<br>";
        }else if($error_code == -12){
            echo "Başlangıç tarihi ile şu an ki zaman arasındaki fark 30 günden fazla.<br>";
        }else if($error_code == -13){
            echo "Geçersiz gönderici bilgisi.<br>";
        }else if($error_code == -14){
            echo "Hesaba ait SMS gönderim yetkisi bulunmuyor.";
        }else if($error_code == -15){
            echo "Mesaj içeriği boş veya limit olan karakter sayısını aşıyor.<br>";
        }else if($error_code == -16){
            echo "Geçersiz alıcı bilgisi.";
        }else if($error_code == -17){
            echo "Parametre adetleri ile şablon içerisindeki parametre adedi uyuşmuyor.<br>";
        }else if($error_code == -18){
            echo "Gönderim içerisinde birden fazla hata mevcut. MessageId kontrol edilmelidir.<br>";
        }else if($error_code == -19){
            echo "Mükerrer gönderim isteği.<br>";
        }else if($error_code == -20){
            echo "Bilgilendirme mesajı almak istemiyor.<br>";
        }else if($error_code == -21){
            echo "Numara karalistede.";
        }else if($error_code == -22){
            echo "Yetkisiz IP Adresi<br>";
        }else if($error_code == -23){
            echo "Kullanıcı yetkisi bulunmamaktadır.<br>";
        }else if($error_code == -1000){
            echo "SYSTEM_ERROR<br>";
        }else{
            echo "Bilinmeyen Hata<br>";
        }


    }

    echo "<br>POST BİTTİ <br>";

?>