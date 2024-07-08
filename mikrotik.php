<?php
require('routeros_api.class.php');

$API = new RouterosAPI();

if ($API->connect('192.168.88.1', 'admin', 'password')) {
    $API->comm("/ip/hotspot/user/add", array(
        "name"     => "user1",
        "password" => "password",
        "profile"  => "default"
    ));

    $API->disconnect();
}
?>
