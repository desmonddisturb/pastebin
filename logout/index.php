<?php
	include("../parts/header.php");
?>
<div id="content_left">
	<div class="layout_clear"></div>
	<div class="content_title">Logout Page</div>
<?php
	// освобождаем все переменные сессии
	$_SESSION = array();
	// уничтожаем сессию
	session_destroy();
	echo '<script type="text/javascript">window.location.href="/";</script>';
?>
	<form class="login_form" id="myform" method="post" action="/login/">
	<input name="submit_hidden" value="submit_hidden" type="hidden">
	<div class="form_frame_left">			
		<div class="content_text" style="clear:left">
			<div id="notice">You are currently not logged in, this means you can not edit or delete anything you paste. <a href="/signup">Sign Up</a> or <a href="/login">Login</a></div>
		</div>
	</div>
	</form>
	<div style="margin:10px 0;clear:left"></div>
</div>
<?php include("../parts/footer.php");?>