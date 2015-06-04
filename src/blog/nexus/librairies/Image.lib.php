<?php 

/* Image.lib.php */

function createMiniature() {
	$source = imagecreatefromjpeg('images/image.jpg');
	$largeur = imagesx($source);
	$hauteur = imagesy($source);

	$proportionH = $hauteur / 89;
	$proportionL = $largeur / 144;

	if( $proportionH >= $proportionL) {
		$largeurMin = $largeur / $proportionH;

		$sourceMin = imagecreatetruecolor($largeurMin,89);

		$miniature = imagecreatetruecolor(144, 89);

		$miniatureX = (72 +1) - $largeurMin/2;

		imagecopyresampled($sourceMin, $source, 0, 0, 0, 0, $largeurMin, 89, $largeur, $hauteur);

		imagecopymerge($miniature, $sourceMin, $miniatureX, 0, 0, 0, 144, 89, 100);
	} else  {
		$hauteurMin = $hauteur / $proportionL;

		$sourceMin = imagecreatetruecolor(144,$hauteurMin);

		$miniature = imagecreatetruecolor(144, 89);

		$miniatureY = (44.5 +1) - $hauteurMin/2;

		imagecopyresampled($sourceMin, $source, 0, 0, 0, 0, 144, $hauteurMin, $largeur, $hauteur);

		imagecopymerge($miniature, $sourceMin, 0, $miniatureY, 0, 0, 144, 89, 100);
	}
	imagepng($miniature, 'images/miniatures/'.$image);
}

function resize_to($maxWidth, $maxHeight)
		{
			//If image dimension is smaller, do not resize
			if ($this->info[0] <= $max_width && $this->info[1] <= $max_height)
			{
				$new_height = $this->info[1];
				$new_width = $this->info[0];
			}
			else
			{
				if ($max_width/$this->info[0] > $max_height/$this->info[1])
				{
					$new_width = (int)round($this->info[0]*($max_height/$this->info[1]));
					$new_height = $max_height;
				}
				else
				{
					$new_width = $max_width;
					$new_height = (int)round($this->info[1]*($max_width/$this->info[0]));
				}
			}

			$new_img = imagecreatetruecolor($new_width, $new_height);

			// If image is PNG or GIF, set it transparent
			if(($this->info[2] == 1) OR ($this->info[2]==3))
			{
				imagealphablending($new_img, false);
				imagesavealpha($new_img, true);
				$transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
				imagefilledrectangle($new_img, 0, 0, $new_width, $new_height, $transparent);
			}

			imagecopyresampled($new_img, $this->get_resource(), 0, 0, 0, 0, $new_width, $new_height, $this->info[0], $this->info[1]);

			imagedestroy($this->resource);
			$this->resource = $new_img;

			$this->info[0] = $new_width;
			$this->info[1] = $new_height;

			return $this;
		}