<?php

namespace n2n\impl\web\dispatch\mag\model;

use n2n\impl\web\ui\view\html\HtmlView;
use n2n\web\dispatch\mag\UiOutfitter;
use n2n\web\dispatch\map\PropertyPath;
use n2n\web\ui\UiComponent;

class BasicUiOutfitter implements UiOutfitter {

	/**
	 * @param string $nature
	 * @return array
	 */
	public function buildAttrs(int $nature): array {
		return array();
	}

	/**
	 * @param PropertyPath $propertyPath
	 * @param HtmlView $contextView
	 * @return UiComponent
	 */
	public function createMagDispatchableView(PropertyPath $propertyPath = null, HtmlView $contextView): UiComponent {
		return $contextView->getImport('\n2n\impl\web\dispatch\mag\view\magForm.html', array('propertyPath' => null));
	}
}