<?php

namespace n2n\impl\web\dispatch\mag\model;

use n2n\impl\web\ui\view\html\HtmlView;
use n2n\web\dispatch\mag\UiOutfitter;

class BasicUiOutfitter implements UiOutfitter {

	/**
	 * @param string $nature
	 * @return array
	 */
	public function buildAttrs(string $nature): array {
		switch ($nature) {
			case UiOutfitter::NATURE_TEXT :
				return array('class' => '');
				break;
			case UiOutfitter::NATURE_CHECK:
				return array('class' => '');
				break;
			case UiOutfitter::NATURE_CHECK_LABEL:
				return array('class' => '');
			case UiOutfitter::NATURE_CHECK_WRAPPER:
				return array('class' => '');
		}
	}

	public function createMagCollectionView(HtmlView $view, UiOutfitter $uiOutfitter, $propertyPath, $numExisting, $num, $min): HtmlView {
		return $view->getImport('\n2n\impl\web\dispatch\mag\view\magCollectionArrayMag.html',
				array('propertyPath' => $propertyPath, 'numExisting' => $numExisting, 'num' => $num, 'min' => $min, 'uiOutfitter' => $uiOutfitter));
	}
}