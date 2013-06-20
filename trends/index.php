<?php include("../parts/header.php");?>
<div id="content_left">
	<div class="paste_box_frame">
		<div class="paste_box_icon">
			<img src="../i/trend_big.png" width="50" height="50" alt="" border="0">	
		</div>
		<div class="paste_box_info">
			<div class="paste_box_line1"><h1><?php echo $msg["Trending Pastes2"]; ?></h1></div>
			<div class="paste_box_line2" style="text-transform:none;font-size:1.0em"><?php echo $msg["This page contains the most popular pastes"]; ?>.</div>
			<div class="paste_box_line3" style="text-transform:none;font-size:1.0em"><?php echo $msg["Filter trends"]; ?>: <a href="/trends"><?php echo $msg["right now"]; ?></a> | <a href="/trends/index.php?filter=week"><?php echo $msg["last 7 days"]; ?></a> | <a href="/trends/index.php?filter=month"><?php echo $msg["last 30 days"]; ?></a> | <a href="/trends/index.php?filter=year"><?php echo $msg["last 365 days"]; ?></a> | <a href="/trends/index.php?filter=all"><?php echo $msg["all time"]; ?></a></div>
		</div>
	</div>
	<div class="layout_clear"></div>
	<table class="maintable" cellspacing="0">
		<tbody>
			<tr class="top">
				<th scope="col" align="left"><?php echo $msg["Name / Title"]; ?></th>
				<th scope="col" align="left"><?php echo $msg["Added"]; ?></th>				
				<th scope="col" align="left"><?php echo $msg["Hits"]; ?></th>
				<th scope="col" align="left"><?php echo $msg["Syntax"]; ?></th>
				<th scope="col" align="right"><?php echo $msg["User"]; ?></th>
			</tr>
			<?php
				if($_GET['filter'] == 'week')
				{
					$filter_time = time() - 604800;
				}
				elseif($_GET['filter'] == 'month')
				{
					$filter_time = time() - 2592000;
				}
				elseif($_GET['filter'] == 'year')
				{
					$filter_time = time() - 31536000;
				}
				elseif($_GET['filter'] == 'all')
				{
					$filter_time = 0;
				}
				else
				{
					$filter_time = time() - 345600;
				}
				$result = mysql_query("SELECT * FROM pastes WHERE exposure=0 AND time_start>{$filter_time} ORDER by hits DESC LIMIT 18",$db);
				while($myrow = mysql_fetch_array($result))
				{
					echo '<tr>
							<td>
								<img src="../i/t.gif" class="i_p0" alt="" border="0">
								<a href="/index.php?view='.$myrow["id_paste"].'">'.html_code($myrow["title"]).'</a>
							</td>';
					echo '<td>';
					$ago = time() - $myrow["time_start"];
					nicetime($ago, $msg["second"], $msg["seconds"], $msg["seconds2"], $msg["minute"], $msg["minutes"], $msg["minutes2"], $msg["hour"], $msg["hours"], $msg["hours2"], $msg["day"], $msg["days"], $msg["days2"], $msg["month"], $msg["months"], $msg["months2"], $msg["year"], $msg["years"], $msg["years2"]);
					echo ' '.$msg["ago"].'</td>';
					echo '<td>'.$myrow["hits"].'</td>';
					if($myrow["syntax"] == 'none')
					{
						echo '<td>'.$msg["none2"].'</td>';
					}
					else
					{
						echo '<td>'.$myrow["syntax"].'</td>';
					}
					if($myrow["id_user"])
					{
						$result_2 = mysql_query("SELECT * FROM users WHERE id={$myrow["id_user"]}",$db);
						$myrow_2 = mysql_fetch_array($result_2);
						echo '<td align="right"><a href="/u/index.php?id='.$myrow["id_user"].'">'.$myrow_2["login"].'</a></td>';
					}
					else
					{
						echo '<td align="right">'.$msg["a guest"].'</td>';
					}
				}
			?>
		</tbody>
	</table>
	<div class="content_text"> </div>
	<div style="margin:10px 0;clear:left"></div>
</div>
<?php include("../parts/footer.php");?>