<?php
require_once('header.php');

$view1 = $header . <<<HTHT
    <title>Jason's E-voting website</title>
  </head>
  <body id="body_main">   
HTHT;
require_once('navbar.php');
$view = $view1 . $navbar . <<<HTHT
    <!-- Municipalities grid -->
    <div>
      <div class="Start_Main">
      {$munView}
      </div>
    </div>
  </body>
</html>
HTHT;
?>