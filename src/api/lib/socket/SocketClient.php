<?php
require 'util/DataOutputStream.php';
require 'util/DataInputStream.php';
require 'Packet.php';

class SocketClient
{

    private $socket;

    private $output;

    private $input;

    private $host;

    private $port;

    function __construct($host = "127.0.0.1", $port = 1234)
    {
        $this->host = $host;
        $this->port = $port;

        $this->connect();
    }


    public function isConnected()
    {
        return $this->socket != null && $this->socket !== FALSE;
    }


    private function connect()
    {
        $this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 5) or $this->error("connexion à l'adresse " . $this->host . ":" . $this->port . " impossible !");

        $this->output = new DataOutputStream();
        $this->input = new DataInputStream();
    }

    public function disconnect()
    {
        if ($this->socket == null) return false;

        fclose($this->socket);
        $this->socket = null;

        return true;
    }


    public function sendPacket($packet)
    {
        if (!($packet instanceof SendingPacket) || !$this->connected) return false;

        try {
            $packet->process();
            $packet->serialize();

            $this->output->write($packet->getData());
            $packet->close();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function send($output)
    {
        fwrite($this->socket, $output->toByteArray());
    }


    private function error($message)
    {
        throw new Exception($message);
    }

}
