<?php

ini_set("soap.wsdl_cache_enabled", 0);

use WcCoordinadora\Webservice\Ags;
use WcCoordinadora\Webservice\RequestParameter;

class AgsTest extends PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
        $dotenv->load();

        $client = new \SoapClient(getenv('WSDL_AGS'), array('trace' => 1));

        $this->para = RequestParameter::instance()
            ->set('nit', getenv('NIT'))
            ->set('imagen', 1)
            ->set('anexo', 1)
            ->set('apikey', getenv('APIKEY'))
            ->set('clave', getenv('CLAVE'));

        $this->ags = Ags::instance($client)->start();
    }

    public function testDepartamentosReturnsArrayOfObjects()
    {
        $res = $this->ags->exe('departamentos');
        $this->assertInstanceOf('stdClass', $res->result);
        $this->assertObjectHasAttribute('Cotizador_departamentosResult', $res->result);
    }

    public function testDepartamentosReturnsAntioquia()
    {
        $res = $this->ags->exe('departamentos');

        // Buscamos un objeto que tenga el item antioquia
        $out = array_reduce($res->result->Cotizador_departamentosResult->item, function($carry, $item){
            return $carry || ($item->nombre == 'Antioquia');

        }, false);

        $this->assertTrue($out);
    }

    public function testCiudadesReturnsMedellin()
    {
        $res = $this->ags->exe('ciudades');

        // Buscamos un objeto que tenga el item Ciudades
        $out = array_reduce($res->result->Cotizador_ciudadesResult->item, function($carry, $item){
            return $carry || ($item->nombre == 'MEDELLIN (ANT)');

        }, false);

        $this->assertTrue($out);
    }
}

