<?php
namespace Querformatik\HelfenKannJeder\Service;

require_once("typo3conf/ext/helfen_kann_jeder/Classes/External/DaisyDiff/HTMLDiff.php");
//Classes/External/DaisyDiff/Diff.php  Classes/External/DaisyDiff/HTMLDiff.php  Classes/External/DaisyDiff/Nodes.php  Classes/External/DaisyDiff/Sanitizer.php  Classes/External/DaisyDiff/Xml.php


class HtmlDiffService implements \TYPO3\CMS\Core\SingletonInterface {

	public function diff($old, $new) {
		$htmlDiff = new \HtmlDiffer();
		return $htmlDiff->htmlDiff($old, $new);
	}
}
?>
