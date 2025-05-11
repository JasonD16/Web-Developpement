<?php

require_once('header.php');

$view1 = $header . <<<HTHT
    <title>Municipality Layout</title>
  </head>
  <body id="mun_layout_body">
HTHT;
require_once('navbar.php');
$view = $view1 . $navbar . <<<HTHT
<!-- Municipalities grid -->
    <div id="mun_start">
      <div class="mun_candidates_details">
        <h2 class="mun_candidate_title">{$munName}</h2>
        <br />
        <ul>
          <li class="mun_li">
            <span class="details_titles">Province: </span>
            <span class="details">{$province}</span>
          </li>
          <li class="mun_li">
            <span class="details_titles">Caza: </span
            ><span class="details">{$caza}</span>
          </li>
          <li class="mun_li">
            <span class="details_titles">Population: </span
            ><span class="details">{$population}</span>
          </li>
          <li class="mun_li">
            <span class="details_titles">Total voters: </span
            ><span class="details">{$voters}</span>
          </li>
        </ul>
      </div>
      <div class="mun_candidates_details">
        <h2 class="mun_candidate_title">Candidates</h2>
HTHT;
$view .= $candView . <<<HTHT
        <br />
        <div class="extra">
          Blank Votes: <span class="details">{$blanks}</span>
        </div>
        <div class="extra">
          Total votes: <span class="details">{$total_votes}</span>
        </div>
      </div>
    </div>
  </body>
</html>
HTHT;

return $view;
?>