<?php
require_once("typo3conf/ext/helfen_kann_jeder/Classes/External/DaisyDiff/HTMLDiff.php");
//Classes/External/DaisyDiff/Diff.php  Classes/External/DaisyDiff/HTMLDiff.php  Classes/External/DaisyDiff/Nodes.php  Classes/External/DaisyDiff/Sanitizer.php  Classes/External/DaisyDiff/Xml.php


class Tx_HelfenKannJeder_Service_HtmlDiffService implements t3lib_Singleton {

	public function diff($old, $new) {
		$htmlDiff = new HtmlDiffer();
		return $htmlDiff->htmlDiff($old, $new);
	}
}
?>
