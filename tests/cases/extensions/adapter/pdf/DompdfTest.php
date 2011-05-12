<?php

namespace li3_pdf\tests\cases\extensions\adapter\pdf;

use li3_pdf\extensions\adapter\pdf\Dompdf;

class DompdfTest extends \lithium\test\Unit
{
	function test_generate()
	{
		$dp = new Dompdf();
        $html = <<<EOS
<!DOCTYPE html>
<html>
<head>
    <title>Hello!</title>
</head>
<body>
    <h1>Hello!</h1>
</body>
</html>
EOS;
        $output = $dp->generate($html);
        $this->assertEqual('%PDF-1.3', substr($output, 0, 8));
	}
}