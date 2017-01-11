<?php

namespace n2n\impl\web\dispatch\mag\model;

use n2n\impl\web\dispatch\property\ObjectProperty;
use n2n\reflection\property\AccessProxy;
use n2n\web\dispatch\property\ManagedProperty;
use n2n\web\dispatch\map\bind\BindingDefinition;

class OptionalMag extends MagAdapter {
	private $propertyName;
	private $label;
	private $value;
	
	public function __construct($label, $value = null) {
		$this->label = $label;
	}
	/**
	 * {@inheritDoc}
	 * @see \n2n\web\dispatch\mag\Mag::createManagedProperty()
	 */
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ObjectProperty($accessProxy, true);
	}

	/**
	 * {@inheritDoc}
	 * @see \n2n\web\dispatch\mag\Mag::setupBindingDefinition()
	 */
	public function setupBindingDefinition(BindingDefinition $bindingDefinition) {
		
		
	}

	/**
	 * {@inheritDoc}
	 * @see \n2n\web\dispatch\mag\Mag::createUiField()
	 */
	public function createUiField(\n2n\web\dispatch\map\PropertyPath $propertyPath, \n2n\impl\web\ui\view\html\HtmlView $view): UiComponent {
		// TODO Auto-generated method stub
		
	}

}

