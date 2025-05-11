<?php

require_once('backend\views\admin\header.php');

$view = $header . <<<HTHT
    <title>Candidates</title>
  </head>
  <body class="Can_body">
HTHT;
require_once('backend\views\admin\navbar.php');
$mun = ucwords($mun);
$view .= $navbar . <<<HTHT
<h1 class="Candidates">
      {$mun} Candidates
      <a class="add_candidates" href="/Elections/admin/showAdd/">Add</a>
    </h1>
    <div>
      <ul>
HTHT;
$view .= $cand . <<<HTHT
      </ul>
    </div>
  </body>
</html>

HTHT;

?>