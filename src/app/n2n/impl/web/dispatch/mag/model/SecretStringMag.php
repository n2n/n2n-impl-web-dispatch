<?php
/*
 * Copyright (c) 2012-2016, Hofmänner New Media.
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS FILE HEADER.
 *
 * This file is part of the N2N FRAMEWORK.
 *
 * The N2N FRAMEWORK is free software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * N2N is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details: http://www.gnu.org/licenses/
 *
 * The following people participated in this project:
 *
 * Andreas von Burg.....: Architect, Lead Developer
 * Bert Hofmänner.......: Idea, Frontend UI, Community Leader, Marketing
 * Thomas Günther.......: Developer, Hangar
 */
namespace n2n\impl\web\dispatch\mag\model;

use n2n\impl\web\dispatch\map\val\ValNotEmpty;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\impl\web\dispatch\map\val\ValMaxLength;
use n2n\web\dispatch\map\BindingConstraints;
use n2n\web\ui\UiComponent;
use n2n\reflection\property\AccessProxy;
use n2n\impl\web\dispatch\property\ScalarProperty;
use n2n\web\dispatch\property\ManagedProperty;
use n2n\web\dispatch\map\bind\BindingDefinition;

class SecretStringMag extends MagAdapter {
	private $maxlength;
	private $required;
	
	public function __construct($properyName, $labelStr, $value = null, bool $required = false, $maxlength = null, array $attrs = null) {
		parent::__construct($properyName, $labelStr, $value, $attrs);
		$this->maxlength = $maxlength;
		$this->required = $required;
	}
	
	public function setMaxlength($maxlength) {
		$this->maxlength = $maxlength;
	}
	
	public function getMaxlength() {
		return $this->maxlength;
	}
	
	public function isRequired(): bool {
		return $this->required;
	}
	
	public function setRequired(bool $required) {
		$this->required = $required;
	}
	
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ScalarProperty($accessProxy, false);
	}
	
	public function setupBindingDefinition(BindingDefinition $bd) {
		if ($this->isRequired()) {
			$bd->val($this->propertyName, new ValNotEmpty());
		}
		
		if (isset($this->maxlength)) {
			$bd->val($this->propertyName, new ValMaxLength((int) $this->maxlength));
		}
	}
	
	public function createUiField(PropertyPath $propertyPath, HtmlView $htmlView): UiComponent {
		return $htmlView->getFormHtmlBuilder()->getInput($propertyPath, $this->getAttrs(), null, true);
	}
}
