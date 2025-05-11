<?php
require_once('header.php');

$msg = '';
if(isset($_SESSION['msg']))
{
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']); 
}

$view1 = $header . <<<HTHT
    <title>Contact Us</title>
  </head>
  <body class="Contact_body">
HTHT;
require_once('navbar.php');
$view = $view1 . $navbar . <<<HTHT
    <br>
    <div class="Contact_window">
      <div id="Contact_Us_title"><h1 id="title">Contact Us</h1></div>
      <div id="Contact_Us_input_window">
        <br />
        <div class="msg">{$msg}</div>
        <form action="/Elections/user/msg" method="post" enctype="multipart/form-data">
          <label class="input_titles"
            >Full name:
            <input class="input_window" type="text" name="username" required />
          </label>
          <br />
          <label class="input_titles"
            >Email:
            <input class="input_window" type="email" name="email" required
          /></label>
          <br /><br />
          <label class="input_titles">
            Phone Number:
            <input
              class="input_window"
              type="text"
              name="phone_number"
              required
            />
          </label>
          <br />
          <label class="input_titles"
            >Subject<input
              class="input_window"
              type="text"
              name="subject"
              required
          /></label>
          <label class="input_titles">
            Message:
            <textarea class="input_window" rows="4" name="msg" required></textarea>
          </label>
          <br />
          <label class="input_titles"
            ><input type="submit" value="send"
          /></label>
        </form>
      </div>
    </div>
  </body>
</html>
HTHT;
?>
