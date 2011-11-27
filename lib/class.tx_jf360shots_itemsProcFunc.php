<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Juergen Furrer <juergen.furrer@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once (PATH_t3lib . 'class.t3lib_page.php');

/**
 * 'itemsProcFunc' for the 'jf360shots' extension.
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jf360shots
 */
class tx_jf360shots_itemsProcFunc
{
	/**
	 * Get the defined views by pagesetup
	 * @param array $config
	 * @param array $item
	 */
	public function getView($config, $item)
	{
		$allViews = array(
			array(
				$GLOBALS['LANG']->sL('LLL:EXT:jf360shots/locallang_db.xml:tt_content.pi_flexform.view.I.0'),
				'folder',
			),
			array(
				$GLOBALS['LANG']->sL('LLL:EXT:jf360shots/locallang_db.xml:tt_content.pi_flexform.view.I.2'),
				'single',
			),
			array(
				$GLOBALS['LANG']->sL('LLL:EXT:jf360shots/locallang_db.xml:tt_content.pi_flexform.view.I.1'),
				'panorama',
			),
		);
		$confArr = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['jf360shots']);
		$views = t3lib_div::trimExplode(',', $confArr['views']);
		if (count($views) > 0) {
			foreach ($views as $key => $val) {
				if ($val) {
					$availableViews[] = $val;
				}
			}
		}
		if (count($availableViews) < 1) {
			$availableViews = array('folder', 'single', 'panorama');
		}
		$allowedViews = array();
		foreach ($allViews as $key => $view) {
			if (in_array(trim($view[1]), $availableViews)) {
				$allowedViews[] = $view;
			}
		}
		$pageTS = t3lib_BEfunc::getPagesTSconfig($config['row']['pid']);
		$jf360shotsViews = t3lib_div::trimExplode(",", $pageTS['mod.']['jf360shots.']['views'], TRUE);
		$optionList = array();
		if (count($jf360shotsViews) > 0) {
			foreach ($allowedViews as $key => $view) {
				if (in_array(trim($view[1]), $jf360shotsViews)) {
					$optionList[] = $view;
				}
			}
		} else {
			$optionList = $allowedViews;
		}
		$config['items'] = array_merge($config['items'], $optionList);
		return $config;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf360shots/lib/class.tx_jf360shots_itemsProcFunc.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf360shots/lib/class.tx_jf360shots_itemsProcFunc.php']);
}
?>