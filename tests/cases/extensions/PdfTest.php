<?php

namespace li3_pdf\tests\cases\extensions;

use li3_pdf\extensions\Pdf;

class PdfTest extends \lithium\test\Unit
{
    function test_config()
    {
        Pdf::config(array('test' => array(
            'adapter' => 'Wkhtmltopdf',
        )));

        $pdf = Pdf::adapter('test');
        $this->assert($pdf);
    }

    function test_wkhtmltopdf()
    {
        Pdf::config(array('test' => array(
            'adapter' => 'Wkhtmltopdf'
        )));

        $pdf = Pdf::adapter('test');
		$this->assertEqual('li3_pdf\\extensions\\adapter\\pdf\\Wkhtmltopdf', get_class($pdf));
    }

	/* This test breaks the Coverage since dompdf cannot be instanced twice because
	   it's full of constants.
    function test_dompdf()
    {
        Pdf::config(array('test' => array(
            'adapter' => 'Dompdf'
        )));

        $pdf = Pdf::adapter('test');
		$this->assertEqual('li3_pdf\\extensions\\adapter\\pdf\\Dompdf', get_class($pdf));
    }
	*/
}