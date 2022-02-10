<?php
$token = '5190510451:AAEB_CmkxY-VXdoB8Fkwznrb3SVb_8YKhHc';
$website = 'https://api.telegram.org/bot'.$token;
 
$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);
 
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response);
        break;
    case 'Hola':
        $response = 'Hola! Soy @Alex19bot';
        sendMessage($chatId, $response);
        break;
    case '/noticias':
            getNoticias($chatId);
         break;
    case '/youtube':
            sendMessage($chatId, "Mi canal de YouTube es <a href='https://www.youtube.com/channel/UCGArCE3vmQkFpu_o_6axt1g'>SrVazquez</a>");
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
 
    }
function sendMessage($chatId, $response) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
}
 
function getNoticias($chatId){

	//include("simple_html_dom.php");

	$context = stream_context_create(array('http' =>  array('header' => 'Accept: application/xml')));
	$url = "http://www.europapress.es/rss/rss.aspx";

	$xmlstring = file_get_contents($url, false, $context);

	$xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
	$json = json_encode($xml);
	$array = json_decode($json, TRUE);

	for ($i=0; $i < 9; $i++) { 
		$titulos = $titulos."\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'> +info</a>";
	}

	sendMessage($chatId, $titulos);

}

?>

