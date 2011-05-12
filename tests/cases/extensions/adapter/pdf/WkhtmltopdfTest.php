<?php

namespace li3_pdf\tests\cases\extensions\adapter\pdf;

use li3_pdf\extensions\adapter\pdf\Wkhtmltopdf;

class WkhtmltopdfTest extends \lithium\test\Unit
{
	function test_command()
	{
		$wk = new Wkhtmltopdf(array(
			'command' => 'D:\wkhtmltopdf.exe'
		));

		$this->assertEqual('D:\wkhtmltopdf.exe "foo.txt"', $wk->command('foo.txt'));
	}

	function test_margins()
	{
		$wk = new Wkhtmltopdf(array(
			'margin_top'    => 1,
			'margin_right'  => 2,
			'margin_bottom' => 3,
			'margin_left'   => 4,
		));

		$expected = 'wkhtmltopdf -T 1 -R 2 -B 3 -L 4 "foo.txt"';
		$this->assertEqual($expected, $wk->command('foo.txt'));
	}

	function test_page_size()
	{
		$wk = new Wkhtmltopdf(array(
			'page_size' => 'A4',
		));

		$expected = 'wkhtmltopdf --page-size A4 "foo.txt"';
		$this->assertEqual($expected, $wk->command('foo.txt'));
	}

	function test_orientation()
	{
		$wk = new Wkhtmltopdf(array(
			'orientation' => 'Landscape',
		));

		$expected = 'wkhtmltopdf --orientation Landscape "foo.txt"';
		$this->assertEqual($expected, $wk->command('foo.txt'));
	}

	function test_generate()
	{
		$wk = new Wkhtmltopdf();
        $html = <<<EOS
<html>
    <title>Hello!</title>
    <h1>Hello!</h1>
</html>
EOS;
        $output = $wk->generate($html);
        $this->assertEqual('%PDF-1.4', substr($output, 0, 8));
	}

	function test_generate_exception()
	{
		$wk = new Wkhtmltopdf(array(
			'orientation' => 'upsidedown'
		));
		$this->expectException();
        $output = $wk->generate('');
	}
}