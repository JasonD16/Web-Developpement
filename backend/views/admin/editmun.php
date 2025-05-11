<?php

$msg='';
if(isset($_SESSION['msg']))
{
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
}

require_once('header.php');

$view = $header . <<<HTHT
    <title>Edit Municipality</title>
  </head>
  <body class="body_edit">
HTHT;
require_once('navbar.php');
$view .= $navbar . <<<HTHT
    <h1 class="Add_title">Editting municipality</h1>
    <h1>{$msg}</h1>
    <div class="Add_input_form">
      <form action="/Elections/mun/edit/{$name}" method="post">
        <h1 class="form_title">Details</h1>
        <br />
        <label class="Add_input_titles"
          >Name:<br /><input
            class="Add_input_window"
            type="text"
            name="mun_name"
            value="{$name}" 
            required/></label
        ><br />
        <label class="Add_input_titles"
          >Province:<br /><input
            class="Add_input_window"
            type="text"
            name="province"
            value="{$province}" 
            required
            /></label
        ><br />
        <label class="Add_input_titles"
          >Caza:<br /><input
            class="Add_input_window"
            type="text"
            name="caza"
            value="{$caza}" 
            required
            /></label
        ><br />
        <label class="Add_input_titles"
          >Population:<br /><input
            class="Add_input_window"
            type="text"
            name="population"
            value="{$population}" 
            required
            /></label
        ><br />
        <label class="Add_input_titles"
          >Total voters:<br /><input
            class="Add_input_window"
            type="text"
            name="total_voters"
            value="{$voters}"
            required
        /></label>      
        <input class="Add_input_titles" type="submit" value="Edit" />
      </form>
    </div>
  </body>
</html>

HTHT;