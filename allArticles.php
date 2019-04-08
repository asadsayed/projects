<?php
unset($sql);
?>
<a name='user'></a>
<h2 class='textCenter'>All Articles</h2>
<table class='smallText thinPad'>
	<form action='caseSearch.php' method='POST'>
		<tr class='green bold'>
			<td>Title</td>
			<td>Date Added</td>
			<td>Description</td>
			<td>Category</td>
			<td>Added By</td>
			<td class='textCenter'>
				<?php
				if(isset($_SESSION['filter']) && array_key_exists("all",$_SESSION['filter'])) {
					echo "<input type='submit' name='action' value='Clear Filter'/>";					
				}
				?>
			</td>
		</tr>
		<tr class='green'>
			<td><input name='like[title]' type='text' size='15' value='<?php if(isset($_SESSION['filter']['user']['postData']['like']['title'])) { echo $_SESSION['filter']['user']['postData']['like']['title']; }?>'></td>
			<td><input name='like[dateAdded]' type='text' size='10' value='<?php if(isset($_SESSION['filter']['user']['postData']['like']['dateAdded'])) { echo $_SESSION['filter']['user']['postData']['like']['dateAdded']; }?>'></td>
			<td><input name='like[description]' type='text' size='10' value='<?php if(isset($_SESSION['filter']['user']['postData']['like']['description'])) { echo $_SESSION['filter']['user']['postData']['like']['description']; }?>'></td>
			<td><input name='like[description]' type='text' size='10' value='<?php if(isset($_SESSION['filter']['user']['postData']['like']['description'])) { echo $_SESSION['filter']['user']['postData']['like']['description']; }?>'></td>
			
			<td>
				<select name="equals[category]">
					<option></option>
					<?php
					foreach($categories AS $k => $v) {
						echo "<option value='$k' ";
						if(isset($_SESSION['filter']['user']['postData']['equals']['category'])) {
							if($_SESSION['filter']['user']['postData']['equals']['category'] == $k) {
								echo "selected='selected' ";
							}
						}
						echo ">$v</option>\n";
					}
					?>
				</select>
			</td>
			<td class='textCenter'>
			<?php
			if(isset($_SESSION['filter']) && array_key_exists("user",$_SESSION['filter'])) {
				echo "<input class='badButton' type='submit' name='action' value='Reapply Filter'/>";
			} else {
				echo "<input class='badButton' type='submit' name='action' value='Filter'/>";
			}
			?>
			</td>	
		</form>
	</tr>
	<?php
	if(isset($allArticles)) {
		foreach($allArticles AS $k => $v) {
				echo "<td>$v[title]</td>\n";
				echo "<td>" . date("d/m/Y",strtotime($v['dateAdded'])) . "</td>\n";
				echo "<td>$v[description]</td>\n";
				echo "<td>" . $categories[$v['category']] . "</td>\n";	
				echo "<td>" . $users[$v['addedBy']] . "</td>\n";	
				echo "<td class='textCenter'>\n
					<form action='editArticle.php' method='GET'>\n
						<input type='hidden' name='ID' value='$k'/>\n
						<input type='submit' value='Edit'/>\n
					</form>\n
				</td>\n";
			echo "</tr>\n";
		}
	}
	?>
</table>