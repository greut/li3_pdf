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
	/**
	 * To be re-defined in sub-classes.
	 *
	 * @var object `Collection` of configurations, indexed by name.
	 */
	protected static $_configurations = array();

	protected static $_adapters = 'adapter.pdf';
}