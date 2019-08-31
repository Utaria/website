<?php

class DataOutputStream
{

    private $length;

    private $data;

    function __constructor()
    {
        $this->length = 0;
        $this->data = "";
    }


    public function getLength()
    {
        return $this->length;
    }

    public function close()
    {
        $this->length = 0;
        $this->data = "";
    }

    public function write($byteArray)
    {
        $this->data .= $byteArray;
        $this->length += strlen($byteArray);
    }

    public function writeBoolean($boolean)
    {
        $this->data .= pack("C", bindec($boolean));
        $this->length += 1;
    }

    public function writeByte($byte)
    {
        $this->data .= pack("C", $byte);
        $this->length += 1;
    }

    public function writeChar($ch)
    {
        $this->data .= pack("c", $ch);
        $this->length += 2;
    }

    public function writeDouble($db)
    {
        $this->data .= strrev(pack("d", $db));
        $this->length += 8;
    }

    public function writeFloat($f)
    {
        $this->data .= strrev(pack("f", $f));
        $this->length += 4;
    }

    public function writeInt($i)
    {
        $this->data .= pack("N", $i);
        $this->length += 4;
    }

    public function writeLong($l)
    {
        $this->data .= pack("J", $l);
        $this->length += 8;
    }

    public function writeShort($s)
    {
        $this->data .= pack("n", $s);
        $this->length += 2;
    }

    public function writeUTF($str)
    {
        $utflen = 0;

        // On calcule la longueur de la chaîne en fonction des caractères qui la compose
        for ($i = 0; $i < mb_strlen($str, 'UTF-8'); $i++) {
            $c = mb_substr($str, $i, 1, "utf-8");
            $ord = ord($c);

            if (($ord >= hexdec("0x0001")) && ($ord <= hexdec("0x007F"))) {
                $utflen++;
            } else if ($ord > hexdec("0x07FF")) {
                $utflen += 3;
            } else {
                $utflen += 2;
            }
        }

        // On écrit d'abord la longueur de la chaîne
        $this->writeShort($utflen);

        // Puis on écrit la chaîne
        $this->data .= pack("A*", $str);
        $this->length += $utflen;
    }

    public function toByteArray()
    {
        return pack("N", $this->length) . $this->data;
    }

}
