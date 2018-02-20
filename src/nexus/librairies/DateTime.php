<?php

namespace Codisart;

class DateTime extends \DateTime {

	const MOIS = [
		1 => "Janvier",
		2 => "Février",
		3 => "Mars",
		4 => "Avril",
		5 => "Mai",
		6 => "Juin",
		7 => "Juillet",
		8 => "Août",
		9 => "Septembre",
		10 => "Octobre",
		11 => "Novembre",
		12 => "Décembre"
	];

	public function format($format) {
		if (preg_match('/(?<![\\\\])F/', $format)) {
			$formatParts = preg_split('/(?<![\\\\])F/', $format);
			$finalPart = array_pop($formatParts);

			$dateString = "";
			foreach ($formatParts as $key => $part) {
				$dateString .= parent::format($part).self::MOIS[parent::format('n')];
			}
			$dateString .= parent::format($finalPart);

			return $dateString;
		}
		return parent::format($format);
	}
}
