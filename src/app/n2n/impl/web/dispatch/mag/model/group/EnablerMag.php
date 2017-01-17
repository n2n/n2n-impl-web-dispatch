<?php
namespace n2n\impl\web\dispatch\mag\model\group;

use n2n\impl\web\dispatch\mag\model\BoolMag;
use n2n\reflection\ArgUtils;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\impl\web\ui\view\html\HtmlUtils;
use n2n\web\ui\UiComponent;
use n2n\web\dispatch\mag\MagWrapper;

class EnablerMag extends BoolMag {
	private $associatedMagWrappers;
	private $htmlId;
	
	public function __construct($propertyName, $labelLstr, bool $value = false, array $associatedMags = null) {
		parent::__construct($propertyName, $labelLstr, $value);
		
		$this->setAssociatedMags((array) $associatedMags);
		$this->htmlId = HtmlUtils::buildUniqueId('n2n-impl-web-dispatch-enabler-group-');
		$this->setInputAttrs(array());
	}
	
	public function setInputAttrs(array $inputAttrs) {
		parent::setInputAttrs(HtmlUtils::mergeAttrs(array('class' => 'n2n-impl-web-dispatch-enabler',
				'data-n2n-impl-web-dispatch-enabler-class' => $this->htmlId), $inputAttrs));
	}
	
	/**
	 * @param MagWrapper[] $associatedMags
	 */
	public function setAssociatedMags(array $associatedMagWrappers) {
		ArgUtils::valArray($associatedMagWrappers, MagWrapper::class, false, 'associatedMagWrappers');
		$this->associatedMagWrappers = $associatedMagWrappers;
	}
	
	/**
	 * @return MagWrapper[] 
	 */
	public function getAssociatedMagWrappers() {
		return $this->associatedMagWrappers;
	}
	
	public function createUiField(PropertyPath $propertyPath, HtmlView $view): UiComponent {
// 		$view->getHtmlBuilder()->meta()->addLibrary(new JQueryLibrary(3, true));
// 		$view->getHtmlBuilder()->meta()->bodyEnd()->addJs('js/ajah.js', 'n2n\impl\web\ui');
		$view->getHtmlBuilder()->meta()->addJs('js/group.js', 'n2n\impl\web\dispatch');
		
		foreach ($this->associatedMagWrappers as $associatedMagWrapper) {
			$associatedMagWrapper->addMarkAttrs(array('class' => $this->htmlId));
		}
			
		return parent::createUiField($propertyPath, $view);
	}
}