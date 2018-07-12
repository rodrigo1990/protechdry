<?php
require_once('../sdk-php-master-mp/lib/mercadopago.php');

$mp = new MP("2432331329673456", "p5gRcbb3ZtaLPIpDLXaFJOgiUHxCLHwe");

  $body = array(
      "site_id" => "MLA"
  );

  $result = $mp->post('/users/test_user', $body);

  var_dump($result);
?>