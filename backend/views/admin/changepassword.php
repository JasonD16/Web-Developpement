<?php

$msg='';
if(isset($_SESSION['msg']))
{
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
} 

require_once('header.php');

$view = $header . <<<HTHT
    <title>Change password</title>
  </head>
  <body id="login">
HTHT;
require_once('navbar.php');
$view .= $navbar . <<<HTHT
    <div class="login_form">
      <h1 class="login">Change Password</h1>
      <form class="_form" action="/Elections/admin/changepass" method="POST">
        <label class="login_titles"
          >Old Password:<br />
          <input
            class="login_input"
            type="password"
            name="oldpass"
            placeholder="password"
            required
        /></label>
        <br />
        <label class="login_titles"
          >New Password:<br />
          <input
            class="login_input"
            type="password"
            name="newpass1"
            placeholder="password"
            required
        /></label>
        <br />
        <label class="login_titles"
          >Confirm Password:<br />
          <input
            class="login_input"
            type="password"
            name="newpass2"
            placeholder="password"
            required
        /></label>
        <br />
        <input class="login_titles" type="submit" value="Change" />
      </form>
      <h1>{$msg}</h1>
    </div>
  </body>
</html>

HTHT;