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

	use n2n\web\dispatch\map\PropertyPath;
	use n2n\impl\web\ui\view\html\HtmlView;
	use n2n\impl\web\ui\view\html\HtmlElement;
	use n2n\web\dispatch\mag\UiOutfitter;
	/**
	 * @var \n2n\web\ui\view\View $view
	 */
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	$formHtml = HtmlView::formHtml($view);
	
	$propertyPath = $view->getParam('propertyPath');
	$view->assert($propertyPath instanceof PropertyPath);
	
	$uiOutfitter = $view->getParam('uiOutfitter');
	$view->assert($uiOutfitter instanceof UiOutfitter);
	
	$numExisting = $view->getParam('numExisting');
	$num = $view->getParam('num');
	
	$itemAttrsHtml = HtmlElement::buildAttrsHtml($uiOutfitter->buildAttrs(UiOutfitter::NATURE_MASSIVE_ARRAY_ITEM));
?>
<div<?php $view->out(HtmlElement::buildAttrsHtml($uiOutfitter->buildAttrs(UiOutfitter::NATURE_MASSIVE_ARRAY))) ?>>
	<?php $formHtml->meta()->arrayProps($propertyPath, function() use ($formHtml, $view, $uiOutfitter, $html, $itemAttrsHtml) { ?>
		<div<?php $view->out($itemAttrsHtml) ?>>
			<?php $formHtml->optionalObjectEnabledHidden() ?>
			<?php $html->out($uiOutfitter->createMagDispatchableView(null, $view)) ?>
			<?php /*$view->import('magForm.html', array(
				'magForm' => $formHtml->meta()->getMapValue()->getObject(),
				'propertyPath' => $formHtml->meta()->createPropertyPath())) */ ?>
		</div>
	<?php }, $num) ?>
</div>
<!--
<script>
	(function () {
		function Reformer(container, dataJson) {
			this.container = container;
			this.elems =  [].slice.call(this.container.children);
			this.dataJson = dataJson;
			this.hiddenElems = [];
			this.addBtn = this.createAddBtn();
			this.init();
		}

		Reformer.prototype.init = function() {
			this.setupBtns();
			for (var i = this.dataJson.numExisting; i < this.elems.length; i++) {
				this.elems[i].remove();
				this.hiddenElems.push(this.elems[i]);
			}
		}

		Reformer.prototype.setupBtns = function() {
			for (var i = 0; i < this.elems.length; i++) {
				var elem = this.elems[i];
				elem.appendChild(this.createRemoveBtn(elem));
			}

			this.container.parentElement.appendChild(this.addBtn);
		}

		Reformer.prototype.createAddBtn = function() {
			var elem = document.createElement("button");
			elem.innerHTML = "add";
			elem.style.cursor = "pointer";

			for (i in this.dataJson.btnAddAttrs) {
				elem.setAttribute(i, this.dataJson.btnAddAttrs[i]);
			}

			var that = this;
			elem.onclick = function(e) {
				that.container.appendChild(that.hiddenElems.pop());
				if (that.hiddenElems.length === 0) {
					this.style.display = "none";
				}

				e.stopPropagation();
				return false;
			};

			return elem;
		}

		Reformer.prototype.createRemoveBtn = function(arrayElem) {
			var elem = document.createElement("button");
			elem.innerHTML = "remove";
			elem.style.cursor = "pointer";

			for (i in this.dataJson.btnRemoveAttrs) {
				elem.setAttribute(i, this.dataJson.btnRemoveAttrs[i]);
			}

			var that = this;
			elem.onclick = function(e) {
				arrayElem.remove();
				that.hiddenElems.push(arrayElem);
				that.addBtn.style.display = "";

				e.stopPropagation();
				return false;
			};

			return elem;
		}

		var lastScript = [].slice.call(document.getElementsByTagName("script")).slice(-1)[0];
		var container = lastScript.parentElement.getElementsByTagName("div")[0];
		var reformer = new Reformer(container, <?php $view->out(json_encode(array('numExisting' => $numExisting,
			'btnAddAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_PRIMARY),
			'btnRemoveAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_SECONDARY)))) ?>);
	})();
</script>
-->
<script type="text/javascript"><?php $view->out('!function(){function t(t,e){this.container=t,this.elems=[].slice.call(this.container.children),this.dataJson=e,this.hiddenElems=[],this.addBtn=this.createAddBtn(),this.init()}t.prototype.init=function(){this.setupBtns();for(var t=this.dataJson.numExisting;t<this.elems.length;t++)this.elems[t].remove(),this.hiddenElems.push(this.elems[t])},t.prototype.setupBtns=function(){for(var t=0;t<this.elems.length;t++){var e=this.elems[t];e.appendChild(this.createRemoveBtn(e))}this.container.parentElement.appendChild(this.addBtn)},t.prototype.createAddBtn=function(){var t=document.createElement("button");t.innerHTML="add",t.style.cursor="pointer";for(i in this.dataJson.btnAddAttrs)t.setAttribute(i,this.dataJson.btnAddAttrs[i]);var e=this;return t.onclick=function(t){return e.container.appendChild(e.hiddenElems.pop()),0===e.hiddenElems.length&&(this.style.display="none"),t.stopPropagation(),!1},t},t.prototype.createRemoveBtn=function(t){var e=document.createElement("button");e.innerHTML="remove",e.style.cursor="pointer";for(i in this.dataJson.btnRemoveAttrs)e.setAttribute(i,this.dataJson.btnRemoveAttrs[i]);var n=this;return e.onclick=function(e){return t.remove(),n.hiddenElems.push(t),n.addBtn.style.display="",e.stopPropagation(),!1},e};new t([].slice.call(document.getElementsByTagName("script")).slice(-1)[0].parentElement.getElementsByTagName("div")[0], '
		. json_encode(array(
				'numExisting' => $numExisting,
				'btnAddAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_PRIMARY),
				'btnRemoveAttrs' => $uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_SECONDARY)))
		. ')}();') ?></script>