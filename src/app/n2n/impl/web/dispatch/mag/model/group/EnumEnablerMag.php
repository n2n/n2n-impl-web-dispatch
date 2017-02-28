<?php
namespace n2n\impl\web\dispatch\mag\model\group;

use n2n\reflection\ArgUtils;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\impl\web\ui\view\html\HtmlUtils;
use n2n\web\ui\UiComponent;
use n2n\web\dispatch\mag\MagWrapper;
use n2n\impl\web\dispatch\mag\model\EnumMag;
use n2n\reflection\property\TypeConstraint;
use n2n\web\dispatch\map\bind\MappingDefinition;

class EnumEnablerMag extends EnumMag {
	private $associatedMagWrapperMap;
	private $htmlId;
	private $disabledIgnored = true;
	
	public function __construct($propertyName, $labelLstr, array $options, $value = null, bool $mandatory = false, 
			array $associatedMagWrapperMap = null) {
		parent::__construct($propertyName, $labelLstr, $options, $value, $mandatory);
		
		$this->setAssociatedMagWrapperMap((array) $associatedMagWrapperMap);
		$this->htmlId = HtmlUtils::buildUniqueId('n2n-impl-web-dispatch-enum-enabler-group');
		$this->setInputAttrs(array());
	}
	
	public function setInputAttrs(array $inputAttrs) {
		parent::setInputAttrs(HtmlUtils::mergeAttrs( array('class' => 'n2n-impl-web-dispatch-enum-enabler',
				'data-n2n-impl-web-dispatch-enabler-class' => $this->htmlId), $inputAttrs), $inputAttrs);
	}
	
	/**
	 * @param MagWrapper[][] $associatedMagWrapperMap
	 */
	public function setAssociatedMagWrapperMap(array $associatedMagWrapperMap) {
		ArgUtils::valArray($associatedMagWrapperMap, TypeConstraint::createArrayLike('array', false, 
				TypeConstraint::createSimple(MagWrapper::class)), false, 'associatedMagWrapperMap');
		$this->associatedMagWrapperMap = $associatedMagWrapperMap;
		
		foreach ($this->associatedMagWrapperMap as $value => $associatedMagWrappers) {
			foreach ($associatedMagWrappers as $associatedMagWrapper) {
				$associatedMagWrapper->addMarkAttrs(array('class' => $this->htmlId . ' ' . $this->htmlId . '-'
						. $value));
			}
		}
	}
	
// 	/**
// 	 * @param MagWrapper[] $associatedMagWrappers
// 	 */
// 	public function setAssociatedMagWrappers($value, array $associatedMagWrappers) {
// 		ArgUtils::valArray($associatedMagWrappers, MagWrapper::class, false, 'associatedMagWrappers');
// 		$this->associatedMagWrapperMap[$value] = $associatedMagWrappers;
// 	}
	
	/**
	 * @return MagWrapper[][] 
	 */
	public function getAssociatedMagWrapperMap() {
		return $this->associatedMagWrapperMap;
	}
	
	public function setupMappingDefinition(MappingDefinition $md) {
		parent::setupMappingDefinition($md);
		
		if (!$this->disabledIgnored || !$md->isDispatched()) return;
		
		$dispValue = $md->getDispatchedValue($this->propertyName);
		
		foreach ($this->associatedMagWrapperMap as $value => $associatedMagWrappers) {
			$ignored = $dispValue != $value;
			foreach ($associatedMagWrappers as $associatedMagWrapper) {
				$associatedMagWrapper->setIgnored($ignored);
			}
		}
	}
	
	public function createUiField(PropertyPath $propertyPath, HtmlView $view): UiComponent {
// 		$view->getHtmlBuilder()->meta()->addLibrary(new JQueryLibrary(3, true));
// 		$view->getHtmlBuilder()->meta()->bodyEnd()->addJs('js/ajah.js', 'n2n\impl\web\ui');
		$view->getHtmlBuilder()->meta()->addJs('js/group.js', 'n2n\impl\web\dispatch');
		
		return parent::createUiField($propertyPath, $view);
	}
}