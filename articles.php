<?php
require $_SERVER['DOCUMENT_ROOT'] . "/articles/includes/authcheck.php";
include $_SERVER['DOCUMENT_ROOT'] . "/articles/includes/db.php";
include $_SERVER['DOCUMENT_ROOT'] . "/articles/header.php";
$title = "Articles";

//$sql = "SELECT * FROM `categories` WHERE `deleted`!='yes' ORDER BY `ID` ASC";
$sql = "SELECT * FROM `categories` ORDER BY `catID` ASC";
$result = mysqli_query($connect,$sql);
while ($rows = mysqli_fetch_array($result)) {
	$categories[$rows['catID']] = $rows['cat'];
}
$sql = "SELECT * FROM `users` ORDER BY `userID` ASC";
$result = mysqli_query($connect,$sql);
while ($rows = mysqli_fetch_array($result)) {
	$users[$rows['userID']] = $rows['firstName'];
}


// echo "<pre>", print_r($_SESSION), "</pre>";

if(isset($_SESSION['filter']) && empty($_SESSION['filter'])) {
	unset($_SESSION['filter']);
}
// if(isset($_SESSION['advancedSearch'])) {
	// $advancedSearch = $_SESSION['advancedSearch'];
	// unset($_SESSION['advancedSearch']);
// }

// echo "<pre>", print_r($advancedSearch), "</pre>";

$epoch = date("Y-m-d H:i:s",(strtotime(date("Y-m-d H:i:s")) - 1209600));
$userID = $_SESSION['userID'];

// if(isset($advancedSearch) && $advancedSearch['filterTable'] == "userServiceTickets") {
	// $sql = $advancedSearch['sql'] . "&& (`owner` = '$userID' && `dateClosed` IS NULL) ORDER BY `nad`";
// } else
if(isset($_SESSION['filter']) && array_key_exists("user",$_SESSION['filter'])) {
	if(!empty($_SESSION['filter']['user']['results'])) {
		foreach($_SESSION['filter']['user']['results'] AS $k => $v) {
			$values[] = "`ID` = '$v'";
		}
		$sqlValues = implode(" || ", $values);
		unset($values);  // Not having this was fucking up the filters
		$sql = "SELECT * FROM `articles` WHERE ($sqlValues) ORDER BY `nad`";
	}
} else {
	$sql = "SELECT * FROM `articles` WHERE `addedBy` = '$userID' ORDER BY `dateAdded`";
}
if(isset($sql)) {
	$result = mysqli_query($connect, $sql);
	if($result) {
		while($rows = mysqli_fetch_assoc($result)) {
			foreach($rows AS $k => $v) {
				if($k != "articleID") {
					$userArticles[$rows['articleID']][$k] = $v;
				}
			}
		}
	}
}

// if(isset($advancedSearch) && $advancedSearch['filterTable'] == "openServiceTickets") {
	// $sql = $advancedSearch['sql'];
// } else
if(isset($_SESSION['filter']) && array_key_exists("open",$_SESSION['filter'])) {
	if(!empty($_SESSION['filter']['open']['results'])) {
		foreach($_SESSION['filter']['open']['results'] AS $k => $v) {
			$values[] = "`ID` = '$v'";
		}
		$sqlValues = implode(" || ", $values);
		unset($values);  // Not having this was fucking up the filters
		$sql = "SELECT * FROM `serviceTickets` WHERE ($sqlValues) ORDER BY `nad`";
	}
} else {
	$sql = "SELECT * FROM `articles` ORDER BY `dateAdded`";
}
if(isset($sql)) {
	$result = mysqli_query($connect, $sql);
	if($result) {
		while($rows = mysqli_fetch_assoc($result)) {
			foreach($rows AS $k => $v) {
				if($k != "articleID") {
					$allArticles[$rows['articleID']][$k] = $v;
				}
				$openOwners[$rows['addedBy']] = $users[$rows['addedBy']];
			}
			if(isset($openOwners)) {
				asort($openOwners);
			}
		}
	}
}




echo "<div id='singleBox'>";
	if(!isset($advancedSearch)) {
		echo "<h1 class='textCenter'>Articles</h1>";
	} else {
		echo "<h1 class='textCenter'>Filtering $advancedSearch[filterTable] in Service Desk for:</h1>";
		echo "<table class='textLeft centerTable'>";
			if(isset($advancedSearch['user'])) {
				foreach($advancedSearch['user'] AS $k => $v) {
					if(is_array($v)) {
						echo "<tr class='otherGreen'>";
							echo "<td>";
							foreach($v AS $sK => $sV) {
								echo $sV;
								if(isset($advancedSearch['op'][$k][$sK])) {
									echo "<span class='bold'> " . $advancedSearch['op'][$k][$sK] . " </span>";
								}
							}
							echo "</td>";
						} else {
							echo "<tr class='lightGreen'>";
								echo "<td class='lightGreen'>$v</td>";
						}
					echo "</tr>";
					if(isset($advancedSearch['op'][$k])) {
						if(is_array($advancedSearch['op'][$k])) {
							echo "<tr><td class='bold' colspan='2'>" . $advancedSearch['op'][$k]['comp'] . "</td></tr>";
						} else {
							echo "<tr><td class='bold' colspan='2'>" . $advancedSearch['op'][$k] . "</td></tr>";
						}
					}
				}
			}
		echo "</table>";
	}
	include "newArticle.php"; /*
	?>
	<div id='navItem'>
		<ul>
			<li><a href='/articles/members/archive/feedback.php'>Daily Feedback Report</a></li>
		</ul>
	</div>
	<?php */
	include "caseFinder.php";
	if(isset($_SESSION['errors'])) {
		echo "<table class='centerTable'>\n";
		foreach($_SESSION['errors'] AS $k => $e) {
			echo "<tr><td class='textRed'>$e</td></tr>\n";
		}
		echo "</table>\n";
		unset($_SESSION['errors']);
	} 
	if(!isset($_SESSION['caseSearch'])) {
		// if(isset($_SESSION['filter']['errors'])) {
			// echo "<table class='centerTable'>\n";
			// foreach($_SESSION['filter']['errors'] AS $k => $e) {
				// echo "<tr><td class='textRed'>$e</td></tr>\n";
			// }
			// echo "</table>\n";
			// unset($_SESSION['filter']['errors']);
		// }
		if(isset($_SESSION['filter'])) {
			echo "<form action='caseSearch.php' method='POST'>\n";
				echo "<p class='textCenter'><input type='submit' name='action' value='Clear All Filters'></p>\n";
				echo "<input type='hidden' name='fromPage' value='/articles/members/archive/articles.php' />";
				echo "<input type='hidden' name='page' value='filter' />";
			echo "</form>\n";
		}		
		include "userArticles.php";
		include "allArticles.php";
	}
echo "</div>";

// unset($_SESSION['postData']);
?>