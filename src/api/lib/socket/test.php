<?php
require 'SocketClient.php';

$client = new SocketClient("127.0.0.1", 55056);

$output = new DataOutputStream();
$output->writeInt(1);
$output->writeDouble(4.2);
// $output->writeBoolean(true);

$client->send($output);
$client->disconnect();
