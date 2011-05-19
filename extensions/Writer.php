<?php

namespace li3_pdf\extensions;

/**
 * This object is intended to produce PDF without being into a Controller
 * but is still in a work in progress state.
 */
abstract class Writer extends \lithium\core\Object
{
	protected $_config = 'default';

	protected $_view;

	protected $_classes = array(
		'view' => 'lithium\\template\\View',
		'message' => 'lithium\\g11n\\Message',
	);

	protected $_autoConfig = array('classes' => 'merge', 'config');

	/**
	 * Request data
	 */
	public $data = null;

	function render(array $options=array()) {
		$class = get_class($this);
		$name = preg_replace('/Pdf$/', '', substr($class, strrpos($class, '\\') + 1));
		$name = strtolower($name);

		if (isset($options['data'])) {
			$this->data = $options['data'];
			unset($options['data']);
		} else {
			$this->data = $options;
			$options = array();
		}

		$data = $this->data;

		$options += array(
			'controller' => $name,
			'template' => 'index',
			'layout' => 'default',
			'type' => 'pdf',
		);

		return $this->_render($data, $options);
	}

	function &_view() {
		if (!isset($this->_view)) {
			$message = $this->_classes['message'];

			$this->_view = $this->_instance('view', array(
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
					'layout' => '{:library}/views/layouts/{:layout}.{:type}.php',
				),
				'outputFilters' => $message::aliases(),
			));
		}
		return $this->_view;
	}

	protected function _render(array $data, array $options=array()) {
		$pdf = Pdf::adapter($this->_config);
		$view = $this->_view();
		$html = $view->render('all', $data, $options);
		return $pdf->generate($html);
	}
}