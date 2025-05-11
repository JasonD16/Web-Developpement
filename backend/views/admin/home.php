<?php

require_once('header.php');

$view = $header . <<<HTHT
    <title>CMS</title>
  </head>
  <body class="body_CMS">
HTHT;
require_once('navbar.php');
$view .= $navbar . <<<HTHT
    <h1 class="Municipality_Managment">
      Municipalities<a class="add" href="/Elections/admin/mun">Add municipality</a>
    </h1>
    <ul>
HTHT;
$view .= $mun . <<<HTHT
  </ul>
  </body>
</html>

HTHT;