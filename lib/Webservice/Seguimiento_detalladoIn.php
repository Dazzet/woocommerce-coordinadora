<?php namespace WcCoordinadora\Webservice;

class Seguimiento_detalladoIn
{
    public $codigo_remision;
    public $nit;
    public $div = '';
    public $referencia = '';
    public $imagen;
    public $anexo;
    public $apikey;
    public $clave;

    static function instance()
    {
        static $obj;
        if (!isset($obj)) {
            $obj = new self();
        }
        return $obj;
    }

    public function set($name, $value)
    {
        $this->$name = $value;
        return $this;
    }
}
