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
use n2n\impl\web\ui\view\html\HtmlElement;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\reflection\property\AccessProxy;
use n2n\impl\web\dispatch\property\ScalarProperty;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\ui\view\html\HtmlBuilderMeta;
use n2n\web\ui\UiComponent;
use n2n\web\dispatch\property\ManagedProperty;

/**
 * Class StringArrayMag
 * @package n2n\impl\web\dispatch\mag\model
 */
class StringArrayMag extends MagAdapter {
	const DEFAULT_NUM_ADDITIONS = 5;
	private $inputAttrs;
	private $mandatory;

	/**
	 * StringArrayMag constructor.
	 * @param $label
	 * @param array $values
	 * @param bool $mandatory
	 * @param array|null $inputAttrs
	 * @param array|null $containerAttrs
	 */
	public function __construct($label, array $values = array(),
			$mandatory = false, array $inputAttrs = null, array $containerAttrs = null) {
		parent::__construct($label, $values, $containerAttrs);
		$this->mandatory = (bool) $mandatory;
		$this->inputAttrs = $inputAttrs;
	}

	/**
	 * @param $mandatory
	 */
	public function setMandatory($mandatory) {
		$this->mandatory = (boolean) $mandatory;
	}

	/**
	 * @return bool
	 */
	public function isMandatory(): bool {
		return $this->mandatory;
	}

	/**
	 * @param PropertyPath $propertyPath
	 * @param HtmlView $view
	 * @return UiComponent
	 */
	public function createUiField(PropertyPath $propertyPath, HtmlView $view, UiOutfitter $uiOutfitter): UiComponent {
		$formHtml = $view->getFormHtmlBuilder();
		$StringMags = $formHtml->meta()->getMapValue($propertyPath);
		$uiComponent = new HtmlElement('ul', array('class' => 'n2n-option-array', 'data-num-existing' => count($StringMags)));
		
		foreach ($StringMags as $key => $value) {
			if (!isset($value)) continue;
			$uiComponent->appendContent(new HtmlElement('li', null, 
					$formHtml->getInput($propertyPath->createArrayFieldExtendedPath($key))));
		}
		
		for ($i = 0; $i < self::DEFAULT_NUM_ADDITIONS; $i++) {
			$uiComponent->appendContent(new HtmlElement('li', null,
					$formHtml->getInput($propertyPath->createArrayFieldExtendedPath(null))));
		} 
		return new HtmlElement('div', array('class' => 'n2n-array-option'), $uiComponent);
	}

	/**
	 * @param AccessProxy $accessProxy
	 * @return ManagedProperty
	 */
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ScalarProperty($accessProxy, true);
	}

	/* (non-PHPdoc)
	 * @see \n2n\web\dispatch\mag\Mag::setupBindingDefinition()
	 */
	public function setupBindingDefinition(BindingDefinition $bd) {
		if ($this->mandatory) {
			$bd->val($this->propertyName, new ValNotEmpty());
		}
	}
}
