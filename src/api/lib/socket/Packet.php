<?php

class Packet
{

    private $input;

    private $output;

    function __construct($input)
    {
        if ($input instanceof DataInputStream)  // Paquet de récéption
            $this->input = $input;
        else {                                  // Paquet d'envoi
            $this->output = new DataOutputStream();
            // On écrit l'ID du paquet directement dans le flux d'envoi
            $this->output->writeInt($input);
        }
    }


}
