<?php

namespace li3_pdf\extensions\adapter\pdf;

class Wkhtmltopdf extends \lithium\core\Object
{
	/**
	 * Which command to call
	 *
	 * @var string
	 */
	protected $_command = 'wkhtmltopdf';
	/**
	 * Page orientation
	 *
	 * @var string
	 */
	protected $_orientation;
	/**
	 * Page size
	 *
	 * @var array
	 */
	protected $_page_size;
	/**
	 * margin-top
	 *
	 * @var integer
	 */
	protected $_margin_top;

	/**
	 * margin-right
	 *
	 * @var integer
	 */
	protected $_margin_right;
	/**
	 * margin-Bottom
	 *
	 * @var integer
	 */
	protected $_margin_bottom;
	/**
	 * margin-left
	 *
	 * @var integer
	 */
	protected $_margin_left;

	protected $_autoConfig = array(
		'orientation',
		'page_size',
		'margin_top',
	    'margin_right',
		'margin_bottom',
		'margin_left',
		'command',
	);

	function generate($html, $input='') {
		$filename = LITHIUM_APP_PATH . '/resources/tmp/wk'.time().'.html';
		file_put_contents($filename, $html);

		$io = array(
			array('pipe', 'r'), // stdin
			array('pipe', 'w'), // stdout
			array('pipe', 'w'), // stderr
		);
		$proc = proc_open($this->command($filename).' -', $io, $pipes);

		fwrite($pipes[0], $input);
		fclose($pipes[0]);

		$result = array(
			'stdout' => stream_get_contents($pipes[1]),
			'stderr' => stream_get_contents($pipes[2]),
		);
		fclose($pipes[1]);
		fclose($pipes[2]);

		$result['return'] = proc_close($proc);
		unlink($filename);

		if ($result['return'] == 0) {
			return $result['stdout'];
		} else {
			throw new \Exception($result['stderr']);
		}
	}

	function command($filename) {
		$opts = array(
			'orientation'  => '--orientation',
			'page_size'     => '--page-size',
			'margin_top'    => '-T',
			'margin_right'  => '-R',
			'margin_bottom' => '-B',
			'margin_left'   => '-L',
		);
		$cmd = $this->_command;

		foreach ($opts as $config => $opt) {
			if (!is_null($this->{"_$config"})) {
				$cmd .= ' '.$opt.' '.$this->{"_$config"};
			}
		}

		if ($filename) {
			$cmd .= ' "'.addslashes($filename).'"';
		}

		return $cmd;
	}
}