<?php namespace WcCoordinadora;

ini_set("soap.wsdl_cache_enabled", 0);

include __DIR__ . '/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$client = new \SoapClient(getenv('WSDL_AGS'), array('trace' => 1));

$in = Webservice\RequestParameter::instance()
    ->set('codigo_remision', '85110000010')
    ->set('nit', getenv('NIT'))
    ->set('div', '02')
    ->set('referencia', '')
    ->set('imagen', 1)
    ->set('anexo', 1)
    ->set('apikey', getenv('APIKEY'))
    ->set('clave', getenv('CLAVE'));


Webservice\Ags::instance($client)
    ->start()
    ->exe('seguimiento', $in)
    ->printR();

