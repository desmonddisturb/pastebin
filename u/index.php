<?php
	include("../parts/header.php");
	if($_GET['id'] == $_SESSION['id'])
	{
		$_GET['id'] = 0;
	}
	// выбираем данные о пользователе
	if($_GET['id'])
	{
		$result = mysql_query("UPDATE users SET views=(views+1) WHERE id={$_GET['id']}",$db);
		$result = mysql_query("SELECT * FROM users WHERE id={$_GET['id']}",$db);
	}
	else
	{
		$result = mysql_query("SELECT * FROM users WHERE id={$_SESSION['id']}",$db);
	}
	$myrow = mysql_fetch_array($result);
	$name = $myrow["login"];
	$Total_Pastes = 0;
	$Public_pastes = 0;
	$Unlisted_pastes = 0;
	$Private_pastes = 0;
	$PASTEBIN_HITS = $myrow["views"]; // количество просмотров его списка публичных кодов
	$TOTAL_PASTES_HITS = 0;
	// выбираем все записи данного пользователя
	if($_GET['id'])
	{
		$result = mysql_query("SELECT * FROM pastes WHERE id_user={$_GET['id']}",$db);
	}
	else
	{
		$result = mysql_query("SELECT * FROM pastes WHERE id_user={$_SESSION['id']}",$db);
	}
	while($myrow = mysql_fetch_array($result))
	{
		++$Total_Pastes;
		$TOTAL_PASTES_HITS += $myrow["hits"];
		if($myrow["exposure"] == 1)
		{
			++$Unlisted_pastes;
		}
		elseif($myrow["exposure"] == 2)
		{
			++$Private_pastes;
		}
		else
		{
			++$Public_pastes;
		}
	}
	if($_GET['id'])
	{
		$result = mysql_query("SELECT * FROM pastes WHERE id_user={$_GET['id']} AND exposure={$public} ORDER by time_start DESC",$db);
	}
	else
	{
		$result = mysql_query("SELECT * FROM pastes WHERE id_user={$_SESSION['id']} ORDER by time_start DESC",$db);
	}
?>
	<div id="content_left">
		<div class="paste_box_frame">
			<div class="paste_box_icon">
				<img src="/i/t.gif" class="i_gb" width="50" height="50" alt="Guest" border="0">	
			</div>
			<div class="paste_box_info">
				<div class="paste_box_line1"><h1><?php echo $name.$msg["'s Pastebin"]; ?></h1></div>
				<div class="paste_box_line2"><?php echo $msg["Total Pastes"].': '.$Total_Pastes; ?> &nbsp;|&nbsp; <?php echo $msg["Public Pastes"].': '.$Public_pastes; ?> &nbsp;|&nbsp; <?php echo $msg["Unlisted pastes"].': '.$Unlisted_pastes; ?> &nbsp;|&nbsp; <?php echo $msg["Private pastes"].': '.$Private_pastes; ?></div>
				<div class="paste_box_line3"><?php echo $msg["PASTEBIN HITS"].': '.$PASTEBIN_HITS; ?> &nbsp;|&nbsp; <?php echo $msg["TOTAL PASTES HITS"].': '.$TOTAL_PASTES_HITS; ?></div>
			</div>
		</div>
		<div class="layout_clear"></div>
		<table class="maintable" cellspacing="0">
			<tbody>
				<tr class="top">
					<th scope="col" align="left"><?php echo $msg["Name / Title"]; ?></th>
					<th scope="col" align="left"><?php echo $msg["Added"]; ?></th>
					<th scope="col" align="left"><?php echo $msg["Expires"]; ?></th>				
					<th scope="col" align="left"><?php echo $msg["Hits"]; ?></th>	
					<th scope="col" align="left"><?php echo $msg["Syntax"]; ?></th>
					<?php 
						if(!$_GET['id'])
						{
							echo '<th scope="col" align="right">-</th>';
						}
					?>
					
				</tr>
					<?php
						if($myrow = mysql_fetch_array($result))
						{
							do
							{
								echo '<tr><td><img src="/i/t.gif" class="i_p';
								if($myrow["exposure"] == 1)
								{
									echo '1" title="Unlisted paste, only people with this link can see this paste." alt="" border="0"><a href="/index.php?view='.$myrow["id_paste"].'">'.html_code($myrow["title"]).'</a></td>';
								}
								elseif($myrow["exposure"] == 2)
								{
									echo '2" title="Private paste, only you can see this paste." alt="" border="0"><a href="/index.php?view='.$myrow["id_paste"].'">'.html_code($myrow["title"]).'</a></td>';
								}
								else
								{
									echo '0" title="Public paste, everybody can see this paste." alt="" border="0"> <a href="/index.php?view='.$myrow["id_paste"].'">'.html_code($myrow["title"]).'</a></td>';
								}
								echo '<td>'.date('d-m-Y', $myrow["time_start"]).'</td>';
								if($myrow["time_end"])
								{
									$ago = $myrow["time_end"] - time();
									if($ago < 0)
									{
										echo '<td>now</td>';
									}
									else
									{
										echo '<td>'.$msg["after"].' ';
										nicetime($ago, $msg["second"], $msg["seconds"], $msg["seconds2"], $msg["minute"], $msg["minutes"], $msg["minutes2"], $msg["hour"], $msg["hours"], $msg["hours2"], $msg["day"], $msg["days"], $msg["days2"], $msg["month"], $msg["months"], $msg["months2"], $msg["year"], $msg["years"], $msg["years2"]);
										echo '</td>';
									}
								}
								else
								{
									echo '<td>'.$msg["never"].'</td>';
								}
								echo '<td>'.$myrow["hits"].'</td>';
								if($myrow["syntax"] == 'none')
								{
									echo '<td>'.$msg["none2"].'</td>';
								}
								else
								{
									echo '<td>'.$myrow["syntax"].'</td>';
								}
								if(!$_GET['id'])
								{
									echo '<td align="right">
											<a href="/index.php?edit='.$myrow["id_paste"].'">
												<img src="/i/t.gif" class="i_ed" alt="'.$msg["Edit Paste"].'" border="0">
											</a> 
											<a href="/parts/delete.php?del='.$myrow["id_paste"].'" onclick="return confirm(\''.$msg["Are you sure you want to permanently delete this paste? There is"].'!\');">
												<img src="/i/t.gif" class="i_dl" alt="'.$msg["Delete Paste"].'" border="0">
											</a>
										</td>';
								}
							}
							while($myrow = mysql_fetch_array($result));
						}
						else
						{
							for ($d = 0; $d < 6; $d++)
							{
								echo '<td>---</td>';
							}
						}

					?>
				</tr>
			</tbody>
		</table>
		<?php
			if(!$_GET['id'])
			{
				echo '<div class="content_text">
						'.$msg["Hi"].' '.$_SESSION['login'].', '.$msg["this is your personal Pastebin"].'. 
						<br><br><b>'.$msg["Your stats"].':</b><br>
						'.$msg["Total number of active pastes"].': '.$Total_Pastes.'<br>
						'.$msg["Number of public pastes"].': '.$Public_pastes.'<br>
						'.$msg["Number of unlisted pastes"].': '.$Unlisted_pastes.'<br>
						'.$msg["Number of private pastes"].': '.$Private_pastes.'<br>
						'.$msg["Number of views of your Pastebin page"].': '.$PASTEBIN_HITS.'<br>
						'.$msg["Number of total views of all your active pastes"].': '.$TOTAL_PASTES_HITS.'<br><br>
					</div>';
			}
		?>
		<div style="margin:10px 0;clear:left"></div>
	</div>
<?php include("../parts/footer.php"); ?>