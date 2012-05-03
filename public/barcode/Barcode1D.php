<?php
include_once('Barcode.php');
include_once('Font.php');

abstract class BCGBarcode1D extends BCGBarcode {
	const SIZE_SPACING_FONT = 5;

	const AUTO_LABEL = '##!!AUTO_LABEL!!##';

	protected $thickness;
	protected $keys, $code;
	protected $positionX;
	protected $textfont;
	protected $text, $label;
	protected $checksumValue;
	protected $displayChecksum;

	protected function __construct() {
		parent::__construct();

		$this->setThickness(30);
		$this->text = '';
		$this->checksumValue = false;
		$this->setLabel(self::AUTO_LABEL);
		$this->setFont(5);
	}

	public function setThickness($thickness) {
		$this->thickness = $thickness;
	}

	public function getThickness() {
		return $this->thickness;
	}

	public function parse($text) {
		$this->text = $text;
		$this->checksumValue = false;  // Reset checksumValue
	}

	public function setLabel($label) {
		$this->label = $label;
	}

	public function getLabel() {
		$label = $this->label;
		if ($this->label === self::AUTO_LABEL) {
			$label = $this->text;
			if ($this->displayChecksum === true && ($checksum = $this->processChecksum()) !== false) {
				$label .= $checksum;
			}
		}

		return $label;
	}





	public function setFont($font) {
		if ($font instanceof BCGFont) {
			$this->textfont = clone $font;
			$this->textfont->setText($this->text);
		} else {
			$this->textfont = min(5, max(0, intval($font)));
		}
	}

	public function getMaxSize() {
		$p = parent::getMaxSize();

		$label = $this->getLabel();
		$textHeight = 0;
		if (!empty($label)) {
			if ($this->textfont instanceof BCGFont) {
				$textfont = clone $this->textfont;
				$textfont->setText($label);
				$textHeight = $textfont->getHeight() + self::SIZE_SPACING_FONT;
			} elseif ($this->textfont !== 0) {
				$textHeight = imagefontheight($this->textfont) + self::SIZE_SPACING_FONT;
			}
		}

		return array($p[0], $p[1] + $this->thickness * $this->scale + $textHeight);
	}






	public function getChecksum() {
		return $this->processChecksum();
	}






	public function setDisplayChecksum($display) {
		$this->displayChecksum = (bool) $display;
	}






	protected function findIndex($var) {
		return array_search($var, $this->keys);
	}






	protected function findCode($var) {
		return $this->code[$this->findIndex($var)];
	}








	protected function drawChar($im, $code, $startBar = true) {
		$colors = array(self::COLOR_FG, self::COLOR_BG);
		$currentColor = $startBar ? 0 : 1;
		$c = strlen($code);
		for ($i = 0; $i < $c; $i++) {
			for ($j = 0; $j < intval($code[$i]) + 1; $j++) {
				$this->drawSingleBar($im, $colors[$currentColor]);
				$this->nextX();
			}
			$currentColor = ($currentColor + 1) % 2;
		}
	}






	protected function drawSingleBar($im, $color) {
		$this->drawFilledRectangle($im, $this->positionX, 0, $this->positionX, $this->thickness - 1, $color);
	}



	protected function nextX() {
		$this->positionX++;
	}





	protected function drawText($im) {
		$label = $this->getLabel();

		if (!empty($label)) {
			$pA = $this->getMaxSize();
			$pB = BCGBarcode1D::getMaxSize();
			$w = $pA[0] - $pB[0];
			if ($this->textfont instanceof BCGFont) {
				$textfont = clone $this->textfont;
				$textfont->setText($label);
				$xPosition = ($w / 2) - ($textfont->getWidth() / 2) + $this->offsetX * $this->scale;
				$yPosition = $this->thickness * $this->scale + $textfont->getHeight() - $textfont->getUnderBaseline() + self::SIZE_SPACING_FONT + $this->offsetY * $this->scale;
				$textfont->draw($im, $this->colorFg->allocate($im), $xPosition, $yPosition);
			} elseif ($this->textfont !== 0) {
				$xPosition = ($w / 2) - (strlen($label) / 2) * imagefontwidth($this->textfont) + $this->offsetX * $this->scale;
				$yPosition = $this->thickness * $this->scale + self::SIZE_SPACING_FONT + $this->offsetY * $this->scale;
				imagestring($im, $this->textfont, $xPosition, $yPosition, $label, $this->colorFg->allocate($im));
			}
		}
	}




	protected function calculateChecksum() {
		$this->checksumValue = false;
	}






	protected function processChecksum() {
		return false;
	}

}