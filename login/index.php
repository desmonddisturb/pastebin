<?php
	include("../parts/header.php");
	if(isset($_POST['user_name'])){$user_name = $_POST['user_name']; if ($user_name == '') { unset($user_name);} }
	//заносим введенный пользователем логин в переменную $user_name, если он пустой, то уничтожаем переменную
	if(isset($_POST['user_password'])){$user_password=$_POST['user_password']; if ($user_password =='') { unset($user_password);} }
	//заносим введенный пользователем пароль в переменную $user_password, если он пустой, то уничтожаем переменную
?>
<div id="content_left">
	<div class="layout_clear"></div>
	<div class="content_title"><?php echo $msg["Login Page"]; ?></div>
<?php
	if(empty($user_name) and empty($user_password) and empty($_POST['security_code']))
	{
	}
	elseif(empty($user_name)) //если пользователь не ввел логин, то выдаем ошибку
	{
		echo '<div class="content_text"><div id="error">'.$msg["There was an error with your login details"].'.</div></div>';
	}
	elseif(empty($user_password)) //если пользователь не ввел пароль, то выдаем ошибку
	{
		echo '<div class="content_text"><div id="error">'.$msg["There was an error with your password details"].'.</div></div>';
	}
	//если пользователь ввел логин и пароль, но ошибся в капче
	elseif($_SESSION['security_code'] != $_POST['security_code'] or empty($_SESSION['security_code'])) 
	{
		echo '<div class="content_text"><div id="error">'.$msg["There was an error with your captcha details"].'.</div></div>';
	}
	//если пользователь ввел логин, пароль и правильную капчу, то обрабатываем их
	else
	{
		$user_name = stripslashes($user_name);
		$user_name = htmlspecialchars($user_name);
		$user_password = stripslashes($user_password);
		$user_password = htmlspecialchars($user_password);
		//удаляем лишние пробелы
		$user_name = trim($user_name);
		$user_password = trim($user_password);
		//извлекаем из базы все данные о пользователе с введенным логином
		$result = mysql_query("SELECT * FROM users WHERE login='$user_name'",$db);
		$myrow = mysql_fetch_array($result);
		if(empty($myrow['password']))
		{
			//если пользователя с введенным логином не существует
			echo '<div class="content_text"><div id="error">'.$msg["There was an error with your login or password details"].'.</div></div>';
		}
		else
		{
			//если существует, то сверяем пароли
			if($myrow['password'] == $user_password)
			{
				//если пароли совпадают, то запускаем пользователю сессию.
				$_SESSION['login'] = $myrow['login']; 
				$_SESSION['id'] = $myrow['id'];
				$_SESSION['language'] = $myrow['language'];
				echo '<script type="text/javascript">window.location.href="/u";</script>';
			}
			else
			{
				//если пароли не сошлись
				echo '<div class="content_text"><div id="error">'.$msg["There was an error with your login or password details"].'.</div></div>';
			}
		}
	}
?>
	<form class="login_form" id="myform" method="post" action="/login/">
	<input name="submit_hidden" value="submit_hidden" type="hidden">
	<div class="form_frame_left">			
		<div class="form_frame">
			<div class="form_left">
				<?php echo $msg["Username"]; ?>:
			</div>
			<div class="form_right">
				<input type="text" name="user_name" maxlength="20" size="20" value="<?php echo $_POST['user_name']; ?>" class="post_input"> 
			</div>
		</div>
		<div class="form_frame">
			<div class="form_left">
				<?php echo $msg["Password"]; ?>:
			</div>
			<div class="form_right">
				<input type="password" name="user_password" size="20" value="<?php echo $_POST['user_password']; ?>" class="post_input"> 
			</div>
		</div>
		<div class="form_frame">
			<div class="form_left">
				<?php echo $msg["Captcha Image"]; ?>:
			</div>
			<div class="form_right">
				<img id="siimage" src="/parts/CaptchaSecurityImages.php?width=100&amp;height=35&amp;characters=4&amp;b=0.31694316607899964"> <img style="cursor:pointer" src="/i/reload.png" title="Reload captcha image" alt="" onclick="document.getElementById('siimage').src = '/parts/CaptchaSecurityImages.php?width=100&amp;height=35&amp;characters=4&amp;b=' + Math.random(); return false" align="bottom" border="0"><br>
			</div>
		</div>
		<div class="form_frame">
			<div class="form_left">
				<?php echo $msg["Enter Captcha"]; ?>:
			</div>
			<div class="form_right">
				<input class="post_input" type="text" name="security_code" size="8" value="">
			</div>
		</div>
		<div class="form_frame">
			<div class="form_left">
				&nbsp;
			</div>
			<div class="form_right">
				<input name="submit" type="submit" value="<?php echo $msg["Login2"]; ?>" class="button1 btnbold">
			</div>
	</div>
	</form>
	<div style="margin:10px 0;clear:left"></div>
</div>
<?php include("../parts/footer.php");?>