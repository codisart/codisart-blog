<?php 

/* Image.lib.php */


function afficherGalerie($dossierImages) {
	$referenceDossierImages = opendir('images/'.$dossierImages) or die('Erreur');
					
	for ( $i = 1 ; $i < 20 ; $i++) {						
		$image = readdir($referenceDossierImages);	

		if($image && $image != 'Thumbs.db' && $image!= 'miniatures' && $image!= 'testGD.php' && $image != '.'  && $image != '..') {

			if(!is_file('images/'.$dossierImages.'/miniatures/'.$image)) {							
				createMiniature();
			}
			
			echo '<img id="mini'.$image.'"  alt="'.$image.'" height="74" src="images/'.$dossierImages.'/miniatures/'.$image.'" onclick="afficherImageTailleReelle(this.id);"/>';	
		}		
	}				
}

function createMiniature() {
	$source = imagecreatefromjpeg('images/'.$dossierImages.'/'.$image);
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