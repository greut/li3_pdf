<?php

namespace li3_pdf\tests\cases\extensions;

use lithium\template\View;
use li3_pdf\extensions\Writer;
use li3_pdf\extensions\Pdf;

/**
 * Sample PDF writer
 */
class HelloPdf extends \li3_pdf\extensions\Writer
{
	protected $_adapter = 'test';
}

class WriterTest extends \lithium\test\Unit
{
	function setup()
	{
		$this->_config = Pdf::config();
		Pdf::config(array('test' => array(
            'adapter' => 'Wkhtmltopdf',
        )));

		$this->hello = new HelloPDf(array(
			'config' => 'test'
		));
		$view = $this->hello->_view();
		$this->params = array();
		$p =& $this->params;

		$view->applyFilter('_step', function($self, $params, $chain) use (&$p) {
			$p = $params;
			return 'Hello World!';
		});
	}

	function teardown()
	{
		Pdf::config($this->_config);
	}

	function test_view()
	{
		$hello = new HelloPdf();
		$this->assertEqual('lithium\\template\\View', get_class($hello->_view()));
	}

	function test_create_a_pdf()
	{
		$output = $this->hello->render(array('title' => 'Test'));
        $this->assertEqual('%PDF-1.4', substr($output, 0, 8));
	}

	function test_create_a_pdf_with_options()
	{
		$output = $this->hello->render(array(
			'data' => array('title' => 'Test'),
			'layout' => 'layout',
		));
        $this->assertEqual('%PDF-1.4', substr($output, 0, 8));
		$this->assertEqual('layout', $this->params['options']['layout']);
	}

	function test_create_html()
	{
		$output = $this->hello->render(array('data' => array('title' => 'Test'), 'pdf' => false));
        $this->assertEqual('Hello World!', $output);
	}

}