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
        $response = 'Sobre que quieres las noticias';
        sendMessage($chatId, $response, TRUE);

       
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
            sendMessage($chatId, $response, FALSE);
            break;
        case '/saludo':
            $response = 'Hola! Soy @Alex19bot';
            sendMessage($chatId, $response, FALSE);
            break;
            /*case '/enlaces':
                $response = 'Selecciona uno';
                $keyboard = {
                  'inline_keyboard': [
                    [{
                      'text': 'Youtube',
                      'url': 'https://youtube.com'
                    },{
                      'text': 'Google',
                      'url': 'https://google.com'
                    }]
                  ]
                };
                sendMessage($chatId, $response);
                break;*/
      /*  case '/ayuda':
            $response = "Tranquilo, estoy contigo.";
            $teclado = ["https://www.youtube.com/"],["Pos Ok"],["Pos Ok"];
            sendMessage($chatId, $response, $teclado);
            break;*/
        case '/noticias':
            getNoticias($chatId, $buscar);
            break;
            case 'futbol';
            getNoticias($chatId, $buscar);
          break;
          case 'tenis':
            getNoticias($chatId, $buscar);
        break;
            case '/fecha':
                $response  = 'La fecha actual es ' . date('d/m/Y');
                sendMessage($chatId, $response, FALSE);
                break;
        
            case '/hora':
                $response  = 'La hora actual es ' . date('H:i:s');
                sendMessage($chatId, $response, FALSE);
            break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response, FALSE);
        break;
 
    }




    


    function sendMessage($chatId, $response, $repl) {
        if($repl==TRUE){
            $reply_mark=array('force_reply'=>True);
            $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($reply_mark).'&text='.urlencode($response);
        }
        else $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
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
function getNoticias($chatId, $buscar){
 
    //include("simple_html_dom.php");
 
    $context = stream_context_create(array('https' =>  array('header' => 'Accept: application/xml')));
    switch($buscar){
    case 'barca';
    $url = "https://e00-marca.uecdn.es/rss/futbol/barcelona.xml";
    break;
    case 'granada';
    $url = "https://e00-marca.uecdn.es/rss/futbol/granada.xml"
    break;
    case 'valencia';
    $url = "https://e00-marca.uecdn.es/rss/futbol/valencia.xml"
    break;
    }
    $xmlstring = file_get_contents($url, false, $context);
 
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
    
    for ($i=0; $i < 9; $i++) { 
    $titulos = $titulos."\n\n".$array['channel']['title']."<a href='".$array['channel']['item'][$i]['link']."'> +info</a>";
    }
    
    sendMessage($chatId, $titulos, FALSE);

 
}


?>

