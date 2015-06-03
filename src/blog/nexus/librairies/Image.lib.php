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
	imagepng($miniature, 'images/'.$dossierImages.'/miniatures/'.$image);
}