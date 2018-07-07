<?php namespace WCCoordinadora\Webservice;

use SoapClient;

/**
 * Methods of http://sandbox.coordinadora.com/ags/1.4/server.php?doc#Type_void
 */
class Ags
{
    /** @var string wsdl path (https or file) */
    private $wsdl;

    /** @var SoapClietn Soap client */
    private $client;

    /** @ var bool Is the current object initialized? */
    private $_initialized = false;

    /**
     * Creates an unique instance of the Ags WebService client
     * @param string $wsdl Path (local or http(s) ) to the WSDL description
     * @link http://sandbox.coordinadora.com/ags/1.4/server.php?doc
     */
    static function instance($wsdl)
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new Ags($wsdl);
        }
        return $obj;
    }

    private function __construct($wsdl)
    {
        $this->wsdl = $wsdl;
    }

    /**
     * Initialize elements
     */
    public function start()
    {
        if (!$this->_initialized) {
            $this->client = new SoapClient($this->wsdl);
            $this->_initialized = true;
        }
        return $this;
    }

    /**
     * Unique getter of variables
     * @param string $name Name of the variable to retreive
     */
    public function get($name)
    {
        if (!in_array(array('client', '_initialized'))) {
            return $this->$name;
        }
    }

    /**
     * Unique setter
     * if $name is an array, you can set multiple variables at onece
     *
     * @param string|array $name The name of the variable to set
     * @param mixed $value the value to set ONLY if $name is not an array
     */
    public function set($name, $value = null)
    {
        if (!is_array($name)) {
            $name = array($name => $value);
        }
        foreach ($name as $k => $v) {
            if (!in_array(array('client', 'result', '_initialized'))) {
                $this->$k = $v;
            }
        }
        return $this;
    }

    /**
     * Name of the method to execute
     * Here is the list of methods http://sandbox.coordinadora.com/ags/1.4/server.php?doc
     * @link http://sandbox.coordinadora.com/ags/1.4/server.php?doc
     * @param string $method Method to execute WITHOUT Cotizador_|Recaudos_|Recogidas_|Segimiento_ sufix
     * @param array $parameters Any parameters that the webservice requires as an associative array
     *
     */
    public function exe($method, $parameters = null)
    {
        switch ($method) {
        case 'departamentos':
            $this->result = $this->client->Cotizador_departamentos();
            break;
        case 'ciudades':
            $this->result = $this->client->Cotizador_ciudades();
            break;
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


}
