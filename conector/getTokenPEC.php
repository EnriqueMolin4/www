<?php

$client = new http\Client;
$request = new http\Client\Request;
$request->setRequestUrl('https://sgse.microformas.com.mx/GetServerTest/api/authenticate/token');
$request->setRequestMethod('POST');
$body = new http\Message\Body;
$body->append('{
	"client_id": "aaede9ee-77bf-47c1-a551-f9b72637af82",
	"client_secret": "KLKK8gi^*(uK&0SWxNsB3*g5jLGiTX5ZKGw#aFLf4B3*tgjLOP",
	"grant_type": "client_credentials",
	"audience": "https://sgse.microformas.com.mx/"
}');
$request->setBody($body);
$request->setOptions(array());
$request->setHeaders(array(
  'Content-Type' => 'application/json',
  'Cookie' => '.AspNetCore.Identity.Application=CfDJ8GVzBE9KDpBAposh7P86ebdLXSTU5yDkQ4u9OpWpYW2DufRpE8mRI2UYzKfvxL5crsBUrQQmmuiokYa0zzqU9ltSddNUvVnm9Do23xYTeK-3bvenOpDokAXVuAxC0_8wcdY9UWMigV4OY8mEMw3VY_WCgmPZZfw7wq5rLLbRJZnwXYEh7682gg1NHRwNEEAA4X6IpULJsLnAtbXzFhnyXibwkRpUEqIP0wMBle0hS9q64Lkqorf9d44KvrMks4KfxZ5PbsJkhqf10UXzyBZ58Rirldh_M3xPbUJxIag2o5uKyCwkJOtbis26Xpf94lo2eQiiHc_tJ-gIkRuoRsp6cyiD_5jXkW-vzyW0P_EnAJPkezJxgnU1Yy53eT9imbyDKpHS6s6yjnJsI4BJeaXOi__OlDssOl08lpBweIQ9SxiOX81vxFu2QFZQNPdKBzDWwsM_WTQduG_3oi4R00sM2fi6ouSPzS7l-Kap94oaIQB8gOvYegFPkjl14Jvz__AnkoNySbhNWDTZLQgpTPMhLuRft3BFav2oIE36R8SanMI_KdkJmczEIc_R7x_YAx_e-oAx6duQLkw2NZ0sczNtZr9wBBy1TpAFDKds8UMC3GMys1hAwC2J9zVh_mCdD-z667_HNcJmNe66yMh4nRNRYZk'
));
$client->enqueue($request)->send();
$response = $client->getResponse();
echo $response->getBody();

?>