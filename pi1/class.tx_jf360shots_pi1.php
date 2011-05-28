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

if (t3lib_extMgm::isLoaded('t3jquery')) {
	require_once(t3lib_extMgm::extPath('t3jquery').'class.tx_t3jquery.php');
}


/**
 * Plugin 'Multiple Content' for the 'jf360shots' extension.
 *
 * @author     Juergen Furrer <juergen.furrer@gmail.com>
 * @package    TYPO3
 * @subpackage tx_jf360shots
 */
class tx_jf360shots_pi1 extends tslib_pibase
{
	var $prefixId      = 'tx_jf360shots_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_jf360shots_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'jf360shots';	// The extension key.
	var $pi_checkCHash = true;
	var $lConf = array();
	var $contentKey = null;
	var $jsFiles = array();
	var $js = array();
	var $css = array();
	var $images = array();
	var $captions = array();
	var $imageDir = 'uploads/tx_jf360shots/';
	var $type = 'normal';

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf)
	{
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		// define the key of the element
		$this->contentKey = "jf360shots";

		if ($this->cObj->data['list_type'] == $this->extKey.'_pi1') {
			$this->type = 'normal';

			// It's a content, all data from flexform
			
			$this->lConf['imagepath']   = $this->getFlexformData('general', 'imagepath');
			$this->lConf['imagewidth']  = $this->getFlexformData('general', 'imagewidth');
			$this->lConf['imageheight'] = $this->getFlexformData('general', 'imageheight');

			$this->lConf['method']      = $this->getFlexformData('settings', 'method');
			$this->lConf['direction']   = $this->getFlexformData('settings', 'direction');
			$this->lConf['cycle']       = $this->getFlexformData('settings', 'cycle');
			$this->lConf['resetMargin'] = $this->getFlexformData('settings', 'resetMargin');
			$this->lConf['sensibility'] = $this->getFlexformData('settings', 'sensibility');

			$this->lConf['options'] = $this->getFlexformData('special', 'options');

			// define the key of the element
			$this->contentKey .= "_c" . $this->cObj->data['uid'];
			
			// Override the config with flexform data
			if ($this->lConf['imagepath']) {
				$this->conf['config.']['imagepath'] = $this->lConf['imagepath'];
			}
			if ($this->lConf['imagewidth']) {
				$this->conf['config.']['imagewidth'] = $this->lConf['imagewidth'];
			}
			if ($this->lConf['imageheight']) {
				$this->conf['config.']['imageheight'] = $this->lConf['imageheight'];
			}
			if ($this->lConf['method']) {
				$this->conf['config.']['method'] = $this->lConf['method'];
			}
			if ($this->lConf['direction']) {
				$this->conf['config.']['direction'] = $this->lConf['direction'];
			}
			if ($this->lConf['cycle'] > 0) {
				$this->conf['config.']['cycle'] = $this->lConf['cycle'];
			}
			if ($this->lConf['resetMargin'] > 0) {
				$this->conf['config.']['resetMargin'] = $this->lConf['resetMargin'];
			}
			if ($this->lConf['sensibility']) {
				$this->conf['config.']['sensibility'] = $this->lConf['sensibility'];
			}

			$this->conf['config.']['options']   = $this->lConf['options'];
		}

		return $this->pi_wrapInBaseClass($this->parseTemplate($this->conf['images'], false));
	}

	/**
	 * Parse all images into the template
	 * @param $data
	 * @return string
	 */
	function parseTemplate($dir='')
	{
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

		$options = array();

		// set all options
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
			$GLOBALS['TSFE']->register['key'] = $this->contentKey;
			$GLOBALS['TSFE']->register['imagewidth']  = $this->conf['config.']['imagewidth'];
			$GLOBALS['TSFE']->register['imageheight'] = $this->conf['config.']['imageheight'];
			$GLOBALS['TSFE']->register['biggestimagewidth']  = 0;
			$GLOBALS['TSFE']->register['biggestimageheight'] = 0;
			$GLOBALS['TSFE']->register['IMAGE_ID'] = 0;
			$GLOBALS['TSFE']->register['IMAGE_COUNT'] = count($images);
			$imageList = array();
			foreach ($images as $key => $image) {
				$GLOBALS['TSFE']->register['file'] = trim($image);
				$imageRes = $this->cObj->IMG_RESOURCE($this->conf['image.']);
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
		if ($this->conf['config.']['method']) {
			$options['method'] = "method: '".$this->conf['config.']['method']."'";
		}
		if ($this->conf['config.']['direction']) {
			$options['direction'] = "direction: '".$this->conf['config.']['direction']."'";
		}
		if ($this->conf['config.']['cycle'] > 0) {
			$options['cycle'] = "cycle: ".$this->conf['config.']['cycle'];
		}
		if ($this->conf['config.']['resetMargin'] > 0) {
			$options['resetMargin'] = "resetMargin: ".$this->conf['config.']['resetMargin'];
		}
		if ($this->conf['config.']['sensibility'] > 0) {
			$options['sensibility'] = "sensibility: ".$this->conf['config.']['sensibility'];
		}

		// overwrite all options if set
		if (trim($this->conf['options'])) {
			$options = array($this->conf['options']);
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

		$this->addJS($jQueryNoConflict . $templateCode);

		// checks if t3jquery is loaded
		if (T3JQUERY === true) {
			tx_t3jquery::addJqJS();
		} else {
			$this->addJsFile($this->conf['jQueryLibrary'], true);
		}

		// define the js file
		$this->addJsFile($this->conf['jQuery360']);

		// Add the ressources
		$this->addResources();

		$GLOBALS['TSFE']->register['key'] = $this->contentKey;
		$return_string = $this->cObj->cObjGetSingle($this->conf['template'], $this->conf['template.']);

		return $return_string;
	}

	/**
	 * Include all defined resources (JS / CSS)
	 *
	 * @return void
	 */
	function addResources()
	{
		if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
			$pagerender = $GLOBALS['TSFE']->getPageRenderer();
		}
		// Fix moveJsFromHeaderToFooter (add all scripts to the footer)
		if ($GLOBALS['TSFE']->config['config']['moveJsFromHeaderToFooter']) {
			$allJsInFooter = true;
		} else {
			$allJsInFooter = false;
		}
		// add all defined JS files
		if (count($this->jsFiles) > 0) {
			foreach ($this->jsFiles as $jsToLoad) {
				if (T3JQUERY === true) {
					$conf = array(
						'jsfile' => $jsToLoad,
						'tofooter' => ($this->conf['jsInFooter'] || $allJsInFooter),
						'jsminify' => $this->conf['jsMinify'],
					);
					tx_t3jquery::addJS('', $conf);
				} else {
					$file = $this->getPath($jsToLoad);
					if ($file) {
						if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
							if ($allJsInFooter) {
								$pagerender->addJsFooterFile($file, 'text/javascript', $this->conf['jsMinify']);
							} else {
								$pagerender->addJsFile($file, 'text/javascript', $this->conf['jsMinify']);
							}
						} else {
							$temp_file = '<script type="text/javascript" src="'.$file.'"></script>';
							if ($allJsInFooter) {
								$GLOBALS['TSFE']->additionalFooterData['jsFile_'.$this->extKey.'_'.$file] = $temp_file;
							} else {
								$GLOBALS['TSFE']->additionalHeaderData['jsFile_'.$this->extKey.'_'.$file] = $temp_file;
							}
						}
					} else {
						t3lib_div::devLog("'{$jsToLoad}' does not exists!", $this->extKey, 2);
					}
				}
			}
		}
		// add all defined JS script
		if (count($this->js) > 0) {
			foreach ($this->js as $jsToPut) {
				$temp_js .= $jsToPut;
			}
			$conf = array();
			$conf['jsdata'] = $temp_js;
			if (T3JQUERY === true && t3lib_div::int_from_ver($this->getExtensionVersion('t3jquery')) >= 1002000) {
				$conf['tofooter'] = ($this->conf['jsInFooter'] || $allJsInFooter);
				$conf['jsminify'] = $this->conf['jsMinify'];
				$conf['jsinline'] = $this->conf['jsInline'];
				tx_t3jquery::addJS('', $conf);
			} else {
				// Add script only once
				$hash = md5($temp_js);
				if ($this->conf['jsInline']) {
					$GLOBALS['TSFE']->inlineJS[$hash] = $temp_css;
				} elseif (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
					if ($this->conf['jsInFooter'] || $allJsInFooter) {
						$pagerender->addJsFooterInlineCode($hash, $temp_js, $this->conf['jsMinify']);
					} else {
						$pagerender->addJsInlineCode($hash, $temp_js, $this->conf['jsMinify']);
					}
				} else {
					if ($this->conf['jsMinify']) {
						$temp_js = t3lib_div::minifyJavaScript($temp_js);
					}
					if ($this->conf['jsInFooter'] || $allJsInFooter) {
						$GLOBALS['TSFE']->additionalFooterData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, true);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['js_'.$this->extKey.'_'.$hash] = t3lib_div::wrapJS($temp_js, true);
					}
				}
			}
		}
		// add all defined CSS files
		if (count($this->cssFiles) > 0) {
			foreach ($this->cssFiles as $cssToLoad) {
				// Add script only once
				$file = $this->getPath($cssToLoad);
				if ($file) {
					if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
						$pagerender->addCssFile($file, 'stylesheet', 'all', '', $this->conf['cssMinify']);
					} else {
						$GLOBALS['TSFE']->additionalHeaderData['cssFile_'.$this->extKey.'_'.$file] = '<link rel="stylesheet" type="text/css" href="'.$file.'" media="all" />'.chr(10);
					}
				} else {
					t3lib_div::devLog("'{$cssToLoad}' does not exists!", $this->extKey, 2);
				}
			}
		}
		// add all defined CSS Script
		if (count($this->css) > 0) {
			foreach ($this->css as $cssToPut) {
				$temp_css .= $cssToPut;
			}
			$hash = md5($temp_css);
			if (t3lib_div::int_from_ver(TYPO3_version) >= 4003000) {
				$pagerender->addCssInlineBlock($hash, $temp_css, $this->conf['cssMinify']);
			} else {
				// addCssInlineBlock
				$GLOBALS['TSFE']->additionalCSS['css_'.$this->extKey.'_'.$hash] .= $temp_css;
			}
		}
	}

	/**
	 * Return the webbased path
	 * 
	 * @param string $path
	 * return string
	 */
	function getPath($path="")
	{
		return $GLOBALS['TSFE']->tmpl->getFileName($path);
	}

	/**
	 * Add additional JS file
	 * 
	 * @param string $script
	 * @param boolean $first
	 * @return void
	 */
	function addJsFile($script="", $first=false)
	{
		if ($this->getPath($script) && ! in_array($script, $this->jsFiles)) {
			if ($first === true) {
				$this->jsFiles = array_merge(array($script), $this->jsFiles);
			} else {
				$this->jsFiles[] = $script;
			}
		}
	}

	/**
	 * Add JS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	function addJS($script="")
	{
		if (! in_array($script, $this->js)) {
			$this->js[] = $script;
		}
	}

	/**
	 * Add additional CSS file
	 * 
	 * @param string $script
	 * @return void
	 */
	function addCssFile($script="")
	{
		if ($this->getPath($script) && ! in_array($script, $this->cssFiles)) {
			$this->cssFiles[] = $script;
		}
	}

	/**
	 * Add CSS to header
	 * 
	 * @param string $script
	 * @return void
	 */
	function addCSS($script="")
	{
		if (! in_array($script, $this->css)) {
			$this->css[] = $script;
		}
	}

	/**
	 * Returns the version of an extension (in 4.4 its possible to this with t3lib_extMgm::getExtensionVersion)
	 * @param string $key
	 * @return string
	 */
	function getExtensionVersion($key)
	{
		if (! t3lib_extMgm::isLoaded($key)) {
			return '';
		}
		$_EXTKEY = $key;
		include(t3lib_extMgm::extPath($key) . 'ext_emconf.php');
		return $EM_CONF[$key]['version'];
	}

	/**
	 * Extract the requested information from flexform
	 * @param string $sheet
	 * @param string $name
	 * @param boolean $devlog
	 * @return string
	 */
	protected function getFlexformData($sheet='', $name='', $devlog=true)
	{
		$this->pi_initPIflexForm();
		$piFlexForm = $this->cObj->data['pi_flexform'];
		if (! isset($piFlexForm['data'])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data not set", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($piFlexForm['data'][$sheet])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform sheet '{$sheet}' not defined", $this->extKey, 1);
			}
			return null;
		}
		if (! isset($piFlexForm['data'][$sheet]['lDEF'][$name])) {
			if ($devlog === true) {
				t3lib_div::devLog("Flexform Data [{$sheet}][{$name}] does not exist", $this->extKey, 1);
			}
			return null;
		}
		if (isset($piFlexForm['data'][$sheet]['lDEF'][$name]['vDEF'])) {
			return $this->pi_getFFvalue($piFlexForm, $name, $sheet);
		} else {
			return $piFlexForm['data'][$sheet]['lDEF'][$name];
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf360shots/pi1/class.tx_jf360shots_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/jf360shots/pi1/class.tx_jf360shots_pi1.php']);
}
?>