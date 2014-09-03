<?php
class Tx_HelfenKannJeder_View_Matrix_Column extends Tx_Extbase_MVC_View_AbstractView {
	public function render() {
		if (!isset($this->variables["width"])) $this->variables["width"] = 1;
		if (!isset($this->variables["height"])) $this->variables["height"] = 1;
		if (!isset($this->variables["font"])) $this->variables["font"] = "fileadmin/arial.ttf";
		if(isset($this->variables["activityfield"])) {
			$name = $this->variables["activityfield"]->getName();
		}

		$columImage = imagecreatetruecolor(20, 250);
		imagesavealpha($columImage, true);

		$trans_colour = imagecolorallocatealpha($columImage, 0, 0, 0, 127);
		imagefill($columImage, 0, 0, $trans_colour);
   
		$black = imagecolorallocate($columImage, 0, 0, 0);

		imagettftext($columImage, 10, 90, 17, 240, $black, $this->variables["font"], $name);  

		ob_start(); 
		imagepng($columImage);
		return ob_get_clean();
	}
}
?>
