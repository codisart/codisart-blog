<?php

	class Image
	{

		protected $resource;
		protected $info;
		protected $filename;

		
		public function __construct($filename)
		{
			if (is_file($filename))
			{
				$this->filename = $filename;
				$this->info = getimagesize($this->filename);
			} 
			else
			{
				trigger_error("Le fichier '$filename' n'existe pas !", E_USER_WARNING);
			}
		}

		
		public function resize_to($maxWidth, $maxHeight)
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

		public function save_as($filename)
		{
			$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			switch($this->info[2]) {

				case IMAGETYPE_PNG:  imagepng ($this->get_resource(), $filename); break;
				case IMAGETYPE_JPEG: imagejpeg($this->get_resource(), $filename); break;
				case IMAGETYPE_GIF:  imagegif ($this->get_resource(), $filename); break;
				default :
					trigger_error("Type de fichier incompatible. Veuillez sauvegarder l' image en .gif, .png ou .jpg", E_USER_WARNING);
			}
			$this->filename = $filename;
			return $this;
		}

		public function get_filename()
		{
			return $this->filename;
		}

		protected function get_resource()
		{
			if (empty($this->resource))
			{
				switch($this->info[2])
				{

					case IMAGETYPE_PNG:  $this->resource = imagecreatefrompng($this->filename); break;
					case IMAGETYPE_JPEG: $this->resource = imagecreatefromjpeg($this->filename);  break;
					case IMAGETYPE_GIF:  $this->resource = imagecreatefromgif($this->filename); break;
					default :
						trigger_error("Type de fichier incompatible. Veuillez utiliser une image .gif, .png ou .jpg", E_USER_WARNING);
				}
			}
			return $this->resource;
		}
	}
