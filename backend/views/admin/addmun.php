<?php

$msg='';
if(isset($_SESSION['msg']))
{
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
}

require_once('header.php');

$view = $header . <<<HTHT
    <title>Add Municipality</title>
  </head>
  <body class="Add_body">
HTHT;
require_once('navbar.php');
$view .= $navbar . <<<HTHT
    <h1 class="Add_title">Adding municipality</h1>
    <h1>{$msg}</h1>
    <form 
      class="Add_input_form" 
      action="/elections/mun/add"
      method="post"         
      enctype="multipart/form-data">
      <h1 class="form_title">Details</h1>
      <br />
      <label class="Add_input_titles"
        >Name:<br /><input
          class="Add_input_window"
          type="text"
          name="mun_name"
          required /></label
      ><br />
      <label class="Add_input_titles"
        >Province:<br /><input
          class="Add_input_window"
          type="text"
          name="province"
          required /></label
      ><br />
      <label class="Add_input_titles"
        >Caza:<br /><input
          class="Add_input_window"
          type="text"
          name="caza"
          required /></label
      ><br />
      <label class="Add_input_titles"
        >Population:<br /><input
          class="Add_input_window"
          type="text"
          name="population"
          required /></label
      ><br />
      <label class="Add_input_titles"
        >Total voters:<br /><input
          class="Add_input_window"
          type="text"
          name="total_voters"
          required
      /></label>
      <input
          class="Add_input_window"
          type="file"
          name="image"
          required
      />
      <br />
      <input class="Add_input_titles" type="submit" value="ADD" />
    </form>
  </body>
</html>

HTHT;