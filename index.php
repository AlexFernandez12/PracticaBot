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
        $response = 'Bot iniciado, escriba /help para ayudarle con el funcionamiento';
        sendMessage($chatId, $response, FALSE);       
        break;
        case '/ayuda':
            $response = 'Bot iniciado, escriba /help para ayudarle con el funcionamiento';
            sendMessage($chatId, $response, TRUE);       
            break;
        case '/help':
            $response  = 'Los comandos disponibles son:
            /start Inicializa el bot
            /ayuda Te ofrece apoyo
            /noticias Muestra noticias acerca de cualquier deporte
            /fecha Muestra la fecha actual
            /hora Muestra la hora actual
            /help Muestra esta ayuda';
            sendMessage($chatId, $response, FALSE);
            break;
        case '/noticias':
            $keyboard = array('keyboard' =>
            array(array(
                array('text'=>'futbol','callback_data'=>"1"),
            ),
            array(
                array('text'=>'formula1','callback_data'=>"2"),
            ),
            array(
                array('text'=>'tenis','callback_data'=>"3"),
            ),
            array(
                array('text'=>'golf','callback_data'=>"4"),
            ),
            array(
                array('text'=>'boxeo','callback_data'=>"4"),
            ),
                array(
                    array('text'=>'nfl','callback_data'=>"5")
                )), 'one_time_keyboard' => false, 'resize_keyboard' => true
        );
        file_get_contents('https://api.telegram.org/bot5190510451:AAEB_CmkxY-VXdoB8Fkwznrb3SVb_8YKhHc/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($keyboard).'&text=Escoja un deporte por teclado');
            break;
           /* case '/enlaces':
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
                file_get_contents('https://api.telegram.org/bot5190510451:AAEB_CmkxY-VXdoB8Fkwznrb3SVb_8YKhHc/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($keyboard).'&text=Elija que desea hacer');
                break;
         case '/ayuda':
            $response = "Tranquilo, estoy contigo.";
            $teclado = ["https://www.youtube.com/"],["Pos Ok"],["Pos Ok"];
            sendMessage($chatId, $response, $teclado);
            break;*/
        case 'futbol':
            getNoticias($chatId, 1);
            break;
            case 'formula1';
            getNoticias($chatId, 2);
          break;
          case 'basket':
            getNoticias($chatId, 3);
         break;
         case 'golf':
            getNoticias($chatId, 4);
        break;
        case 'boxeo':
            getNoticias($chatId, 5);
        break;
        case 'nfl':
            getNoticias($chatId, 6);
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

function getNoticias($chatId, $buscar){
 
    //include("simple_html_dom.php");
 
    $context = stream_context_create(array('https' =>  array('header' => 'Accept: application/xml')));
    switch($buscar){
    case '1':
    $url = "https://e00-marca.uecdn.es/rss/futbol/barcelona.xml";
    break;
    case '2':
    $url = "https://as.com/rss/motor/formula_1.xml";
    break;
    case '3':
    $url = "https://as.com/rss/baloncesto/nba.xml";
    break;
    case '4':
    $url = "https://as.com/rss/masdeporte/golf.xml";
    break;
    case '5':
    $url = "https://as.com/tag/rss/boxeo/a/";
    break;
    case '6':
        $url = "https://as.com/rss/masdeporte/nfl.xml";
        break;
    default:
    break;
    }
    $xmlstring = file_get_contents($url, false, $context);
 
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);
    
    $titulos = $titulos."\n\n".$array['channel']['title']."<a href='".$array['channel']['title']['item']['1']['link']."'> +info</a>";
    $titulos1 = $titulos1."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['2']['link']."'> +info</a>";
    $titulos2 = $titulos2."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['3']['link']."'> +info</a>";
    $titulos3 = $titulos3."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['4']['link']."'> +info</a>";
    $titulos4 = $titulos4."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['5']['link']."'> +info</a>";
    $titulos5 = $titulos5."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['6']['link']."'> +info</a>";
    $titulos6 = $titulos6."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['7']['link']."'> +info</a>";
    $titulos7 = $titulos7."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['8']['link']."'> +info</a>";
    $titulos8 = $titulos8."\n\n".$array['channel']['title']."<a href='".$array['channel']['item']['9']['link']."'> +info</a>";
    
    
    sendMessage($chatId, $titulos, FALSE);
    sendMessage($chatId, $titulos1, FALSE);
    sendMessage($chatId, $titulos2, FALSE);
    sendMessage($chatId, $titulos3, FALSE);
    sendMessage($chatId, $titulos4, FALSE);
    sendMessage($chatId, $titulos5, FALSE);
    sendMessage($chatId, $titulos6, FALSE);
    sendMessage($chatId, $titulos7, FALSE);
    sendMessage($chatId, $titulos8, FALSE);

 
}

?>

