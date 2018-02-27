<?php

namespace MIAFirebase\Factory;

/**
 * Description of MessagingFactory
 *
 * @author matiascamiletti
 */
class MessagingFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        // Obtenemos configuración
        $config = $container->get('Config');
        // Creamos variable que almacenara el ApiKey
        $apiKey = '';
        // Verificamos que exista la key
        if(array_key_exists('mia_firebase', $config) && array_key_exists('api_key', $config['mia_firebase'])){
            // Iniciamos un array, ya que no se encontro una configuración
            $apiKey = $config['mia_firebase']['api_key'];
        }
        // Creamos objeto
        return new Messaging($apiKey);
    }
}