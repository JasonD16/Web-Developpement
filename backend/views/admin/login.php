<?php

require_once('header.php');
$msg ='';
if(isset($_SESSION['msg']))
  {$msg = $_SESSION['msg'];}

$view = $header . <<<HTHT
    <title>CMS Login</title>
  </head>
  <body id="login">
    <h1 class="login_title">Jason's E-voting website CMS</h1>
    <div class="login_form">
    {$msg}
      <h1 class="login">LOGIN</h1>
      <form class="_form" action="/Elections/admin/dologin" method="Post">
        <label class="login_titles"
          >Username:<br />
          <input
            class="login_input"
            type="email"
            name="email"
            placeholder="username@gmail.com"
            required
        /></label>
        <br />
        <label class="login_titles"
          >Password:<br />
          <input
            class="login_input"
            type="password"
            name="password"
            placeholder="password"
            required
        /></label>
        <br />
        <input class="login_titles" type="submit" value="login" />
      </form>
    </div>
  </body>
</html>

HTHT;