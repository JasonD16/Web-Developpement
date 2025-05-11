<?php

$msg = '';
if(isset($_SESSION['msg']))
{
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
}

require_once('header.php');

$view = $header . <<<HTHT
    <title>Edit Candidate</title>
  </head>
  <body class="body_Edit_Can">
HTHT;
require_once('navbar.php');
$view .= $navbar . <<<HTHT
    <h1 class="Add_candidate_title">EDIT CANDIDATE</h1>

    <div class="add_can_div">
      <form
        class="form_Add_candidate"
        action="/elections/cand/edit/"
        method="post"
        enctype="multipart/form-data"
      >
        <label class="label_can"
          >Name:<br /><input
            class="input_Can"
            type="text"
            name="name"
            required
          /> </label
        ><label class="label_can"
          >Middle Name:<br /><input
            class="input_Can"
            type="text"
            name="middle_name"
            required
          /> </label
        ><label class="label_can"
          >Family Name:<br /><input
            class="input_Can"
            type="text"
            name="family_name"
            required
          /> </label
        ><label class="label_can"
          >Municipality name:<br /><input
            class="input_Can"
            type="text"
            name="municipality"
            required
          /> </label
        ><br />
        <br />
        <label class="label_can"
          >Photo:<br /><input
            class="file_can"
            type="file"
            name="image"
            required /></label
        ><br /><br><br /><input
          class="label_can"
          type="submit"
          value="add"
        />
      </form>
      <h1>{$msg}</h1>
    </div>
    <br />
  </body>
</html>

HTHT;