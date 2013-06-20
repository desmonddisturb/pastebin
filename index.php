<?php
	include("parts/header.php");
	$characters = 20;
	function generateCode($characters)
	{
		$possible = '23456789bcdfghjkmnpqrstvwxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}
	if($_GET['view'])
	{
		$result = mysql_query("SELECT * FROM pastes WHERE id_paste={$_GET['view']}",$db);
		$myrow = mysql_fetch_array($result);
		if($myrow["id_paste"])
		{
			$can_edit = 0;
			if((($myrow["id_user"] == $_SESSION['id']) or ($myrow["code_paste"] == $_SESSION['code_paste'])))
			{
				$can_edit = 1;
			}
			if(!(($myrow["exposure"] == 2) and !$can_edit))
			{
				if(!$can_edit)
				{
					mysql_query("UPDATE pastes SET hits=(hits+1) WHERE id_paste={$myrow["id_paste"]}",$db);
				}
				echo '<div id="content_left">
						<div class="paste_box_frame">
							<div class="tweet">
								<div onclick="facebookpopup(\'/index.php?view='.$myrow["id_paste"].'\'); return false;" id="b_facebook2"><span id="b_facebook"></span></div>
								<div onclick="twitpopup(\'/index.php?view='.$myrow["id_paste"].'\'); return false;" id="b_twitter2"><span id="b_twitter"></span></div>
							</div>
							<div class="paste_box_icon">
								<img src="/i/t.gif" class="i_gb" alt="Guest" border="0">	
							</div>
							<div class="paste_box_info">';
							echo '<div class="paste_box_line1"><img src="/i/t.gif" class="i_p';
								if($myrow["exposure"] == 1)
								{
									echo '1" width="16" height="16" title="'.$msg["Unlisted paste, only people with this link can see this paste"].'." alt="" border="0"><h1>'.$myrow["title"].'</h1> ';
								}
								elseif($myrow["exposure"] == 2)
								{
									echo '2" width="16" height="16" title="'.$msg["Private paste, only you can see this paste"].'." alt="" border="0"><h1>'.$myrow["title"].'</h1> ';
								}
								else
								{
									echo '0" width="16" height="16" title="'.$msg["Public paste, everybody can see this paste"].'." alt="" border="0"><h1>'.$myrow["title"].'</h1> ';
								}
								echo '</div>';
							$result_2 = mysql_query("SELECT * FROM users WHERE id={$myrow["id_user"]}",$db);
							$myrow_2 = mysql_fetch_array($result_2);
							echo '<div class="paste_box_line2">'.$msg["By"].': ';
									if($myrow_2["login"])
									{
										echo '<a href="/u/index.php?id='.$myrow_2["id"].'">'.$myrow_2["login"].'</a>';
									}
									else
									{
										echo '<span>a guest</span>';
									}
									echo '
									 &nbsp;|&nbsp; '.$msg["Added"].': <span>'.date('d-m-Y', $myrow["time_start"]).'</span>
									 &nbsp;|&nbsp; '.$msg["Syntax"].': <span>';
									 if($myrow["syntax"] == 'none')
									{
										echo $msg["none2"];
									}
									else
									{
										echo $myrow["syntax"];
									}
								echo '</span>
									 &nbsp;|&nbsp; '.$msg["Hits"].': <span>'.$myrow["hits"].'</span>
									 &nbsp;|&nbsp; '.$msg["Expires"].': <span>';
									if($myrow["time_end"])
									{
										$ago = $myrow["time_end"] - time();
										if($ago < 0)
										{
											echo 'now';
										}
										else
										{
											echo $msg["after"].' ';
											nicetime($ago, $msg["second"], $msg["seconds"], $msg["seconds2"], $msg["minute"], $msg["minutes"], $msg["minutes2"], $msg["hour"], $msg["hours"], $msg["hours2"], $msg["day"], $msg["days"], $msg["days2"], $msg["month"], $msg["months"], $msg["months2"], $msg["year"], $msg["years"], $msg["years2"]);
										}
									}
									else
									{
										echo $msg["never"];
									}
									echo '</span></div>';
							if($can_edit)
							{
								echo '<div class="paste_box_line3"><a href="/index.php?edit='.$myrow["id_paste"].'">'.$msg["Edit Paste"].'</a> &nbsp;|&nbsp; <a href="/parts/delete.php?del='.$myrow["id_paste"].'" onclick="return confirm(\''.$msg["Are you sure you want to permanently delete this paste? There is"].'!\');">'.$msg["Delete Paste"].'</a></div>';
							}
							echo '</div>
						</div>
						<div class="layout_clear"></div>
						<div id="code_frame2">
							<div id="code_frame">
								<div id="selectable">
									<pre ';		
									if($myrow["syntax"] == 'Bash'){echo 'class="prettyprint lang-bsh"';}
									if($myrow["syntax"] == 'C'){echo 'class="prettyprint lang-c"';}
									if($myrow["syntax"] == 'C++'){echo 'class="prettyprint lang-cpp"';}
									if($myrow["syntax"] == 'C#'){echo 'class="prettyprint lang-cs"';}
									if($myrow["syntax"] == 'Coffee'){echo 'class="prettyprint lang-coffee"';}
									if($myrow["syntax"] == 'CSS'){echo 'class="prettyprint lang-css"';}
									if($myrow["syntax"] == 'Erlang'){echo 'class="prettyprint lang-erlang"';}
									if($myrow["syntax"] == 'F#'){echo 'class="prettyprint lang-ml"';}
									if($myrow["syntax"] == 'Go'){echo 'class="prettyprint lang-go"';}
									if($myrow["syntax"] == 'Haskell'){echo 'class="prettyprint lang-hs"';}
									if($myrow["syntax"] == 'HTML'){echo 'class="prettyprint lang-html"';}
									if($myrow["syntax"] == 'Java'){echo 'class="prettyprint lang-java"';}
									if($myrow["syntax"] == 'Javascript'){echo 'class="prettyprint lang-js"';}
									if($myrow["syntax"] == 'Lua'){echo 'class="prettyprint lang-lua"';}
									if($myrow["syntax"] == 'Perl'){echo 'class="prettyprint lang-perl"';}
									if($myrow["syntax"] == 'PHP'){echo 'class="prettyprint lang-php"';}
									if($myrow["syntax"] == 'Protocol Buffers'){echo 'class="prettyprint lang-proto"';}
									if($myrow["syntax"] == 'Python'){echo 'class="prettyprint lang-py"';}
									if($myrow["syntax"] == 'Scala'){echo 'class="prettyprint lang-scala"';}
									if($myrow["syntax"] == 'SQL'){echo 'class="prettyprint lang-sql"';}
									if($myrow["syntax"] == 'VBScript'){echo 'class="prettyprint lang-vb"';}
									if($myrow["syntax"] == 'VHDL'){echo 'class="prettyprint lang-vhdl"';}
									if($myrow["syntax"] == 'Wiki'){echo 'class="prettyprint lang-wiki"';}
									if($myrow["syntax"] == 'XHTML'){echo 'class="prettyprint lang-xhtml"';}
									if($myrow["syntax"] == 'XML'){echo 'class="prettyprint lang-xml"';}
									if($myrow["syntax"] == 'XSL'){echo 'class="prettyprint lang-xsl"';}
								echo ' style="padding:5px; margin-left:10px; border: none;">'.html_code($myrow["code"]).'</pre>
								</div>
							</div>
						</div>
						<div style="margin:10px 0;clear:left"></div>
					</div>';
				include("parts/footer.php");
				exit();
			}
		}
	}
	if($_POST['paste_code'] and !$_GET['edit'] and !$_GET['editing'])
	{
		if(!title_check($_POST['paste_name']))
		{
			$_POST['paste_name'] = 'Untitled';
		}
		$sql_line = "INSERT INTO pastes (id_paste, hits, id_user, title, syntax, exposure, time_start, time_end, code, code_paste) VALUES ('',  '0',  '";
		if($_SESSION['login'])
		{
			if($_POST['paste_guest'] == 'on')
			{
				$sql_line = $sql_line."0";
			}
			else
			{
				$sql_line = $sql_line.$_SESSION['id'];
			}
		}
		else
		{
			$sql_line = $sql_line."0";
		}
		$sql_line = $sql_line."',  '";
		if($_POST['paste_name'])
		{
			$sql_line = $sql_line.$_POST['paste_name'];
		}
		else
		{
			$sql_line = $sql_line."Untitled";
		}
		$sql_line = $sql_line."',  '";
		if($_POST['paste_format'])
		{
			$sql_line = $sql_line.$_POST['paste_format'];
		}
		else
		{
			$sql_line = $sql_line."none";
		}
		$sql_line = $sql_line."',  '";
		if($_POST['paste_private'])
		{
			$sql_line = $sql_line.$_POST['paste_private'];
		}
		else
		{
			$sql_line = $sql_line."0";
		}
		$sql_line = $sql_line."',  '";
		$sql_line = $sql_line.time();
		$sql_line = $sql_line."',  '";
		if($_POST['paste_expire_date'] == "N")
		{
			$sql_line = $sql_line."0";
		}
		elseif($_POST['paste_expire_date'] == "10M")
		{
			$sql_line = $sql_line.(time() + 600);
		}
		elseif($_POST['paste_expire_date'] == "1H")
		{
			$sql_line = $sql_line.(time() + 3600);
		}
		elseif($_POST['paste_expire_date'] == "1D")
		{
			$sql_line = $sql_line.(time() + 86400);
		}
		elseif($_POST['paste_expire_date'] == "1W")
		{
			$sql_line = $sql_line.(time() + 604800);
		}
		elseif($_POST['paste_expire_date'] == "2W")
		{
			$sql_line = $sql_line.(time() + 1209600);
		}
		elseif($_POST['paste_expire_date'] == "1M")
		{
			$sql_line = $sql_line.(time() + 2592000);
		}
		else
		{
			$sql_line = $sql_line."0";
		}
		$code_paste = generateCode($characters);
		$_SESSION['code_paste'] = $code_paste;
		$sql_line = $sql_line."',  '".$_POST['paste_code']."',  '".$code_paste."')";
		$result = mysql_query($sql_line,$db);
		$result = mysql_query("SELECT * FROM pastes WHERE code_paste='{$_SESSION['code_paste']}'",$db);
		$myrow = mysql_fetch_array($result);
		echo '<script type="text/javascript">window.location.href="/index.php?view='.$myrow["id_paste"].'";</script>';
		echo '<div class="form_frame_left">			
				<div class="content_text" style="clear:left">
					<div id="notice">'.$msg["Paste is saved. You can"].' <a href="/index.php?view='.$myrow["id_paste"].'">'.$msg["view"].'</a> '.$msg["your paste"].'.</div>
				</div>
			</div>
			<div style="margin:10px 0;clear:left"></div>
		</div>';
		include("parts/footer.php");
		exit();
	}
	elseif($_GET['editing'])
	{
		if($_POST['paste_code'])
		{
			if(!title_check($_POST['paste_name']))
			{
				$_POST['paste_name'] = 'Untitled';
			}
			$result = mysql_query("SELECT * FROM pastes WHERE id_paste={$_GET['editing']}",$db);
			$myrow = mysql_fetch_array($result);
			if($myrow["id_paste"] and (($myrow["id_user"] == $_SESSION['id']) or ($myrow["code_paste"] == $_SESSION['code_paste'])))
			{
				$sql_line = "UPDATE pastes SET title='";
				if($_POST['paste_name'])
				{
					$sql_line = $sql_line.$_POST['paste_name'];
				}
				else
				{
					$sql_line = $sql_line."Untitled";
				}
				$sql_line = $sql_line."',  syntax='";
				if($_POST['paste_format'])
				{
					$sql_line = $sql_line.$_POST['paste_format'];
				}
				else
				{
					$sql_line = $sql_line."none";
				}
				$sql_line = $sql_line."',  exposure='";
				if($_POST['paste_private'])
				{
					$sql_line = $sql_line.$_POST['paste_private'];
				}
				else
				{
					$sql_line = $sql_line."0";
				}
				$sql_line = $sql_line."',  time_start='";
				$sql_line = $sql_line.time();
				$sql_line = $sql_line."',  time_end='";
				if($_POST['paste_expire_date'] == "N")
				{
					$sql_line = $sql_line."0";
				}
				elseif($_POST['paste_expire_date'] == "10M")
				{
					$sql_line = $sql_line.(time() + 600);
				}
				elseif($_POST['paste_expire_date'] == "1H")
				{
					$sql_line = $sql_line.(time() + 3600);
				}
				elseif($_POST['paste_expire_date'] == "1D")
				{
					$sql_line = $sql_line.(time() + 86400);
				}
				elseif($_POST['paste_expire_date'] == "1W")
				{
					$sql_line = $sql_line.(time() + 604800);
				}
				elseif($_POST['paste_expire_date'] == "2W")
				{
					$sql_line = $sql_line.(time() + 1209600);
				}
				elseif($_POST['paste_expire_date'] == "1M")
				{
					$sql_line = $sql_line.(time() + 2592000);
				}
				else
				{
					$sql_line = $sql_line."0";
				}
				$sql_line = $sql_line."',  code='";
				$sql_line = $sql_line.$_POST['paste_code'];
				$sql_line = $sql_line."',  code_paste='";
				$code_paste = generateCode($characters);
				$_SESSION['code_paste'] = $code_paste;
				$sql_line = $sql_line.$code_paste."'  WHERE id_paste=".$_GET['editing'];
				$result = mysql_query($sql_line,$db);
				echo '<script type="text/javascript">window.location.href="/index.php?view='.$_GET['editing'].'";</script>';
				echo '<div class="form_frame_left">			
						<div class="content_text" style="clear:left">
							<div id="notice">'.$msg["Paste is changed. You can"].' <a href="/index.php?view='.$_GET['editing'].'">'.$msg["view"].'</a> '.$msg["your paste"].'.</div>
						</div>
					</div>
					<div style="margin:10px 0;clear:left"></div>
				</div>';
				include("parts/footer.php");
				exit();
			}
		}
		else
		{
			echo '<script type="text/javascript">window.location.href="/index.php?edit='.$_GET['editing'].'";</script>';
		}
	}
	elseif(!$_POST['paste_code'] and $_GET['edit'])
	{
		$result = mysql_query("SELECT * FROM pastes WHERE id_paste={$_GET['edit']}",$db);
		$myrow = mysql_fetch_array($result);
		if($myrow["id_paste"] and (($myrow["id_user"] == $_SESSION['id']) or ($myrow["code_paste"] == $_SESSION['code_paste'])))
		{
			echo '<div id="content_left">
					<div class="layout_clear"></div>
					<div class="content_title">'.$msg["New Paste"].'</div>
					<form class="paste_form" id="myform" enctype="multipart/form-data" name="myform" method="post" action="/index.php?editing='.$_GET['edit'].'" onsubmit="document.getElementById(\'submit\').disabled=true;document.getElementById(\'submit\').value=\''.$msg["Please wait"].'...\';">
						<input name="paste_guest" value="1" type="hidden">
						<input name="submit_hidden" value="submit_hidden" type="hidden">
						<div class="textarea_border">
							<textarea name="paste_code" class="paste_textarea" id="paste_code" onkeydown="return catchTab(this,event)" style="resize: none; overflow-y: hidden; height: 200px;">'.html_code($myrow['code']).'</textarea>
						</div>	
						<script type="text/javascript">$(\'textarea\').autoResize({minHeight: 200, maxHeight: 2000});$(document).ready( function(){$("#paste_code").focus();});</script>
						<div class="content_title">'.$msg["Optional Paste Settings"].'</div>
						<div class="form_frame_left">
							<div class="form_frame">
								<div class="form_left">
									'.$msg["Syntax Highlighting"].':
								</div>
								<div class="form_right">
									<select class="post_select" name="paste_format" value="0">';
										echo '<option value="0"';if($myrow["syntax"] == '0'){echo 'selected="selected"';}echo '>'.$msg["None"].'</option>';
										echo '<option value="Bash"';if($myrow["syntax"] == 'Bash'){echo 'selected="selected"';}echo '>Bash</option>';
										echo '<option value="C"';if($myrow["syntax"] == 'C'){echo 'selected="selected"';}echo '>C</option>';
										echo '<option value="C++"';if($myrow["syntax"] == 'C++'){echo 'selected="selected"';}echo '>C++</option>';
										echo '<option value="C#"';if($myrow["syntax"] == 'C#'){echo 'selected="selected"';}echo '>C#</option>';
										echo '<option value="Coffee"';if($myrow["syntax"] == 'Coffee'){echo 'selected="selected"';}echo '>Coffee</option>';
										echo '<option value="CSS"';if($myrow["syntax"] == 'CSS'){echo 'selected="selected"';}echo '>CSS</option>';
										echo '<option value="Erlang"';if($myrow["syntax"] == 'Erlang'){echo 'selected="selected"';}echo '>Erlang</option>';
										echo '<option value="F#"';if($myrow["syntax"] == 'F#'){echo 'selected="selected"';}echo '>F#</option>';
										echo '<option value="Go"';if($myrow["syntax"] == 'Go'){echo 'selected="selected"';}echo '>Go</option>';
										echo '<option value="Haskell"';if($myrow["syntax"] == 'Haskell'){echo 'selected="selected"';}echo '>Haskell</option>';
										echo '<option value="HTML"';if($myrow["syntax"] == 'HTML'){echo 'selected="selected"';}echo '>HTML</option>';
										echo '<option value="Java"';if($myrow["syntax"] == 'Java'){echo 'selected="selected"';}echo '>Java</option>';
										echo '<option value="Javascript"';if($myrow["syntax"] == 'Javascript'){echo 'selected="selected"';}echo '>Javascript</option>';
										echo '<option value="Lua"';if($myrow["syntax"] == 'Lua'){echo 'selected="selected"';}echo '>Lua</option>';
										echo '<option value="Perl"';if($myrow["syntax"] == 'Perl'){echo 'selected="selected"';}echo '>Perl</option>';
										echo '<option value="PHP"';if($myrow["syntax"] == 'PHP'){echo 'selected="selected"';}echo '>PHP</option>';
										echo '<option value="Protocol Buffers"';if($myrow["syntax"] == 'Protocol Buffers'){echo 'selected="selected"';}echo '>Protocol Buffers</option>';
										echo '<option value="Python"';if($myrow["syntax"] == 'Python'){echo 'selected="selected"';}echo '>Python</option>';
										echo '<option value="Scala"';if($myrow["syntax"] == 'Scala'){echo 'selected="selected"';}echo '>Scala</option>';
										echo '<option value="SQL"';if($myrow["syntax"] == 'SQL'){echo 'selected="selected"';}echo '>SQL</option>';
										echo '<option value="VBScript"';if($myrow["syntax"] == 'VBScript'){echo 'selected="selected"';}echo '>VBScript</option>';
										echo '<option value="VHDL"';if($myrow["syntax"] == 'VHDL'){echo 'selected="selected"';}echo '>VHDL</option>';
										echo '<option value="Wiki"';if($myrow["syntax"] == 'Wiki'){echo 'selected="selected"';}echo '>Wiki</option>';
										echo '<option value="XHTML"';if($myrow["syntax"] == 'XHTML'){echo 'selected="selected"';}echo '>XHTML</option>';
										echo '<option value="XML"';if($myrow["syntax"] == 'XML'){echo 'selected="selected"';}echo '>XML</option>';
										echo '<option value="XSL"';if($myrow["syntax"] == 'XSL'){echo 'selected="selected"';}echo '>XSL</option>
									</select>
								</div>
							</div>
							<div class="form_frame">
								<div class="form_left">
									'.$msg["Paste Expiration"].':
								</div>
								<div class="form_right">
									<select class="post_select" name="paste_expire_date" value="N">';
										echo '<option value="N"';if($myrow["time_end"] == '0'){echo 'selected="selected"';}echo '>'.$msg["never"].'</option>';
										if($myrow["time_end"])
										{
											$tmp_time = $myrow["time_end"] - $myrow["time_start"];
										}
										else
										{
											$tmp_time = 0;
										}
										echo '<option value="10M"';if($tmp_time == 600){echo 'selected="selected"';}echo '>10 '.$msg["minutes"].'</option>';
										echo '<option value="1H"';if($tmp_time == 3600){echo 'selected="selected"';}echo '>1 '.$msg["hour"].'</option>';
										echo '<option value="1D"';if($tmp_time == 86400){echo 'selected="selected"';}echo '>1 '.$msg["day"].'</option>';
										echo '<option value="1W"';if($tmp_time == 604800){echo 'selected="selected"';}echo '>1 '.$msg["week"].'</option>';
										echo '<option value="2W"';if($tmp_time == 1209600){echo 'selected="selected"';}echo '>2 '.$msg["weeks"].'</option>';
										echo '<option value="1M"';if($tmp_time == 2592000){echo 'selected="selected"';}echo '>1 '.$msg["month"].'</option>
									</select>
								</div>
							</div>
							<div class="form_frame">
								<div class="form_left">
									'.$msg["Paste Exposure"].':
								</div>
								<div class="form_right">
									<select class="post_select" name="paste_private" value="0">';
										echo '<option value="0" ';if($myrow["exposure"] == '0'){echo 'selected="selected"';}echo '>'.$msg["Public"].'</option>';
										echo '<option value="1" ';if($myrow["exposure"] == '1'){echo 'selected="selected"';}echo '>'.$msg["Unlisted"].'</option>';
										echo '<option value="2" ';
											if(($myrow["exposure"] == '2'))
											{
												echo 'selected="selected">'.$msg["Private"].'</option>';
											}
											elseif($_SESSION['login'])
											{
												echo '>'.$msg["Private"].'</option>';
											}
											else
											{
												echo 'disabled="disabled">'.$msg["Private"].'</option>';
											}
							echo '</select>
								</div>
							</div>						
							<div class="form_frame">
								<div class="form_left">
									'.$msg["Name / Title"].':
								</div>
								<div class="form_right">
									<input type="text" name="paste_name" size="20" maxlength="60" value="'.html_code($myrow["title"]).'" class="post_input"> 
								</div>
							</div>
							<div class="form_frame">
								<div class="form_left">
									&nbsp;
								</div>
								<div class="form_right">
									<input name="submit" type="submit" value="'.$msg["Submit"].'" id="submit" accesskey="s" class="button1 btnbold">';
									if($_SESSION['login'])
									{
										echo '<input type="checkbox" name="paste_guest" style="margin: 12px 0 0 12px"> '.$msg["Paste as a guest"].'';
									}
									else
									{
										echo '<input name="paste_guest" value="0" type="hidden">';
									}
							echo '</div>
							</div>
						</div>		
					</form>	
					<div class="form_login_frame">
							<div class="form_avatar"><img src="/i/t.gif" class="i_gb" width="50" height="50" alt="Guest" border="0"></div>';
								if($_SESSION['login'])
								{
									echo '<div class="form_text">'.$msg["Hi"].' <b>'.$_SESSION['login'].'</b><br><a href="/u/" class="button1">'.$msg["my pastebin"].'</a></div>';
								}
								else
								{
									echo '<div class="form_text">'.$msg["Hi"].' <b>'.$msg["Guest"].'</b><br><a href="/signup/" class="button1">'.$msg["sign up"].'</a>&nbsp;'.$msg["or"].'&nbsp;<a href="/login/" class="button1">'.$msg["login"].'</a></div>';
								}
			echo '</div>
					<div style="margin:10px 0;clear:left"></div>
				</div>';
			include("parts/footer.php");
			exit();
		}
	}
?>
	<div id="content_left">
		<div class="layout_clear"></div>
		<div class="content_title"><?php echo $msg["New Paste"]; ?></div>
		<form class="paste_form" id="myform" enctype="multipart/form-data" name="myform" method="post" action="/" onsubmit="document.getElementById('submit').disabled=true;document.getElementById('submit').value='<?php echo $msg["Please wait"]; ?>...';">
			<input name="paste_guest" value="1" type="hidden">
			<input name="submit_hidden" value="submit_hidden" type="hidden">
			<div class="textarea_border">
				<textarea name="paste_code" class="paste_textarea" id="paste_code" onkeydown="return catchTab(this,event)" style="resize: none; overflow-y: hidden; height: 200px;"><?php echo html_code($_POST['paste_code']); ?></textarea>
			</div>	
			<script type="text/javascript">$('textarea').autoResize({minHeight: 200, maxHeight: 2000});$(document).ready( function(){$("#paste_code").focus();});</script>
			<div class="content_title"><?php echo $msg["Optional Paste Settings"]; ?></div>
			<div class="form_frame_left">
				<div class="form_frame">
					<div class="form_left">
						<?php echo $msg["Syntax Highlighting"]; ?>:
					</div>
					<div class="form_right">
						<select class="post_select" name="paste_format" value="0">
							<option value="0" selected="selected"><?php echo $msg["None"]; ?></option>
							<option value="Bash">Bash</option>
							<option value="C">C</option>
							<option value="C++">C++</option>
							<option value="C#">C#</option>
							<option value="Coffee">Coffee</option>
							<option value="CSS">CSS</option>
							<option value="Erlang">Erlang</option>
							<option value="F#">F#</option>
							<option value="Go">Go</option>
							<option value="Haskell">Haskell</option>
							<option value="HTML">HTML</option>
							<option value="Java">Java</option>
							<option value="Javascript">Javascript</option>
							<option value="Lua">Lua</option>
							<option value="Perl">Perl</option>
							<option value="PHP">PHP</option>
							<option value="Protocol Buffers">Protocol Buffers</option>
							<option value="Python">Python</option>
							<option value="Scala">Scala</option>
							<option value="SQL">SQL</option>
							<option value="VBScript">VBScript</option>
							<option value="VHDL">VHDL</option>
							<option value="Wiki">Wiki</option>
							<option value="XHTML">XHTML</option>
							<option value="XML">XML</option>
							<option value="XSL">XSL</option>
						</select>
					</div>
				</div>
				<div class="form_frame">
					<div class="form_left">
						<?php echo $msg["Paste Expiration"]; ?>:
					</div>
					<div class="form_right">
						<select class="post_select" name="paste_expire_date" value="N">
							<option value="N" selected="selected"><?php echo $msg["never"]; ?></option>
							<option value="10M">10 <?php echo $msg["minutes"]; ?></option>
							<option value="1H">1 <?php echo $msg["hour"]; ?></option>
							<option value="1D">1 <?php echo $msg["day"]; ?></option>
							<option value="1W">1 <?php echo $msg["week"]; ?></option>
							<option value="2W">2 <?php echo $msg["weeks"]; ?></option>
							<option value="1M">1 <?php echo $msg["month"]; ?></option>
						</select>
					</div>
				</div>
				<div class="form_frame">
					<div class="form_left">
						<?php echo $msg["Paste Exposure"]; ?>:
					</div>
					<div class="form_right">
						<select class="post_select" name="paste_private" value="0">
							<option value="0" selected="selected"><?php echo $msg["Public"]; ?></option>
							<option value="1"><?php echo $msg["Unlisted"]; ?></option>
							<option value="2" <?php 
													if(!$_SESSION['login']){echo 'disabled="disabled">'.$msg["Private"].'</option>';}
													else{echo '>'.$msg["Private"].'</option>';}
												?>
						</select>
					</div>
				</div>						
				<div class="form_frame">
					<div class="form_left">
						<?php echo $msg["Name / Title"]; ?>:
					</div>
					<div class="form_right">
						<input type="text" name="paste_name" size="20" maxlength="60" value="" class="post_input"> 
					</div>
				</div>
				<div class="form_frame">
					<div class="form_left">
						&nbsp;
					</div>
					<div class="form_right">
						<input name="submit" type="submit" value="<?php echo $msg["Submit"]; ?>" id="submit" accesskey="s" class="button1 btnbold">
						<?php
							if($_SESSION['login'])
							{
								echo '<input type="checkbox" name="paste_guest" style="margin: 12px 0 0 12px"> '.$msg["Paste as a guest"];
							}
							else
							{
								echo '<input name="paste_guest" value="0" type="hidden">';
							}
						?>
					</div>
				</div>
			</div>		
		</form>	
		<div class="form_login_frame">
				<div class="form_avatar"><img src="/i/t.gif" class="i_gb" width="50" height="50" alt="Guest" border="0"></div>
				<?php
					if($_SESSION['login'])
					{
						echo '<div class="form_text">'.$msg["Hi"].' <b>'.$_SESSION['login'].'</b><br><a href="/u/" class="button1">'.$msg["my pastebin"].'</a></div>';
					}
					else
					{
						echo '<div class="form_text">'.$msg["Hi"].' <b>'.$msg["Guest"].'</b><br><a href="/signup/" class="button1">'.$msg["sign up"].'</a>&nbsp;'.$msg["or"].'&nbsp;<a href="/login/" class="button1">'.$msg["login"].'</a></div>';
					}
				?>
		</div>
		<div style="margin:10px 0;clear:left"></div>
	</div>
<?php include("parts/footer.php");?>