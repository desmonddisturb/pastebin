<?php
	if($_GET['del'])
	{
		session_start();
		$db = mysql_connect ("localhost","root","pastebin1");
		mysql_select_db ("pastebin",$db);
		$result = mysql_query("SELECT * FROM pastes WHERE id_paste={$_GET['del']}",$db);
		$myrow = mysql_fetch_array($result);
		if($myrow["id_paste"] and (($myrow["id_user"] == $_SESSION['id']) or ($myrow["code_paste"] == $_SESSION['code_paste'])))
		{
			mysql_query("DELETE FROM pastes WHERE id_paste={$_GET['del']}",$db);
			if($myrow["id_user"] == $_SESSION['id'])
			{
				header('Location: http://pastebin.pp.ua/u/');
			}
			else
			{
				header('Location: http://pastebin.pp.ua/');
			}
		}
		else
		{
			header('Location: http://pastebin.pp.ua/');
		}
	}
	else
	{
		header('Location: http://pastebin.pp.ua/');
	}
?>