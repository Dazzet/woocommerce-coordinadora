<?php namespace WCCoordinadora;

include __DIR__ . '/lib/autoload.php';

Webservice\Ags::instance('http://sandbox.coordinadora.com/ags/1.4/server.php?wsdl')
    ->start()
    ->exe('departamentos')
    ->printR()
    ->exe('ciudades')
    ->printR();
