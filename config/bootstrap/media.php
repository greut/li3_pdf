<?php

use lithium\net\http\Media;

use li3_pdf\extensions\Pdf;

Media::type('pdf', 'application/pdf', array(
	'view' => 'lithium\\template\\View',
	'encode' => function($data, $handler, &$response) {
		$htmlhandler = array(
			'encode' => false
		) + $handler;
		$view = Media::view($htmlhandler, $handler['data'], $response);
		$html = $view->render('all', $handler['data'], $handler);

		$pdf = Pdf::adapter('default');
		return $pdf->generate($html);
	}
));