<?php
$token = '5190510451:AAEB_CmkxY-VXdoB8Fkwznrb3SVb_8YKhHc';

$website = 'https://api.telegram.org/bot'.$token;
$urlphoto = "sendPhoto?chat_id=" . $chatId;
$urldom = "https://mi.dominio.net/image.jpg";
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
    case 'Noticia':
            getNoticias($chatId);
         break;
         case '/imagen' :
            sendMessage ($chatId, $response);
            sendPhoto($chatId);
            break;
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
}
function sendPhoto($chatId) {
    $url = $GLOBALS[website].'/sendPhoto?
chat_id='.$chatId.'&photo='.$urldom;
 file_get_contents($url);
}
?>

