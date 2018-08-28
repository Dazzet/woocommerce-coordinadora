<?php namespace WcCoordinadora\Webservice;

use SoapClient;

/**
 * Methods of http://sandbox.coordinadora.com/ags/1.4/server.php?doc#Type_void
 */
class Ags
{
    /** @var string wsdl path (https or file) */
    private $wsdl;

    /** @var SoapClient Soap client */
    private $client;

    /** @var string Name of the Soap action to execute on next request */
    private $action;

    /** #var RequestParameter The parameters for the next call */
    private $requestParameters = null;

    /**
     * Creates an unique instance of the Ags WebService client
     * @param string $wsdl Path (local or http(s) ) to the WSDL description
     * @link http://sandbox.coordinadora.com/ags/1.4/server.php?doc
     */
    static function instance(SoapClient $client)
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new self($client);
        }
        return $obj;
    }

    private function __construct(SoapClient $client)
    {
        $this->client = $client;
    }

    /**
     * Initialize elements
     */
    public function start()
    {
        return $this;
    }

    /**
     * Unique getter of variables
     * @param string $name Name of the variable to retreive
     */
    public function get(string $action)
    {
        $this->action = $action;
        return $this;
    }


    /**
     * Unique setter
     * if $name is an array, you can set multiple variables at onece
     *
     * @param string|array $name The name of the variable to set
     * @param mixed $value the value to set ONLY if $name is not an array
     */
    public function set( RequestParameter $parameters)
    {
        $this->requestParameters = $parameters;
        return $this;
    }

    public function with(RequestParameter $parameters)
    {
        return $this->set($parameters);
    }

    /**
     * Execute $this->action with $this->requestParameters on the remote
     * webservice
     */
    public function exe()
    {
        switch ($this->action) {
        case 'departamentos':
            $res = $this->client->Cotizador_departamentos();
            $this->result = $res->Cotizador_departamentosResult->item;
            break;
        case 'ciudades':
            $res = $this->client->Cotizador_ciudades();
            $this->result = $res->Cotizador_ciudadesResult->item;
            break;
        case 'seguimiento':
            if (empty($this->requestParameters)) {
                throw new Exeption(__('You can not call exe() without parameters', 'wc-coordinadora'));
            }
            $res = $this->client->Seguimiento_detallado(array('p' => $this->requestParameters));
            $this->result = $res->Cotizador_departamentosResult->item;
        }

        return $this;
    }

    /**
     * Prints whatever it is in $this->result. Very useful for debuggin
     */
    public function printR()
    {
        print_r($this->result);

        return $this;
    }

    public function result()
    {
        return $this->result;
    }

}
