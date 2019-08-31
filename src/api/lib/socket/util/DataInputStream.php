<?php

class DataInputStream
{

    private $length;

    private $data;

    function __constructor($data)
    {
        $this->data = $data;
        $this->length = $this->readInt();
    }

    public function getLength()
    {
        return $this->length;
    }

}
