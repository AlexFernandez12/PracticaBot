<?php
$token = '5190510451:AAEB_CmkxY-VXdoB8Fkwznrb3SVb_8YKhHc';
$website = 'https://api.telegram.org/bot'.$token;


$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);
 
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
$repl=$update['message']['reply_to_message']['text'];


switch($message) {
    case '/start':
        $teclado = array(
            "inline_keyboard" => array(array(array(
            "texto" => "boton",
            "callback_data" => "button_0"
            )))
            );
        $postfields = array(
            'chat_id' => "$chatId",
            'texto' => "$response",
            'reply_markup' => json_encode($teclado)
            );
        
            sendMessage($chatId, $response);
            break;
        case '/saludo':
            $response = 'Hola! Soy @Alex19bot';
            sendMessage($chatId, $response);
            break;
      /*  case '/ayuda':
            $response = "Tranquilo, estoy contigo.";
            $teclado = ["https://www.youtube.com/"],["Pos Ok"],["Pos Ok"];
            sendMessage($chatId, $response, $teclado);
            break;*/
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



function sendMessage($chatId, $response, $teclado='') {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);

}
/*
function sendMessage($chatId, $response, $repl) {
    if($repl==TRUE){
        $reply_mark=array('force_reply'=>True);
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($reply_mark).'&text='.urlencode($response);
    }
    else $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
}
 */
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

