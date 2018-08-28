<?php

	$path = "photos/";

	if(isset($_GET['date']))
	{

		$date_name = str_replace("/", "", $_GET['date']);
		$date_name = str_replace(".", "", $date_name);
		$date_name = str_replace(">", "", $date_name);
		$date_name = str_replace("<", "", $date_name);

		$path .= $date_name."/";

		if(isset($_GET['event']))
		{

			$event_name = str_replace("/", "", $_GET['event']);
			$event_name = str_replace(".", "", $event_name);
			$event_name = str_replace(">", "", $event_name);
			$event_name = str_replace("<", "", $event_name);

			$path .= $event_name."/";

			if(isset($_GET['album']))
			{
				$display = "photos";

				$album_name = str_replace("/", "", $_GET['album']);
				$album_name = str_replace(".", "", $album_name);
				$album_name = str_replace(">", "", $album_name);
				$album_name = str_replace("<", "", $album_name);

				$path .= $album_name."/";
				$file = scandir($path);
				unset($file[0]);
				unset($file[1]);

				foreach ($file as &$photo) //all files in folder
				{
					if(substr($photo, 0, 6) != "thumb_" && ( substr(strrchr($photo,'.'),1) == "jpg" || substr(strrchr($photo,'.'),1) == "png" || substr(strrchr($photo,'.'),1) == "bmp" || substr(strrchr($photo,'.'),1) == "gif") ) //big photo
					{
						if(!file_exists($path."thumb_".$photo)) //no thumb associated
						{
							createThumbs(200, $path."thumb_".$photo, $path.$photo);
						}
					}
				}
			}

			else //event only
			{
				$display = "event";
			}
		}
	}

	function createThumbs($newSize, $targetFile, $originalFile) {
	    
	    $extension = strtolower(end(explode('.', $originalFile)));

	    if($extension == 'jpg')
	    {
	    	$img = imagecreatefromjpeg($originalFile);
	    }

	    else if($extension == 'png')
	    {
	    	$img = imagecreatefrompng($originalFile);
	    }

	    else if($extension == 'gif')
	    {
	    	$img = imagecreatefromgif($originalFile);
	    }

		$width = imagesx($img);
	    $height = imagesy($img);

	    list($width, $height) = getimagesize($originalFile);

	    if ($height > $width)
	    {
	    	$newWidth = ($width / $height) * $newSize;
	    	$newHeight = $newSize;
	    }

	    else
	    {
	        $newHeight = ($height / $width) * $newSize;
	        $newWidth = $newSize;
	    }

	    $tmp = imagecreatetruecolor($newWidth, $newHeight);
	    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);


	    if($extension == 'jpg')
	    {
	    	imagejpeg($tmp, $targetFile);
	    }

	    else if($extension == 'png')
	    {
	    	imagepng($tmp, $targetFile);
	    }

	    else if($extension == 'gif')
	    {
	    	imagegif($tmp, $targetFile);
	    }
	    
	    
	}
	
?>