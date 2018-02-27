<?php

namespace MIAFirebase;

use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;
use Zend\Json\Json;

/**
 * Description of Messaging
 *
 * @author matiascamiletti
 */
class Messaging 
{
    /**
     * Almacena la URL base.
     */
    protected $baseUrl = 'https://fcm.googleapis.com/fcm/send';
    /**
     *
     * @var string APP_KEY
     */
    public $apiKey = '';
    /**
     * Constructor que recibe la API_KEY
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    /**
     * Funcion que se encarga de enviar una notificacion a un topico
     * @param array $topic
     * @param int $pushType
     * @param array $data
     * @return boolean
     */
    public function sendToTopic($topic, $pushType, $data = array())
    {
        // Agregamos el type a los datos
        $data['push_type'] = $pushType;
        // Creamos la peticion con los parametros necesarios
        $request = $this->generateRequest(array(
            'to' => '/topics/'.$topic,
            'data' => $data,
        ));
        // Ejecutamos la petición
        $response = $this->dispatchRequest($request);
        
        return $response;
    }
    /**
     * Funcion que se encarga de enviar una notificacion a los dispositivos elegidos
     * @param array $tokens
     * @param int $pushType
     * @param array $data
     * @return boolean
     */
    public function sendToDevices($tokens, $pushType, $data = array())
    {
        // Verificar si se enviaron tokens
        if(count($tokens) == 0){
            return false;
        }
        // Agregamos el type a los datos
        $data['push_type'] = $pushType;
        // Creamos la peticion con los parametros necesarios
        $request = $this->generateRequest(array(
            'registration_ids' => $tokens,
            'data' => $data
        ));
        // Ejecutamos la petición
        $response = $this->dispatchRequest($request);

        return $response;
    }
    /**
     * Realiza la peticion y devuelve los parametros
     * @param Request $request
     * @return array
     */
    protected function dispatchRequest($request)
    {
        $client = new Client();
        $response = $client->dispatch($request);
        return Json::decode($response->getBody());
    }
    /**
     * Genera un request con el path y los parametros
     * @param string $path
     * @param array $params
     * @return Request
     */
    protected function generateRequest($params)
    {
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'Authorization' => 'key=' . $this->apiKey
        ));
        $request->setUri($this->baseUrl);
        $request->setMethod(Request::METHOD_POST);
        $request->setContent(Json::encode($params));
        $request->setPost(new Parameters($params));
        
        return $request;
    }
}
