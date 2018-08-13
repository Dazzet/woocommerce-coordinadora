<?php

ini_set("soap.wsdl_cache_enabled", 0);

use WcCoordinadora\Webservice\Ags;
use WcCoordinadora\Webservice\RequestParameter;

class AgsTest extends PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        // Extract test info from .env file
        $dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
        $dotenv->load();

        $client = new \SoapClient(getenv('WSDL_AGS'), array('trace' => 1));

        // Create default parameters form the SoapRequest
        $this->para = RequestParameter::instance()
            ->set('nit', getenv('NIT'))
            ->set('div', '')
            ->set('referencia', '')
            ->set('imagen', 1)
            ->set('anexo', 1)
            ->set('apikey', getenv('APIKEY'))
            ->set('clave', getenv('CLAVE'));

        // Object that we'll actually test
        $this->ags = Ags::instance($client)->start();
    }

    public function testDepartamentosReturnsArrayOfObjects()
    {
        $res = $this->ags->get('departamentos')->exe()->result();
        $this->assertInternalType('array', $res);
    }

    public function testDepartamentosReturnsArrayOfObject()
    {
        $res = $this->ags->get('ciudades')->exe()->result();
        $this->assertInternalType('array', $res);
    }

    /**
     * @expectedException SoapFault
     */
    public function testSeguimientoDetalladoGeneratesExceptionOnEmptyParams()
    {
        $res = $this->ags->get('seguimiento')->with(new RequestParameter)->exe();
    }

    public function testSeguimientoDetallado()
    {
        $this->para->set('referencia', '00008787878');
        $this->para->set('codigo_remision', '');
        //die(print_r($this->para, true));
        $res = $this->ags->get('seguimiento')->with($this->para)->exe();
    }


}

