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
     * @param SoapClient $client the initialized client
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
     * The infomration to get
     *
     * Ags::start($client)->get('despacho')->result()
     */
    public function get(string $action)
    {
        $this->action = $action;
        return $this;
    }


    /**
     * Sets the request parameters
     *
     * @param RequestParameter $parameters The parameters for the WebService
     */
    public function set( RequestParameter $parameters)
    {
        $this->requestParameters = $parameters;
        return $this;
    }

    /**
     * Alias of the set() function
     */
    public function with(RequestParameter $parameters)
    {
        return $this->set($parameters);
    }

    /**
     * Execute the action set on this->set($action)
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
            $this->result = $res->Seguimiento_detalladoResult;
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

    /**
     * Gets the result object
     */
    public function result()
    {
        return $this->result;
    }

}
