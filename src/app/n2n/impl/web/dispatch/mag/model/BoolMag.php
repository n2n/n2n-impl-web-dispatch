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

use n2n\impl\web\ui\view\html\HtmlElement;
use n2n\impl\web\ui\view\html\HtmlUtils;
use n2n\l10n\Lstr;
use n2n\web\dispatch\mag\UiOutfitter;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\reflection\property\AccessProxy;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\dispatch\property\ScalarProperty;
use n2n\web\dispatch\property\ManagedProperty;
use n2n\web\ui\UiComponent;
use n2n\reflection\ArgUtils;

/**
 * Class BoolMag
 * @package n2n\impl\web\dispatch\mag\model
 */
class BoolMag extends MagAdapter {
	private $inputAttrs = array();

	/**
	 * BoolMag constructor.
	 * @param string|Lstr $labelLstr
	 * @param bool $value
	 * @param array|null $attrs
	 * @param array|null $inputAttrs
	 */
	public function __construct($labelLstr, bool $value = false,
			array $attrs = null, array $inputAttrs = null) {
		parent::__construct($labelLstr, $value, $attrs);
		$this->inputAttrs = (array) $inputAttrs;
	}
	
	/**
	 * @param array $inputAttrs
	 */
	public function setInputAttrs(array $inputAttrs) {
		ArgUtils::valArray($inputAttrs, 'scalar');
		$this->inputAttrs = $inputAttrs;
	}
	
	/**
	 * @return array
	 */
	public function getInputAttrs(): array {
		return $this->inputAttrs;
	}

	/**
	 * @param AccessProxy $accessProxy
	 * @return ManagedProperty
	 */
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ScalarProperty($accessProxy, false);
	}

	/**
	 * @param BindingDefinition $bd
	 */
	public function setupBindingDefinition(BindingDefinition $bd) {
	}

	/**
	 * @param PropertyPath $propertyPath
	 * @param HtmlView $view
	 * @return UiComponent
	 */
	public function createUiField(PropertyPath $propertyPath, HtmlView $view, UiOutfitter $uiOutfitter): UiComponent {
		$formHtml = $view->getFormHtmlBuilder();

		if (null !== $uiOutfitter) {
			$attrs = HtmlUtils::mergeAttrs($uiOutfitter->buildAttrs(UiOutfitter::NATURE_CHECK), $this->inputAttrs);
		}

		$uiField = new HtmlElement('div', $uiOutfitter->buildAttrs(UiOutfitter::NATURE_CHECK_WRAPPER));
		$label = $formHtml->getLabel('', '', $uiOutfitter->buildAttrs(UiOutfitter::NATURE_CHECK_LABEL));
		$uiField->appendLn($label);
		$checkbox = $view->getFormHtmlBuilder()->getInputCheckbox($propertyPath, true, $attrs);
		$label->appendLn($checkbox);
		return $uiField;
	}

	/**
	 * @param mixed $formValue
	 */
	public function setFormValue($formValue) {
		$this->value = (bool) $formValue;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->value = (bool) $value;
	}
}
