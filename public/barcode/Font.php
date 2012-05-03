<?php
class BCGFont {

	private $path;
	private $text;
	private $size;
	private $box;

	public function __construct($fontPath, $size) {
		$this->path = $fontPath;
		$this->size = $size;
	}

	public function setText($text) {
		$this->text = $text;
		$im = imagecreate(1, 1);
		$this->box = imagettftext($im, $this->size, 0, 0, 0, imagecolorallocate($im, 0, 0, 0), $this->path, $this->text);
	}

	public function getWidth() {
		if ($this->box !== NULL) {




			return abs(max($this->box[2], $this->box[4]));
		} else {
			return 0;
		}
	}

	public function getHeight() {
		if ($this->box !== NULL) {
			return (float) abs(max($this->box[5], $this->box[7]) - min($this->box[1], $this->box[3]));
		} else {
			return 0.0;
		}
	}

	public function getUnderBaseline() {

		return (float) max($this->box[1], $this->box[3]);
	}

	public function draw(&$im, $color, $x, $y) {
		imagettftext($im, $this->size, 0, $x, $y, $color, $this->path, $this->text);
	}

}

?>