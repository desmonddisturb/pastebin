<?php
	include("../parts/header.php");
	if($_POST['user_menu_2'])
	{
		$_SESSION['language'] = $_POST['user_menu_2'];
		if($_SESSION['login'])
		{
			// в базе меням язык данного пользователя
			$result = mysql_query("UPDATE users SET language={$_SESSION['language']} WHERE id={$_SESSION['id']}",$db);
		}
	}
?>
<div id="content_left">
	<div class="layout_clear"></div>
	<div class="content_title"><?php echo $msg["Settings Page"]; ?></div>
	<div class="content_text"><?php echo $msg["On this page you can change various settings that change the beh"]; ?>.</div>
	<form class="settings_form" id="myform" method="post" action="/settings/">
		<input name="submit_hidden" value="submit_hidden" type="hidden">
		<div class="form_frame_left">			
			<div class="form_frame">
				<div class="form_left">
					<?php echo $msg["Site language"]; ?>: 
				</div>
				<div class="form_right">
					<select class="post_select" name="user_menu_2">
						<option value="1"<?php if($_SESSION['language'] == 1) echo ' selected="selected"';?>>English</option>
						<option value="2"<?php if($_SESSION['language'] == 2) echo ' selected="selected"';?>>Русский</option>
					</select>
				</div>
			</div>
			<div class="form_frame">
				<div class="form_left">
					&nbsp;
				</div>
				<div class="form_right">
					<input name="submit" type="submit" value="<?php echo $msg["Save Settings"]; ?>" class="button1 btnbold">
				</div>
			</div>
		</div>
	</form>
	<div style="margin:10px 0;clear:left"></div>
</div>
<?php include("../parts/footer.php");?>