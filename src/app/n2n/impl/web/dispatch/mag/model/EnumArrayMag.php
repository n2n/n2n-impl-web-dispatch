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
use n2n\l10n\DynamicTextCollection;
use n2n\l10n\Lstr;
use n2n\web\dispatch\mag\UiOutfitter;
use n2n\web\dispatch\map\PropertyPath;
use n2n\impl\web\ui\view\html\HtmlView;
use n2n\impl\web\dispatch\map\val\ValEnum;
use n2n\reflection\property\AccessProxy;
use n2n\impl\web\dispatch\property\ScalarProperty;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\impl\web\ui\view\html\HtmlBuilderMeta;
use n2n\web\dispatch\property\ManagedProperty;
use n2n\web\ui\Raw;
use n2n\web\ui\UiComponent;

/**
 * Class EnumArrayMag
 * @package n2n\impl\web\dispatch\mag\model
 */
class EnumArrayMag extends MagAdapter {
	const DEFAULT_NUM_ADDITIONS = 1;
	
	private $mandatory;
	private $inputAttrs;
	private $options;

	/**
	 * EnumArrayMag constructor.
	 * @param string|Lstr $label
	 * @param array $options
	 * @param array|null $value
	 * @param bool $mandatory
	 * @param array|null $inputAttrs
	 */
	public function __construct($label, array $options = null, array $value = null,
			bool $mandatory = false, array $inputAttrs = null) {
		parent::__construct($label, $value);

		$this->mandatory = $mandatory;
		$this->options = $options;
		$this->inputAttrs = $inputAttrs;
	}

	/**
	 * @param array $options
	 */
	public function setOptions(array $options) {
		$this->options = $options;
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

	/**
	 * @param AccessProxy $accessProxy
	 * @return ManagedProperty
	 */
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ScalarProperty($accessProxy, true);
	}

	/**
	 * @param BindingDefinition $bd
	 */
	public function setupBindingDefinition(BindingDefinition $bd) {
		if ($this->mandatory) {
			$bd->val($this->propertyName, new ValNotEmpty());
		}
		
		$bd->val($this->propertyName, new ValEnum(array_keys($this->options)));
	}

	/**
	 * @param PropertyPath $propertyPath
	 * @param HtmlView $view
	 * @return UiComponent
	 */
	public function createUiField(PropertyPath $propertyPath, HtmlView $view, UiOutfitter $uiOutfitter): UiComponent {
		$dtc = new DynamicTextCollection('n2n\impl\web\dispatch', $view->getN2nLocale());
		$formHtml = $view->getFormHtmlBuilder();
		$values = $formHtml->meta()->getMapValue($propertyPath);

		$uiComponent = new HtmlElement('ul', array('class' => 'n2n-impl-web-dispatch-array-mag',
				'data-remove-word' => $dtc->t('mag_remove'),
				'data-add-word' => $dtc->t('mag_add')));
		foreach ($values as $key => $value) {
			$uiComponent->appendContent(new HtmlElement('li', null,
					$formHtml->getSelect($propertyPath->fieldExt($key), $this->options)));
		}

		$uiComponent->appendContent(new HtmlElement('li', $this->inputAttrs,
				$formHtml->getSelect($propertyPath->fieldExt(null), $this->options)));

		$htmlElement = new HtmlElement('div', array('class' => 'n2n-impl-web-dispatch-array-mag'), $uiComponent);
		/*
		 	var optionArr = [].slice.call(document.getElementsByClassName("n2n-impl-web-dispatch-array-mag")).slice(-1)[0];

			function createEnumRemove(removeWord) {
				var enumRemove = document.createElement("span");
				enumRemove.innerHTML = " " + optionArr.getAttribute("data-remove-word");
				enumRemove.className = "n2n-impl-web-dispatch-remove-enum";
				enumRemove.style.cursor = "pointer";
				enumRemove.onclick = function () {
					this.parentElement.parentElement.removeChild(this.parentElement);
				}

				return enumRemove;
			}

			var lastLi = [].slice.call(optionArr.getElementsByTagName("li")).slice(-1)[0];

			for (var i = 0; i < optionArr.children.length; i++) {
				optionArr.children[i].append(createEnumRemove());

			}

			var addLiElem = document.createElement("li");
			addLiElem.innerHTML = optionArr.getAttribute("data-add-word");
			addLiElem.style.cursor = "pointer";
			addLiElem.className = "n2n-impl-web-dispatch-add-enum";
			addLiElem.onclick = function () {
				var oldSelect = lastLi.getElementsByTagName("select")[0];
				var select = document.createElement("select");
				select.innerHTML = oldSelect.innerHTML;
				select.setAttribute("name", oldSelect.getAttribute("name"));

				var enumField = document.createElement("li");
				enumField.append(select);
				enumField.appendChild(createEnumRemove());

				for (var i = 0; i < lastLi.attributes.length; i++) {
					var attr = lastLi.attributes.item(i);
					enumField.setAttribute(attr.nodeName, attr.nodeValue);
				}

				enumField.attributes.name = lastLi.firstChild.getAttribute("name").replace("[]", "[" + 2 + "]");

				optionArr.insertBefore(enumField, this);
			}

			optionArr.append(addLiElem);

			lastLi.parentNode.removeChild(lastLi);
		 */
		$htmlElement->appendLn(new HtmlElement('script', null, new Raw('function createEnumRemove(e){var t=document.createElement("span");return t.innerHTML=" "+optionArr.getAttribute("data-remove-word"),t.className="n2n-impl-web-dispatch-remove-enum",t.style.cursor="pointer",t.onclick=function(){this.parentElement.parentElement.removeChild(this.parentElement)},t}for(var optionArr=[].slice.call(document.getElementsByClassName("n2n-impl-web-dispatch-array-mag")).slice(-1)[0],lastLi=[].slice.call(optionArr.getElementsByTagName("li")).slice(-1)[0],i=0;i<optionArr.children.length;i++)optionArr.children[i].append(createEnumRemove());var addLiElem=document.createElement("li");addLiElem.innerHTML=optionArr.getAttribute("data-add-word"),addLiElem.style.cursor="pointer",addLiElem.className="n2n-impl-web-dispatch-add-enum",addLiElem.onclick=function(){var e=lastLi.getElementsByTagName("select")[0],t=document.createElement("select");t.innerHTML=e.innerHTML,t.setAttribute("name",e.getAttribute("name"));var n=document.createElement("li");n.append(t),n.appendChild(createEnumRemove());for(var r=0;r<lastLi.attributes.length;r++){var a=lastLi.attributes.item(r);n.setAttribute(a.nodeName,a.nodeValue)}n.attributes.name=lastLi.firstChild.getAttribute("name").replace("[]","[2]"),optionArr.insertBefore(n,this)},optionArr.append(addLiElem),lastLi.parentNode.removeChild(lastLi);')));
		return $htmlElement;
	}
}
