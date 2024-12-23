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

use n2n\reflection\property\AccessProxy;
use n2n\web\dispatch\map\bind\BindingDefinition;
use n2n\web\dispatch\property\ManagedProperty;
use n2n\impl\web\dispatch\property\ScalarProperty;

abstract class ScalarMagAdapter extends MagAdapter {

	/**
	 * ScalarMagAdapter constructor.
	 * @param $labelLstr
	 * @param null $value
	 * @param array|null $containerAttrs
	 */
	public function __construct($labelLstr, $value = null, ?array $containerAttrs = null) {
		parent::__construct($labelLstr, $value, $containerAttrs);
	}

	/**
	 * @param AccessProxy $accessProxy
	 * @return ManagedProperty
	 */
	public function createManagedProperty(AccessProxy $accessProxy): ManagedProperty {
		return new ScalarProperty($accessProxy, false);		
	}
	
	/* (non-PHPdoc)
	 * @see \n2n\web\dispatch\mag\Mag::setupBindingDefinition()
	 */
	public function setupBindingDefinition(BindingDefinition $bd) {
	}
}
