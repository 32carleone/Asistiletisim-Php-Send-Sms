<?php 
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    echo "####### POST BAŞLADI #######<br>";


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


    echo "<pre>".$xml."</pre>";
    print_r($request_headers );


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
        echo "HATA :  <br>";
        echo curl_errno($ch);
        echo curl_error($ch);
    } else{
        echo "SONUÇ :  <br>";
        $response = curl_exec($ch);
        print_r($response);
        curl_close($ch);
    }


    echo "<br> ####### POST BİTTİ ####### <br>";

?>