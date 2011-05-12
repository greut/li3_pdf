<?php

namespace li3_pdf\tests\cases\extensions;

use lithium\template\View;
use li3_pdf\extensions\Writer;
use li3_pdf\extensions\Pdf;

/**
 * Sample …
 */
class HelloPdf extends \li3_pdf\extensions\Writer
{
	protected function _render(array $data, array $options=array()) {
		$pdf = Pdf::adapter($this->_config);
		$view = $this->_view();
		$html = $view->render(
			array('element' => '<html><body>Hello {:title}!</body></html>'),
			$data
		);
		return $pdf->generate($html);
	}

	protected function _view() {
		return new View(array('loader' => 'Simple', 'renderer' => 'Simple'));
	}
}

class WriterTest extends \lithium\test\Unit
{
	function setup()
	{
		$this->_config = Pdf::config();
		Pdf::config(array('test' => array(
            'adapter' => 'Wkhtmltopdf',
        )));
	}

	function teardown()
	{
		Pdf::config($this->_config);
	}

	function test_create_a_pdf()
	{
		$hello = new HelloPdf(array(
			'config' => 'test'
		));

		$output = $hello->render(array('title' => 'Test'));
        $this->assertEqual('%PDF-1.4', substr($output, 0, 8));
	}
}
