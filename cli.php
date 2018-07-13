<?php namespace WCCoordinadora;

include __DIR__ . '/lib/autoload.php';

$client = new \SoapClient('http://sandbox.coordinadora.com/ags/1.4/server.php?wsdl');

Webservice\Ags::instance($client)
    ->start()
    ->exe('departamentos')
    ->printR()
    ->exe('ciudades')
    ->printR();
