<?php
$timeStart = strtotime(date('Y-m-d') . "09:00:00");
$timeEnd = strtotime(date('Y-m-d') . "18:00:00");
while($timeStart < $timeEnd) {
	$timeDropdown[] = date('H:i',$timeStart);
	$timeStart = $timeStart + 900;
}
$time = date("H:i");
$date = date("d/m/Y", strtotime(date("Y-m-d")) + 86400);


?>
<form action="processArticle.php" method="POST">
	<table class="centerTable">
		<tr align='center'>
			<td>Title</td>
			<td>Category</td>
			<td>Description</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input type='text' name='title' maxlength='100' size='25' value='<?php if(isset($_SESSION['newArticle']['postData']['title'])) { echo $_SESSION['newArticle']['postData']['title']; } ?>'/>
			</td>
			<td>
				<select name="category">
					<option></option>
					<?php
					foreach($categories AS $k => $v) {
						echo "<option value='$k' ";
						if(isset($_SESSION['newArticle']['postData']['category'])) {
							if($_SESSION['newArticle']['postData']['category'] == $k) {
								echo "selected='selected' ";
							}
						}
						echo ">$v</option>\n";
					}
					?>
				</select>
			</td>
		
			<td>
				<input type='text' name='description' maxlength='150' size='35' value='<?php if(isset($_SESSION['newArticle']['postData']['description'])) { echo $_SESSION['newArticle']['postData']['description']; } ?>'/>
			</td>
			<td>
				<input type='hidden' name='fromPage' value='<?php echo $_SERVER['PHP_SELF']; ?>' />
				<input type='submit' name='action' value='Add article'/>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td class='textCenter'>Notes:</td>
		</tr>
		<tr>
			<td class='textCenter'><textarea name='note' cols='80' rows='10'><?php if(isset($_SESSION['newArticle']['postData']['note'])) { echo $_SESSION['newArticle']['postData']['note']; } ?></textarea></td>
		</tr>
	</table>
</form>
<?php
if(isset($_SESSION['newArticle']['errors'])) {
	echo "<table class='centerTable'>\n";
	foreach($_SESSION['newArticle']['errors'] AS $k => $e) {
		echo "<tr><td class='textRed'>$e</td></tr>\n";
	}
	echo "</table>\n";
	unset($_SESSION['newArticle']['errors']);
}
if(isset($_SESSION['newArticle']['success'])) {
	echo "<table class='centerTable'>\n";
	foreach($_SESSION['newArticle']['success'] AS $k => $s) {
		echo "<tr><td class='textGreen'>$s</td></tr>\n";
	}
	echo "</table>\n";
	unset($_SESSION['newArticle']['success']);
}
unset($_SESSION['newArticle']);
?>