<?php
include_once('Barcode.php');

class BCGDrawing {
	const IMG_FORMAT_PNG = 1;
	const IMG_FORMAT_JPEG = 2;

	private $w, $h;  // int
	private $color;  // BCGColor
	private $filename; // char *
	private $im;  // {object}
	private $barcode; // BCGBarcode

	public function __construct($filename, BCGColor $color) {
		$this->im = null;
		$this->filename = $filename;
		$this->color = $color;
	}

	public function __destruct() {
		$this->destroy();
	}

	private function init() {
		if ($this->im === null) {
			$this->im = imagecreatetruecolor($this->w, $this->h)
				or die('Can\'t Initialize the GD Libraty');
			imagefilledrectangle($this->im, 0, 0, $this->w - 1, $this->h - 1, $this->color->allocate($this->im));
		}
	}

	public function get_im() {
		return $this->im;
	}

	public function set_im(&$im) {
		$this->im = $im;
	}

	public function setBarcode(BCGBarcode $barcode) {
		$this->barcode = $barcode;
	}

	public function draw() {
		$size = $this->barcode->getMaxSize();
		$this->w = $size[0];
		$this->h = $size[1];
		$this->init();
		$this->barcode->draw($this->im);
	}

	public function finish($image_style = self::IMG_FORMAT_PNG, $quality = 100) {
		if ($image_style === self::IMG_FORMAT_PNG) {
			if (empty($this->filename)) {
				imagepng($this->im);
			} else {
				imagepng($this->im, $this->filename);
			}
		} elseif ($image_style === self::IMG_FORMAT_JPEG) {
			imagejpeg($this->im, $this->filename, $quality);
		}
	}

	public function destroy() {
		@imagedestroy($this->im);
	}

}

;
?>