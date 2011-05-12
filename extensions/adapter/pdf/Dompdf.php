<?php

namespace li3_pdf\extensions\adapter\pdf;

class Dompdf extends \lithium\core\Object
{
	protected $_backend = 'CPDF';
	protected $_pdflib;
	protected $_unicode = true;
	protected $_media = 'screen';
	protected $_paper = 'paper';
	protected $_orientation = 'portrait';
	protected $_dpi = 96;
	protected $_font = 'serif';
	protected $_font_height_ratio = 1.1;
	protected $_php = false;
	protected $_css_float = true;
	protected $_javascript = true;
	protected $_remote = false;
	protected $_warnings = false;
	protected $_debug = false;

	// Singleton (must be bad)
	protected static $_dompdf;

	protected $_autoConfig = array(
		'backend',
		'pdflib',
		'unicode',
		'media',
		'paper',
		'orientation',
		'dpi',
		'font',
		'font_height_ratio',
		'php',
		'css_float',
		'javascript',
		'remote',
		'warnings',
		'debug',
	);

	static function auto_load($class) {
		$filename = DOMPDF_INC_DIR.'/'.strtolower($class).'.cls.php';
		if (is_file($filename)) {
			require_once($filename);
		}
	}

	public function _init() {
		parent::_init();

		if (!isset(static::$_dompdf)) {
			// boiler plate
			define('DOMPDF_FONT_DIR', DOMPDF_LIB_DIR . '/fonts/', true);
			define('DOMPDF_FONT_CACHE', DOMPDF_FONT_DIR, true);
			define('DOMPDF_TEMP_DIR', sys_get_temp_dir(), true);
			define('DOMPDF_CHROOT', dirname(LITHIUM_APP_PATH), true);
			define('DOMPDF_UNICODE_ENABLED', $this->_unicode, true);

			define('DOMPDF_PDF_BACKEND', $this->_backend, true);
			if (isset($this->_pdflib)) {
				define('DOMPDF_PDFLIB_LICENSE', $this->_pdflib, true);
			}
			define('DOMPDF_DEFAULT_MEDIA_TYPE', $this->_media, true);
			define('DOMPDF_DEFAULT_PAPER_SIZE', $this->_paper, true);
			define('DOMPDF_DEFAULT_FONT', $this->_font, true);
			define('DOMPDF_FONT_HEIGHT_RATIO', $this->_font_height_ratio, true);
			define('DOMPDF_DPI', $this->_dpi, true);
			define('DOMPDF_ENABLE_PHP', $this->_php, true);
			define('DOMPDF_ENABLE_REMOTE', $this->_remote, true);
			define('DOMPDF_ENABLE_CSS_FLOAT', $this->_css_float, true);
			define('DOMPDF_ENABLE_JAVASCRIPT', $this->_javascript, true);

			spl_autoload_register(__NAMESPACE__.'\Dompdf::auto_load');

			global $_dompdf_warnings;
			$_dompdf_warnings = array();
			global $_dompdf_show_warnings;
			$_dompdf_show_warnings = $this->_warnings;
			global $_dompdf_debug;
			$_dompdf_debug = $this->_debug;
			global $_DOMPDF_DEBUG_TYPES;
			$_DOMPDF_DEBUG_TYPES = array();

			define('DEBUGPNG', $this->_debug, true);
			define('DEBUGKEEPTEMP', $this->_debug, true);
			define('DEBUGCSS', $this->_debug, true);
			define('DEBUG_LAYOUT', $this->_debug, true);
			define('DEBUG_LAYOUT_LINES', $this->_debug, true);
			define('DEBUG_LAYOUT_BLOCKS', $this->_debug, true);
			define('DEBUG_LAYOUT_INLINE', $this->_debug, true);
			define('DEBUG_LAYOUT_PADDINGBOX', $this->_debug, true);
			define('DOMPDF_LOG_OUTPUT_FILE', DOMPDF_FONT_DIR.'log.htm');

			$dompdf = new \DOMPDF();
			$dompdf->set_paper($this->_paper, $this->_orientation);

			static::$_dompdf = $dompdf;
		}
	}

	function generate($html) {
		$dompdf = static::$_dompdf;

		$dompdf->load_html($html);
		$dompdf->render();
		return $dompdf->output();
	}
}