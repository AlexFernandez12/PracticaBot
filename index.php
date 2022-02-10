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
        case '/ayuda2':
            $response = "Tranquilo, estoy contigo.";
            $keyboard = '["Gracias"],["Pos Ok"]';
            sendMessage($chatId, $response,$keyboard);
            break;
        case '/noticias':
            getNoticias($chatId);
            break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
 
    }
function sendMessage($chatId, $response, $keyboard = NULL) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
    if (isset($keyboard)) {
        $teclado = '&reply_markup={"keyboard":['.$keyboard.'], "resize_keyboard":true, "one_time_keyboard":true}';
    }
}
 
function getNoticias($chatId){
 
    //include("simple_html_dom.php");
 
    $context = stream_context_create(array('https' =>  array('header' => 'Accept: application/xml')));
    $url = "https://e00-marca.uecdn.es/rss/futbol/primera-division.xml";
    $xmlstring = file_get_contents($url, false, $context);
 
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
 
    
        $titulos = $titulos."\n\n".$array['channel']['0']['description']."<a href='".$array['channel']['title']['link']."'> +info</a>";
    
 
    sendMessage($chatId, $titulos);
 
 
 
}


?>

