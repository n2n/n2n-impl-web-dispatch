<?php
namespace n2n\impl\web\dispatch;

use n2n\util\type\ArgUtils;
use n2n\web\dispatch\Dispatchable;
use n2n\web\dispatch\DynamicDispatchable;
use n2n\web\dispatch\model\DispatchModel;
use n2n\impl\web\dispatch\property\ObjectProperty;
use n2n\web\dispatch\property\DynamicAccessProxy;
use n2n\web\dispatch\map\bind\MappingDefinition;
use n2n\web\dispatch\map\bind\BindingDefinition;

class DispatchableCollection implements DynamicDispatchable {
	/**
	 * @var Dispatchable[]
	 */
	private $dispatchables = [];
	/**
	 * @var string[]
	 */
	private $ignoredPropertyNames = [];
	
	/**
	 * @param Dispatchable[] $dispatchables
	 */
	public function __construct(array $dispatchables) {
		$this->setDispatchables($dispatchables);
	}
	
	/**
	 * @return Dispatchable[]
	 */
	public function getDispatchables() {
		return $this->dispatchables;
	}
	
	/**
	 * @param Dispatchable[] $dispatchables
	 */
	public function setDispatchables(array $dispatchables) {
		ArgUtils::valArray($dispatchables, Dispatchable::class);
		$this->dispatchables = $dispatchables;
	}
	
	/**
	 * @param string $key
	 * @param Dispatchable $dispatchable
	 */
	public function putDispatchable(string $key, Dispatchable $dispatchable) {
		$this->dispatchables[$key] = $dispatchable;
	}
	
	/**
	 * @param string $key
	 * @return Dispatchable|null
	 */
	public function getDispatchableByKey(string $key) {
		return $this->dispatchables[$key];
	}
	
	/**
	 * @param string $key
	 */
	public function removeDispatchableByKey(string $key) {
		unset($this->dispatchables[$key]);
	}
	
	/**
	 * @return string[]
	 */
	public function getKeys() {
		return array_keys($this->dispatchables);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \n2n\web\dispatch\DynamicDispatchable::setup()
	 */
	public function setup(DispatchModel $dispatchModel) {
		foreach ($this->dispatchables as $key => $dispatchable) {
			$dispatchModel->addProperty(new ObjectProperty(new DynamicAccessProxy($key), false));
		}
	}
	
	/**
	 * {@inheritDoc}
	 * @see \n2n\web\dispatch\DynamicDispatchable::getPropertyValue()
	 */
	public function getPropertyValue(string $name) {
		if (isset($this->dispatchables[$name])) {
			return $this->dispatchables[$name];
		}
		
		return null;
	}
	
	/**
	 * {@inheritDoc}
	 * @see \n2n\web\dispatch\DynamicDispatchable::setPropertyValue()
	 */
	public function setPropertyValue(string $name, $value) {
		$this->dispatchables[$name] = $value;
	}
	
	/**
	 * @param string[] $ignoredPropertyNames
	 */
	public function setIgnoredPropertyNames(array $ignoredPropertyNames) {
		ArgUtils::valArray($ignoredPropertyNames, 'string');
		$this->ignoredPropertyNames = $ignoredPropertyNames;
	}
	
	/**
	 * @param string $propertyName
	 */
	public function addIgnoredPropertyName(string $propertyName) {
		$this->ignoredPropertyNames[] = $propertyName;
	}
	
	/**
	 * @param string $propertyName
	 */
	public function removeIgnoredPropertyname(string $propertyName) {
		while (false !== ($key = array_search($propertyName, $this->ignoredPropertyNames))) {
			unset($this->ignoredPropertyNames[$key]);
		}
	}
	
	/**
	 * @return string[]
	 */
	public function getIgnoredPropertyNames() {
		return $this->ignoredPropertyNames;
	}
	
	private function _mapping(MappingDefinition $md) {
		foreach ($this->ignoredPropertyNames as $propertyName) {
			$md->ignore($propertyName);
		}
	}
	
	private function _validation(BindingDefinition $bd) { }
}
