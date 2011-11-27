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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('jf360shots').'lib/class.tx_jf360shots_pagerenderer.php');

/**
 * Plugin 'Multiple Content' for the 'jf360shots' extension.
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jf360shots
 */
class tx_jf360shots_pi1 extends tslib_pibase
{
	public $prefixId      = 'tx_jf360shots_pi1';
	public $scriptRelPath = 'pi1/class.tx_jf360shots_pi1.php';
	public $extKey        = 'jf360shots';
	public $pi_checkCHash = TRUE;
	private $lConf = array();
	private $contentKey = NULL;
	private $jsFiles = array();
	private $js = array();
	private $css = array();
	private $images = array();
	private $captions = array();
	private $piFlexForm = array();
	private $imageDir = 'uploads/tx_jf360shots/';
	private $type = 'normal';
	private $pagerenderer = NULL;

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	public function main($content, $conf)
	{
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		// define the key of the element
		$this->contentKey = "jf360shots";

		if ($this->cObj->data['list_type'] == $this->extKey.'_pi1') {
			$this->type = 'normal';

			// It's a content, all data from flexform
			
			$this->lConf['view'] = $this->getFlexformData('general', 'view');
			
			$this->lConf['imagepath']     = $this->getFlexformData('general', 'imagepath', ($this->lConf['view'] == 'folder'));
			$this->lConf['singleImage']   = $this->getFlexformData('general', 'singleImage', ($this->lConf['view'] == 'single'));
			$this->lConf['singleFrames']  = $this->getFlexformData('general', 'singleFrames', ($this->lConf['view'] == 'single'));
			$this->lConf['singleColumns'] = $this->getFlexformData('general', 'singleColumns', ($this->lConf['view'] == 'single'));
			$this->lConf['panoramaImage'] = $this->getFlexformData('general', 'panoramaImage', ($this->lConf['view'] == 'panorama'));
			$this->lConf['imagewidth']    = $this->getFlexformData('general', 'imagewidth');
			$this->lConf['imageheight']   = $this->getFlexformData('general', 'imageheight');

			$this->lConf['frame']     = $this->getFlexformData('settings', 'frame');
			$this->lConf['delay']     = $this->getFlexformData('settings', 'delay');
			$this->lConf['speed']     = $this->getFlexformData('settings', 'speed');
			$this->lConf['loops']     = $this->getFlexformData('settings', 'loops');
			$this->lConf['clockwise'] = $this->getFlexformData('settings', 'clockwise');
			$this->lConf['draggable'] = $this->getFlexformData('settings', 'draggable');
			$this->lConf['throwable'] = $this->getFlexformData('settings', 'throwable');
			$this->lConf['clickfree'] = $this->getFlexformData('settings', 'clickfree');
			$this->lConf['wheelable'] = $this->getFlexformData('settings', 'wheelable');

			$this->lConf['options']         = $this->getFlexformData('special', 'options');
			$this->lConf['optionsOverride'] = $this->getFlexformData('special', 'optionsOverride');

			// define the key of the element
			$this->contentKey .= "_c" . $this->cObj->data['uid'];
			
			// Override the config with flexform data
			if ($this->lConf['view']) {
				$this->conf['config.']['view'] = $this->lConf['view'];
			}
			if ($this->lConf['imagepath']) {
				$this->conf['config.']['imagepath'] = $this->lConf['imagepath'];
			}
			if ($this->lConf['singleImage']) {
				$this->conf['config.']['singleImage'] = $this->lConf['singleImage'];
			}
			if ($this->lConf['singleFrames']) {
				$this->conf['config.']['singleFrames'] = $this->lConf['singleFrames'];
			}
			if ($this->lConf['singleColumns']) {
				$this->conf['config.']['singleColumns'] = $this->lConf['singleColumns'];
			}
			if ($this->lConf['panoramaImage']) {
				$this->conf['config.']['panoramaImage'] = $this->lConf['panoramaImage'];
			}
			if ($this->lConf['imagewidth']) {
				$this->conf['config.']['imagewidth'] = $this->lConf['imagewidth'];
			}
			if ($this->lConf['imageheight']) {
				$this->conf['config.']['imageheight'] = $this->lConf['imageheight'];
			}

			if ($this->lConf['frame'] > 0) {
				$this->conf['config.']['frame'] = $this->lConf['frame'];
			}
			if ($this->lConf['delay'] >= 0) {
				$this->conf['config.']['delay'] = $this->lConf['delay'];
			}
			if ($this->lConf['speed'] > 0) {
				$this->conf['config.']['speed'] = $this->lConf['speed'];
			}
			if ($this->lConf['loops'] < 2) {
				$this->conf['config.']['loops'] = $this->lConf['loops'];
			}
			if ($this->lConf['clockwise'] < 2) {
				$this->conf['config.']['clockwise'] = $this->lConf['clockwise'];
			}
			if ($this->lConf['draggable'] < 2) {
				$this->conf['config.']['draggable'] = $this->lConf['draggable'];
			}
			if ($this->lConf['throwable'] < 2) {
				$this->conf['config.']['throwable'] = $this->lConf['throwable'];
			}
			if ($this->lConf['clickfree'] < 2) {
				$this->conf['config.']['clickfree'] = $this->lConf['clickfree'];
			}
			if ($this->lConf['wheelable'] < 2) {
				$this->conf['config.']['wheelable'] = $this->lConf['wheelable'];
			}

			if ($this->lConf['options']) {
				$this->conf['config.']['options'] = $this->lConf['options'];
			}
			if ($this->lConf['optionsOverride'] < 2) {
				$this->conf['config.']['optionsOverride'] = $this->lConf['optionsOverride'];
			}
		}

		return $this->pi_wrapInBaseClass($this->parseTemplate($this->conf['images']));
	}

	/**
	 * Parse all images into the template
	 * @param $data
	 * @return string
	 */
	public function parseTemplate($dir='')
	{
		$this->pagerenderer = t3lib_div::makeInstance('tx_jf360shots_pagerenderer');
		$this->pagerenderer->setConf($this->conf);
		
		// define the directory of images
		if ($dir == '') {
			$dir = $this->imageDir;
		}

		// define the contentKey if not exist
		if ($this->contentKey == '') {
			$this->contentKey = "jf360shots_key";
		}

		// define the jQuery mode and function
		if ($this->conf['jQueryNoConflict']) {
			$jQueryNoConflict = "jQuery.noConflict();";
		} else {
			$jQueryNoConflict = "";
		}

		// set the actual view
		$view = $this->conf['config.']['view'];

		// set all options
		$options = array();

		$GLOBALS['TSFE']->register['key'] = $this->contentKey;
		$GLOBALS['TSFE']->register['imagewidth']  = $this->conf['config.']['imagewidth'];
		$GLOBALS['TSFE']->register['imageheight'] = $this->conf['config.']['imageheight'];

		if ($view == 'single') {
			if (t3lib_div::getFileAbsFileName($dir . $this->conf['config.']['singleImage'])) {
				$GLOBALS['TSFE']->register['file'] = trim($dir . $this->conf['config.']['singleImage']);
			} else {
				$GLOBALS['TSFE']->register['file'] = trim($this->conf['config.']['singleImage']);
			}
			$imageRes   = $this->cObj->IMG_RESOURCE($this->conf['views.'][$view.'.']['image.']);
			$options['image'] = "image: '" . $imageRes . "'";
			if (is_numeric($this->conf['config.']['singleFrames']) && is_numeric($this->conf['config.']['singleColumns'])) {
				$options['frames']  = "frames: " . $this->conf['config.']['singleFrames'];
				$options['footage'] = "footage: " . $this->conf['config.']['singleColumns'];
			} else {
				// try to calculate the frames and columns
				$countX = 1;
				if ($GLOBALS['TSFE']->lastImgResourceInfo[0] && $this->conf['config.']['imagewidth']) {
					$countX = $GLOBALS['TSFE']->lastImgResourceInfo[0] / $this->conf['config.']['imagewidth'];
				}
				$countY = 1;
				if ($GLOBALS['TSFE']->lastImgResourceInfo[1] && $this->conf['config.']['imageheight']) {
					$countY = $GLOBALS['TSFE']->lastImgResourceInfo[1] / $this->conf['config.']['imageheight'];
				}
				$options['frames']  = "frames: " . $countX * $countY;
				$options['footage'] = "footage: " . $countX;
			}
			// generating the preview image
			$previewRes = $this->cObj->IMG_RESOURCE($this->conf['views.'][$view.'.']['previewimage.']);
			$GLOBALS['TSFE']->register['previewimage'] = $previewRes;
		} elseif ($view == 'panorama') {
			if (t3lib_div::getFileAbsFileName($dir . $this->conf['config.']['panoramaImage'])) {
				$GLOBALS['TSFE']->register['file'] = trim($dir . $this->conf['config.']['panoramaImage']);
			} else {
				$GLOBALS['TSFE']->register['file'] = trim($this->conf['config.']['panoramaImage']);
			}
			$imageRes   = $this->cObj->IMG_RESOURCE($this->conf['views.'][$view.'.']['image.']);
			$options['image'] = "image: '" . $imageRes . "'";
			$options['stitched'] = "stitched: ".$GLOBALS['TSFE']->lastImgResourceInfo[0];
			// generating the preview image
			$previewRes = $this->cObj->IMG_RESOURCE($this->conf['views.'][$view.'.']['previewimage.']);
			$GLOBALS['TSFE']->register['previewimage'] = $previewRes;
		} else {
			$imagepath = str_replace(PATH_site, '', t3lib_div::getFileAbsFileName($this->conf['config.']['imagepath']));
			$images_temp = t3lib_div::getFilesInDir($imagepath, '', true, 1, '');
			$imageList = array();
			if (count($images_temp) > 0) {
				foreach ($images_temp as $key => $image) {
					$pathinfo = pathinfo($image);
					if (t3lib_div::inList('gif,png,jpeg,jpg', strtolower($pathinfo['extension']))) {
						$images[$key] = $image;
					}
				}
				$GLOBALS['TSFE']->register['biggestimagewidth']  = 0;
				$GLOBALS['TSFE']->register['biggestimageheight'] = 0;
				$GLOBALS['TSFE']->register['IMAGE_ID'] = 0;
				$GLOBALS['TSFE']->register['IMAGE_COUNT'] = count($images);
				$imageList = array();
				foreach ($images as $key => $image) {
					$GLOBALS['TSFE']->register['file'] = trim($image);
					$imageRes = $this->cObj->IMG_RESOURCE($this->conf['views.'][$view.'.']['image.']);
					if (count($imageList) == 0) {
						$GLOBALS['TSFE']->register['firstimage'] = $imageRes;
					}
					$imageList[] = t3lib_div::quoteJSvalue($imageRes);
					$GLOBALS['TSFE']->register['IMAGE_ID'] ++;
					if ($GLOBALS['TSFE']->register['biggestimagewidth'] < $GLOBALS['TSFE']->lastImgResourceInfo[0]){
						$GLOBALS['TSFE']->register['biggestimagewidth'] = $GLOBALS['TSFE']->lastImgResourceInfo[0];
					}
					if ($GLOBALS['TSFE']->register['biggestimageheight'] < $GLOBALS['TSFE']->lastImgResourceInfo[1]){
						$GLOBALS['TSFE']->register['biggestimageheight'] = $GLOBALS['TSFE']->lastImgResourceInfo[1];
					}
				}
			}
			$options['images'] = "images: [".implode(", ", $imageList)."]";
			$options['frames'] = "frames: ".count($imageList);
		}

		if ($this->conf['config.']['free'] > 0) {
			$options['free'] = "free: ".$this->conf['config.']['clickfree'];
		}
		if (is_numeric($this->conf['config.']['delay']) && $this->conf['config.']['speed'] > 0) {
			$options['delay'] = "delay: ".$this->conf['config.']['delay'];
			$options['speed'] = "speed: ".$this->conf['config.']['speed'];
		}
		$options['loops']     = "loops: ".($this->conf['config.']['loops'] ? 'true':'false');
		$options['clockwise'] = "cw: ".($this->conf['config.']['clockwise'] ? 'true':'false');
		$options['draggable'] = "draggable: ".($this->conf['config.']['draggable'] ? 'true':'false');
		$options['throwable'] = "throwable: ".($this->conf['config.']['throwable'] ? 'true':'false');
		$options['clickfree'] = "clickfree: ".($this->conf['config.']['clickfree'] ? 'true':'false');
		$options['wheelable'] = "wheelable: ".($this->conf['config.']['wheelable'] ? 'true':'false');

		// overwrite all options if set
		if (trim($this->conf['config.']['options'])) {
			if ($this->conf['config.']['optionsOverride']) {
				$options = array($this->conf['config.']['options']);
			} else {
				$options['options'] = $this->conf['config.']['options'];
			}
		}

		// The template for JS
		if (! $this->templateFileJS = $this->cObj->fileResource($this->conf['templateFileJS'])) {
			$this->templateFileJS = $this->cObj->fileResource("EXT:jf360shots/res/tx_jf360shots_pi1.js");
		}
		// get the Template of the Javascript
		if (! $templateCode = trim($this->cObj->getSubpart($this->templateFileJS, "###TEMPLATE_JS###"))) {
			$templateCode = "alert('Template TEMPLATE_JS is missing')";
		}
		// set the key
		$markerArray = array();
		$markerArray["KEY"] = $this->contentKey;
		$markerArray["OPTIONS"] = (count($options) > 0 ? "{\n		".implode(",\n		", $options)."\n	}" : "");
		// set the markers
		$templateCode = $this->cObj->substituteMarkerArray($templateCode, $markerArray, '###|###', 0);

		$this->pagerenderer->addJS($jQueryNoConflict . $templateCode);

		// define the js file
		$this->pagerenderer->addJsFile($this->conf['jQuery360']);

		// checks if t3jquery is loaded
		if (T3JQUERY === TRUE) {
			tx_t3jquery::addJqJS();
			if ($this->conf['config.']['wheelable'] && t3lib_div::int_from_ver($this->pagerenderer->getExtensionVersion('t3jquery')) <= 1010003) {
				$this->pagerenderer->addJsFile($this->conf['jQueryMouseWheel']);
			}
		} else {
			$this->pagerenderer->addJsFile($this->conf['jQueryLibrary'], TRUE);
			if ($this->conf['config.']['wheelable']) {
				$this->pagerenderer->addJsFile($this->conf['jQueryMouseWheel']);
			}
		}

		// Add the ressources
		$this->pagerenderer->addResources();

		$GLOBALS['TSFE']->register['key'] = $this->contentKey;
		$return_string = $this->cObj->cObjGetSingle($this->conf['views.'][$view.'.']['template'], $this->conf['views.'][$view.'.']['template.']);

		return $return_string;
	}

	/**
	* Set the piFlexform data
	*
	* @return void
	*/
	protected function setFlexFormData()
	{
		if (! count($this->piFlexForm)) {
			$this->pi_initPIflexForm();
			$this->piFlexForm = $this->cObj->data['pi_flexform'];
		}
	}

	/**
	 * Extract the requested information from flexform
	 * @param string $sheet
	 * @param string $name
	 * @param boolean $devlog
	 * @return string
	 */
	protected function getFlexformData($sheet='', $name='', $devlog=TRUE)
	{
		$this->setFlexFormData();
		if (! isset($this->piFlexForm['data'])) {
			if ($devlog === TRUE) {
				t3lib_div::devLog("Flexform Data not set", $this->extKey, 1);
			}
			return NULL;
		}
		if (! isset($this->piFlexForm['data'][$sheet])) {
			if ($devlog === TRUE) {
				t3lib_div::devLog("Flexform sheet '{$sheet}' not defined", $this->extKey, 1);
			}
			return NULL;
		}
		if (! isset($this->piFlexForm['data'][$sheet]['lDEF'][$name])) {
			if ($devlog === TRUE) {
				t3lib_div::devLog("Flexform Data [{$sheet}][{$name}] does not exist", $this->extKey, 1);
			}
			return NULL;
		}
		if (isset($this->piFlexForm['data'][$sheet]['lDEF'][$name]['vDEF'])) {
			return $this->pi_getFFvalue($this->piFlexForm, $name, $sheet);
		} else {
			return $this->piFlexForm['data'][$sheet]['lDEF'][$name];
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf360shots/pi1/class.tx_jf360shots_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf360shots/pi1/class.tx_jf360shots_pi1.php']);
}
?>