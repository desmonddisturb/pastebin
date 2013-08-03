				</div>
			</div>
		</div><arclones><textarea class="paste_textarea ar1369454603617" onkeydown="return catchTab(this,event)" style="resize: none; overflow: hidden; line-height: 21px; text-decoration: none; letter-spacing: 0px; font-size: 13px; font-family: Consolas, Menlo, Monaco, 'Lucida Console', 'Liberation Mono', 'DejaVu Sans Mono', 'Bitstream Vera Sans Mono', monospace, serif; font-style: normal; font-weight: 400; text-transform: none; text-align: start; direction: ltr; word-spacing: 0px; padding: 8.4375px; width: 827.125px; position: absolute; top: -9999px; left: -9999px; opacity: 0; height: 0px;" tabindex="-1"></textarea></arclones>
		<div id="footer">
			<div id="logo_small"></div>
			<div id="footer_links">
				<a href="/"><?php echo $msg["create new paste"]; ?></a> <br><?php echo $msg["Pastebin rendered in"]; ?>: 
				<?php
					// считываем текущее время
					$end_time = microtime();
					// разделяем секунды и миллисекунды
					$end_array = explode(" ",$end_time);
					// это и есть конечное время
					$end_time = $end_array[1] + $end_array[0];
					// находим разницу между начальным и конечным временем
					$time = $end_time - $start_time;
					// округляе до 3 знаков после запятой и выводим
					printf(round($time, 3));
				?>
				 <?php echo $msg["seconds"]; ?>				
			</div>
		</div>
</body>
</body></html>