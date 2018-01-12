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
	use \n2n\web\dispatch\mag\UiOutfitter;
	use n2n\impl\web\ui\view\html\HtmlView;
	use \n2n\util\StringUtils;
	/**
	 * @var \n2n\web\ui\view\View $view
	 */
	$view = HtmlView::view($view);
	$html = HtmlView::html($view);
	$formHtml = HtmlView::formHtml($view);

	$propertyPath = $view->getParam('propertyPath');
	$view->assert($propertyPath instanceof PropertyPath);

	$uiOutfitter = $view->getParam('uiOutfitter');
	$view->assert($uiOutfitter instanceof \n2n\web\dispatch\mag\UiOutfitter);
	$numExisting = $view->getParam('numExisting');
	$num = $view->getParam('num');
	$itemAttrsHtml = array('n2n-impl-web-dispatch-mag-collection-item');

	$html->meta()->addJs('js/mag-collection.js', 'n2n\impl\web\dispatch', false, false, null,
			\n2n\impl\web\ui\view\html\HtmlBuilderMeta::TARGET_BODY_END);
?>
<div>
	<div class="n2n-impl-web-dispatch-mag-collection"
			data-mag-collection-item-existing="<?php $html->out($numExisting) ?>"
			data-mag-collection-add-attrs="<?php $html->out(StringUtils::jsonEncode($uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_SECONDARY))) ?>"
			data-mag-collection-remove-attrs="<?php $html->out(StringUtils::jsonEncode($uiOutfitter->buildAttrs(UiOutfitter::NATURE_BTN_SECONDARY))) ?>">

		<?php $formHtml->meta()->arrayProps($propertyPath, function() use ($formHtml, $view, $uiOutfitter, $html, $itemAttrsHtml) { ?>
			<?php $html->out($uiOutfitter->buildElement(
					UiOutfitter::NATURE_MASSIVE_ARRAY_ITEM + UiOutfitter::NATURE_MASSIVE_ARRAY_ITEM_CONTROL, null,
					$uiOutfitter->createMagDispatchableView(null, $view))) ?>
		<?php }, $num) ?>
	</div>
</div>