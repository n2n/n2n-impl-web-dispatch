<?php

namespace n2n\impl\web\dispatch\mag\model;

use n2n\impl\web\ui\view\html\HtmlElement;
use n2n\impl\web\ui\view\html\HtmlSnippet;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\web\dispatch\mag\UiOutfitter;
use n2n\web\dispatch\map\PropertyPath;
use n2n\web\ui\UiComponent;

class BasicUiOutfitter implements UiOutfitter {

	/**
	 * @param string $nature
	 * @return array
	 */
	public function createAttrs(int $nature): array {
		return array();
	}

	public function createElement(int $elemNature, array $attrs = null, $contents = null): UiComponent {
		if ($elemNature & self::EL_NATRUE_CONTROL_ADDON_SUFFIX_WRAPPER) {
			return new HtmlElement('div', $attrs, $contents);
		}

		if ($elemNature & self::EL_NATURE_CONTROL_ADDON_WRAPPER) {
			return new HtmlElement('span', $attrs, $contents);
		}

		return new HtmlSnippet($contents);
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