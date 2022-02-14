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
        case '/help':
            $response  = 'Los comandos disponibles son:
            /start Inicializa el bot
            /saludo Presentacion del bot
            /ayuda Te ofrece apoyo
            /noticias Muestra noticias acerca de futbol
            /fecha Muestra la fecha actual
            /hora Muestra la hora actual
            /help Muestra esta ayuda';
            sendMessage($chatId, $response);
            break;
        case '/saludo':
            $response = 'Hola! Soy @Alex19bot';
            sendMessage($chatId, $response);
            break;
        case '/ayuda':
            $response = "Tranquilo, estoy contigo.";
            $keyboard = '["Gracias"],["Pos Ok"]';
            sendMessage($chatId, $response, $keyboard);
            break;
        case '/noticias':
            getNoticias($chatId);
            break;
            case '/fecha':
                $response  = 'La fecha actual es ' . date('d/m/Y');
                sendMessage($chatId, $response);
                break;
        
            case '/hora':
                $response  = 'La hora actual es ' . date('H:i:s');
                sendMessage($chatId, $response);
            break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
 
    }

function redes(){
    $linkyt = "https://www.youtube.com/watch?v=abQaOAy9JlQ";
    $linktw = "https://www.youtube.com/watch?v=abQaOAy9JlQ";


    $listbtn =json_encode(
        array(
            "inline_keyboard"=>array(
                array(
                    array('text'=>'YOUTUBE', 'url'=>$linkyt),
                    array('text'=>'TWITCH', 'url'=>$linktw),
                ),
            ),
        )
        );

        $texto ="Redes Sociales:";
        $url =$GLOBALS['website']."/sendMessage?chat_id=".$GLOBALS['chatId']."&text=".urlencode($texto)."&reply_markup=".$listbtn;
        file_get_contents($url);
        return $url;
}







function sendMessage($chatId, $response, $keyboard = TRUE) {
    if (isset($keyboard)) {
		$teclado = '&reply_markup={"keyboard":['.$keyboard.'], "resize_keyboard":true, "one_time_keyboard":true}';
	}
	$url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response).$teclado;
	file_get_contents($url);
}
 
function getNoticias($chatId){
 
    //include("simple_html_dom.php");
 
    $context = stream_context_create(array('https' =>  array('header' => 'Accept: application/xml')));
    $url = "https://e00-marca.uecdn.es/rss/futbol/barcelona.xml";
    $xmlstring = file_get_contents($url, false, $context);
 
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
    
    $titulos = $titulos."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['6']['link']."'> +info</a>";
    
    sendMessage($chatId, $titulos);
 
 
 
}


?>

