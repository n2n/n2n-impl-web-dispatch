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
 * Bert Hofmänner.......: Idea, Community Leader, Marketing
 * Thomas Günther.......: Developer, Hangar
 */
namespace n2n\impl\web\dispatch\mag\model;

use n2n\impl\web\dispatch\map\val\ValNotEmpty;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\impl\web\dispatch\map\val\ValMaxLength;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\dispatch\property\ScalarProperty;
use n2n\reflection\property\AccessProxy;
use n2n\web\dispatch\property\ManagedProperty;
use n2n\web\ui\UiComponent;

class StringMag extends MagAdapter {
	private $mandatory;
	private $maxlength;
	private $multiline;
	private $inputAttrs;
	
	public function __construct(string $propertyName, $label, $value = null, bool $mandatory = false, 
			int $maxlength = null, bool $multiline = false, array $attrs = null, array $inputAttrs = null) {
		parent::__construct($propertyName, $label, $value, $attrs);
		$this->mandatory = $mandatory;
		$this->maxlength = $maxlength;
		$this->multiline = $multiline;
		$this->inputAttrs = (array) $inputAttrs;
	}	
	
	public function setMandatory(bool $mandatory) {
		$this->mandatory = $mandatory;
	} 
	
	public function isMandatory(): bool {
		return $this->mandatory;
	}
	
	public function setMaxlength(int $maxlength = null) {
		$this->maxlength = $maxlength;
	}
	
	public function getMaxlength() {
		return $this->maxlength;
	}
	
	public function setMultiline(bool $multiline) {
		$this->multiline = $multiline;
	}
	
	public function isMultiline() {
		return $this->multiline;
	}
	
	public function setInputAttrs(array $inputAttrs) {
		$this->inputAttrs = $inputAttrs;
	}
	
	public function getInputAttrs() {
		return $this->inputAttrs;
	}
	
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ScalarProperty($accessProxy, false);
	}
	
	public function setupBindingDefinition(BindingDefinition $bd) {
		if ($this->mandatory) {
			$bd->val($this->propertyName, new ValNotEmpty());
		}
		
		if ($this->maxlength !== null) {
			$bd->val($this->propertyName, new ValMaxLength((int) $this->maxlength));
		}
	}

	public function createUiField(PropertyPath $propertyPath, HtmlView $htmlView): UiComponent {
		if ($this->isMultiline()) {
			return $htmlView->getFormHtmlBuilder()->getTextarea($propertyPath, $this->inputAttrs);
		}
		return $htmlView->getFormHtmlBuilder()->getInput($propertyPath, $this->inputAttrs);
	}
}
