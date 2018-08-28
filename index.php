<?php
	$event_name = "Photo Gallery";
	$album_name = "By Your Name";
	$date_name = "";
	$display = "";

	include("engine.php");

?>

<html>

<head>
	<title><?php echo "$event_name | $album_name"; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<LINK REL=StyleSheet HREF="css/css.css" TYPE="text/css" MEDIA=screen>
	<link rel="icon" type="image/png" href="favicon.png" />

	<!-- Add jQuery library -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>

	<!-- Optionally add helpers - button, thumbnail and/or media -->
	<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
	<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

	<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
	<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox({
				openEffect	: 'none',
				closeEffect	: 'none'
			});
		});
	</script>

</head>

<body>
	<div id="content">
		<a href="index.php"><div id="header">
		</div></a>

		<table>
		<tr>
		<td style="vertical-align: top">
		<div id="menu">

		<?php
		$dates = scandir("photos/");
		unset($dates[0]); // .
		unset($dates[1]); // ..

		foreach ($dates as $date_key => $date) {
			echo "<div id=\"date\"><h1>".$date."</h1></br/>";
			$events = scandir("photos/".$date."/");
			unset($events[0]); // .
			unset($events[1]); // ..

			foreach ($events as $event_key => $event) {
				echo "<a href=\"index.php?date=$date&event=$event\"><h2>".$event."</h2></a><br/>";
				$albums = scandir("photos/".$date."/".$event);

				unset($albums[0]); // .
				unset($albums[1]); // ..

				foreach ($albums as $albums_key => $album) {
					echo "<a href=\"index.php?date=$date&event=$event&album=$album\">$album</a><br/>";
				}

			}
			echo "</div>";
		}

		?>

		</div>
		</td>
		<td style="vertical-align: top">

		<div id="photos">

		<div id="title">
			<?php echo "$event_name - $album_name - $date_name"; ?>
		</div>

		<?php
			if($display == "photos")
			{
				$file = scandir($path);
				$file_dl = array();

				foreach ($file as &$photo) //all files in folder
				{
					if(substr($photo, 0, 6) == "thumb_"  && ( substr(strrchr(strtolower($photo),'.'),1) == "jpg" || substr(strrchr(strtolower($photo),'.'),1) == "png" || substr(strrchr(strtolower($photo),'.'),1) == "bmp" || substr(strrchr(strtolower($photo),'.'),1) == "gif") ) //big photo
					{
						$photo_big = substr($photo, 6, strlen($photo));
						echo "<div id=\"photobox\"><a class=\"fancybox\" data-fancybox=\"gallery\" href=\"$path$photo_big\" rel=$album title=\"".substr($photo_big, 0, strlen($photo_big)-4)."\"><span class=\"middle\"></span><img src=\"$path$photo\"/></a></div>";
					}

					else if (substr(strrchr($photo,'.'),1) == "zip" || substr(strrchr($photo,'.'),1) == "rar")
					{
						array_push($file_dl, $photo);
					}
				}

				if (count($file_dl) != 0)
				{
					echo "<hr><br/>
					<h2>Téléchargements :</h2>";

					foreach ($file_dl as &$dl)
					{
						echo "<a href=\"$path$dl\" id=\"link_dl\">$dl</a><br/>";
					}
				}
			}

			else if ($display == "event")
			{
				$file = scandir($path);
				unset($file[0]);
				unset($file[1]);

				foreach ($file as $event_key => $event) {
					$files_in_album = scandir($path."/".$event);
					$thumbs_in_album = array_values(preg_grep("/thumb_/", $files_in_album));
					$bg_event = $path.$event."/".$thumbs_in_album[rand(0, sizeof($thumbs_in_album)-1)];

					echo "<a href=\"index.php?date=$date_name&event=$event_name&album=$event\"><div id=\"event\" style=\"background-image: url('".$bg_event."') !important\"><p>".$event."</p></div></a>";
				}
			}

			else
			{
				echo '<div id="photo_finish"><img src="photo_finish.png"/></div>';
			}
		?>
		</div>

		</td>
		</tr>
		</table>

	</div>

	<div id="footer">
	Your Name | Les photos appartiennent à leurs propriétaires respectifs | Demander la suppression d'une image : <a href="mailto:yourname@yourmail.com">yourname@yourmail.com</a>
	</div>
	</div>

</body>

</html>