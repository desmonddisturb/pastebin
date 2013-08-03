<?php
	session_start();
	// считываем текущее время
	$start_time = microtime();
	// разделяем секунды и миллисекунды
	$start_array = explode(" ",$start_time);
	// это и есть стартовое время
	$start_time = $start_array[1] + $start_array[0];
	// если язык не задан, ставим по умолчанию английский
	if(!$_SESSION['language'])
	{
		$_SESSION['language'] = 1;
	}
	// подключаемся к базе
	$db = mysql_connect("localhost","root","pastebin1");
	mysql_select_db("pastebin",$db);
	mysql_query("SET CHARACTER SET 'utf8'");
	// подключаем язык сайта
	$language_line = mysql_query("SELECT * FROM languages WHERE id={$_SESSION['language']}",$db);
	$msg = mysql_fetch_array($language_line);
	// узнаём текущее время
	$now_time = time();
	// выбираем записи в которых время было заданно (не ноль) и истекло
	$result = mysql_query("SELECT * FROM pastes WHERE time_end!=0 AND time_end<{$now_time}",$db);
	while($myrow = mysql_fetch_array($result))
	{
		// удаляем все записи с истёкшим временем жизни
		mysql_query("DELETE FROM pastes WHERE id_paste={$myrow["id_paste"]}",$db);
	}
	function html_code($code) // адаптировать html для показа на страничке
	{
		$html_one = array("<", ">");
		$html_two = array("&lt;", "&gt;");
		$new_code = str_replace($html_one, $html_two, $code);
		return $new_code;
	}
	function title_check($title) // адаптировать html для показа на страничке
	{
		$new_title = str_replace(" ", "", $title);
		return $new_title;
	}
	function nicetime($ago, $second, $seconds, $seconds2, $minute, $minutes, $minutes2, $hour, $hours, $hours2, $day, $days, $days2, $month, $months, $months2, $year, $years, $years2) // подсчитываем сколько времени прошло с момента сохранения кода
	{
		if($ago < 60)
		{
			if($ago == 1)
			{
				echo '1 '.$second;
			}
			elseif($ago < 5)
			{
				echo $ago.' '.$seconds;
			}
			else
			{
				echo $ago.' '.$seconds2;
			}
		}
		elseif($ago < 3600)
		{
			$ago=round($ago/60);
			if($ago == 1)
			{
				echo '1 '.$minute;
			}
			elseif($ago < 5)
			{
				echo $ago.' '.$minutes;
			}
			else
			{
				echo $ago.' '.$minutes2;
			}
		}
		elseif($ago < 86400)
		{
			$ago=round($ago/3600);
			if($ago == 1)
			{
				echo '1 '.$hour;
			}
			elseif($ago < 5)
			{
				echo $ago.' '.$hours;
			}
			else
			{
				echo $ago.' '.$hours2;
			}
		}
		elseif($ago < 2592000)
		{
			$ago=round($ago/86400);
			if($ago == 1)
			{
				echo '1 '.$day;
			}
			elseif($ago < 5)
			{
				echo $ago.' '.$days;
			}
			else
			{
				echo $ago.' '.$days2;
			}
		}
		elseif($ago < 31536000)
		{
			$ago=round($ago/2592000);
			if($ago == 1)
			{
				echo '1 '.$month;
			}
			elseif($ago < 5)
			{
				echo $ago.' '.$months;
			}
			else
			{
				echo $ago.' '.$months2;
			}
		}
		else
		{
			$ago=round($ago/31536000);
			if($ago == 1)
			{
				echo '1 '.$year;
			}
			elseif($ago < 5)
			{
				echo $ago.' '.$years;
			}
			else
			{
				echo $ago.' '.$years2;
			}
		}
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head><meta charset="UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<title>Pastebin</title>
<link rel="shortcut icon" href="/i/favicon.ico">
<link href="/i/style.css" rel="stylesheet" type="text/css">
<meta name="description" content="Pastebin.pp.ua is a website where you can store text online for a set period of time.">
<meta property="og:description" content="Pastebin.pp.ua is a website where you can store text online for a set period of time.">
<meta property="og:title" content="Pastebin.pp.ua">
<meta property="og:type" content="article">
<meta property="og:url" content="/">
<meta property="og:image" content="/i/fb2.jpg">
<meta property="og:site_name" content="Pastebin">
<link rel="canonical" href="http://pastebin.pp.ua/">
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/main_v1.js"></script>
<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
</head>
<body>
<body>
	<div id="super_frame">
		<div id="logo" onclick="location.href='/'" title="Create New Paste"></div>
		<div id="header">
			<div id="header_top">
				<span class="span_left more"> </span><span class="span_left less"> </span>
				<ul class="top_menu">
					<li class="no_border_li"><a href="/" accesskey="n"> </a></li>
				</ul>
			</div>
			<div id="header_middle">
				<span class="span_left big"><a href="/">PASTEBIN</a></span> 				
			</div>
			<div id="header_bottom">
				<div class="div_top_menu">
					<img src="/i/t.gif" class="i_n" width="16" height="16" alt="" border="0"> <a href="/"><?php echo $msg["create new paste"]; ?></a> 
					&nbsp;&nbsp;&nbsp; <img src="/i/t.gif" class="i_t" width="16" height="16" alt="" border="0"> <a href="/trends"><?php echo $msg["trending pastes"]; ?></a>
				</div>
				<ul class="top_menu">
					<?php
						if($_SESSION['login'])
						{
							echo '<li class="no_border_li">'.$msg["Hi"].', <b>'.$_SESSION['login'].'</b></li><li><a href="/u/">'.$msg["my pastebin"].'</a></li><li><a href="/settings">'.$msg["my settings"].'</a></li><li><a href="/logout">'.$msg["logout"].'</a></li>';
						}
						else
						{
							echo '<li class="no_border_li"><a href="/signup">'.$msg["sign up"].'</a></li><li><a href="/login">'.$msg["login"].'</a></li><li><a href="/settings">'.$msg["settings"].'</a></li>';
						}
					?>
				</ul>
			</div>			
		</div>

			<div class="frame_spacer"><!-- --></div>
			<div style="height:15px;line-height:15px;font-size:0.85em;"><span style="float:right;text-align:right;"> </span></div>		<div class="frame_spacer"><!-- --></div>
		<div id="monster_frame">
			<div id="content_frame">
				<div id="content_right">
					<?php
						if($_SESSION['login'])
						{
							// выбираем все записи данного пользователя
							$result = mysql_query("SELECT * FROM pastes WHERE id_user={$_SESSION['id']} ORDER by time_start DESC LIMIT 8",$db);
							// если есть хоть один сохранённый код данно пользователя, то выводим колонку My Pastes
							if($myrow = mysql_fetch_array($result))
							{
								echo '<div class="content_right_menu">
										<div class="content_right_title">
											<a href="/u/">'.$msg["My Pastes"].'</a>
										</div>
										<div id="menu_1">
											<ul class="right_menu">';
								do
								{
									echo '<li ';
									// если код приватный, то задаём тегу li класс xtra_1 
									if($myrow["exposure"] == 1)
									{
										echo 'class="xtra_1"';
									}
									if($myrow["exposure"] == 2)
									{
										echo 'class="xtra_2"';
									}
									echo '><a href="/index.php?view='.$myrow["id_paste"].'">'.html_code($myrow["title"]).'</a><span>'.$myrow["syntax"].' | ';
									$ago = time() - $myrow["time_start"];
									nicetime($ago, $msg["second"], $msg["seconds"], $msg["seconds2"], $msg["minute"], $msg["minutes"], $msg["minutes2"], $msg["hour"], $msg["hours"], $msg["hours2"], $msg["day"], $msg["days"], $msg["days2"], $msg["month"], $msg["months"], $msg["months2"], $msg["year"], $msg["years"], $msg["years2"]);
									echo ' '.$msg["ago"].'</span></li>';
								}
								while($myrow = mysql_fetch_array($result));
								echo '</ul></div></div>';
							}
						}
					?>
				<div class="content_right_menu">
					<div class="content_right_title"><a href="/trends/"><?php echo $msg["Public Pastes"]; ?></a></div>	
					<div id="menu_2">
						<ul class="right_menu">
							<?php
								$public = 0;
								// выбираем все записи данного пользователя
								$result = mysql_query("SELECT * FROM pastes WHERE exposure={$public} ORDER by time_start DESC LIMIT 8",$db);
								while($myrow = mysql_fetch_array($result))
								{
									echo '<li><a href="/index.php?view='.$myrow["id_paste"].'">'.html_code($myrow["title"]).'</a><span>';
									$ago = time() - $myrow["time_start"];
									nicetime($ago, $msg["second"], $msg["seconds"], $msg["seconds2"], $msg["minute"], $msg["minutes"], $msg["minutes2"], $msg["hour"], $msg["hours"], $msg["hours2"], $msg["day"], $msg["days"], $msg["days2"], $msg["month"], $msg["months"], $msg["months2"], $msg["year"], $msg["years"], $msg["years2"]);
									echo ' '.$msg["ago"].'</span></li>';
								}
							?>
						</ul>
					</div>
				</div>										
			<div style="padding: 0; width:300px;height:260px;clear:left;">
				
			</div>				</div>