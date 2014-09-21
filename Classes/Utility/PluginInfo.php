<?php
namespace Querformatik\HelfenKannJeder\Utility;

class PluginInfo {
	/**
	 * Main Function
	 *
	 * @param array $params
	 * @param $pObj
	 * @return string
	 */
	public function getInfo($params = array(), $pObj) {
		$flexform = t3lib_div::xml2array($params['row']['pi_flexform']);
		return str_replace(";", "\n", $flexform["data"]["sDEF"]["lDEF"]["switchableControllerActions"]["vDEF"]);
	}
}
?>
