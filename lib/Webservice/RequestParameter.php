<?php namespace WcCoordinadora\Webservice;

class RequestParameter
{
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
