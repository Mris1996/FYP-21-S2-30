<?php require_once("NavBar.php");




$request = new HttpRequest();
$request->setUrl('https://www.coinapi.io/api/subscriptions/usage/rest/history');
$request->setMethod(HTTP_METH_GET);
$request->setHeaders(array(
  'X-CoinAPI-Key' => '296890F0-1B67-48DA-AD5B-D5423D64FECC'
));

try {
  $response = $request->send();
  echo $response->getBody();
} catch (HttpException $ex) {
  echo $ex;
}
?>