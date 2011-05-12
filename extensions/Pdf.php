<?php

namespace li3_pdf\extensions;

/**
 * PDF configuration object
 *
 * {{{
 * use li3_pdf\extensions\Pdf;
 * // the default values
 * Pdf::config(array('default' => array(
 *     'adapter'     => 'Wkhtmltopdf'
 * ));
 * }}}
 *
 * Usage:
 *
 * {{{
 * $pdf = Pdf::get('default');
 *
 * header('Content-Type: application/pdf');
 * echo $pdf->generate($html);
 * }}}
 */
class Pdf extends \lithium\core\Adaptable
{
	protected static $_adapters = 'adapter.pdf';
}