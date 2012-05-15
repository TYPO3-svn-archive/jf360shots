<?php

########################################################################
# Extension Manager/Repository config file for ext "jf360shots".
#
# Auto generated 16-05-2012 00:34
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => '360 degrees shots',
	'description' => 'Implements the plugin jQuery-reel for adding 360 degrees shot animation. Use t3jquery for better integration with other jQuery extensions.',
	'category' => 'plugin',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'shy' => '',
	'dependencies' => 'cms,jftcaforms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_jf360shots',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.0.3',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.3.0-4.99.999',
			'jftcaforms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:75:{s:21:"ext_conf_template.txt";s:4:"2922";s:12:"ext_icon.gif";s:4:"e30e";s:17:"ext_localconf.php";s:4:"c521";s:14:"ext_tables.php";s:4:"d04c";s:15:"flexform_ds.xml";s:4:"c8c7";s:13:"locallang.xml";s:4:"4d58";s:16:"locallang_db.xml";s:4:"5767";s:12:"t3jquery.txt";s:4:"125c";s:14:"doc/manual.sxw";s:4:"fb3f";s:41:"lib/class.tx_jf360shots_itemsProcFunc.php";s:4:"b51d";s:40:"lib/class.tx_jf360shots_pagerenderer.php";s:4:"9cd1";s:35:"lib/class.tx_jf360shots_tceFunc.php";s:4:"1806";s:39:"lib/class.tx_jf360shots_tsparserext.php";s:4:"e972";s:14:"pi1/ce_wiz.gif";s:4:"3e13";s:31:"pi1/class.tx_jf360shots_pi1.php";s:4:"f3d4";s:39:"pi1/class.tx_jf360shots_pi1_wizicon.php";s:4:"55b2";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"adc8";s:24:"res/tx_jf360shots_pi1.js";s:4:"8957";s:19:"res/images/0001.jpg";s:4:"5825";s:19:"res/images/0003.jpg";s:4:"a1a2";s:19:"res/images/0005.jpg";s:4:"e4b6";s:19:"res/images/0007.jpg";s:4:"7013";s:19:"res/images/0009.jpg";s:4:"5adb";s:19:"res/images/0011.jpg";s:4:"0190";s:19:"res/images/0013.jpg";s:4:"fd83";s:19:"res/images/0015.jpg";s:4:"4d49";s:19:"res/images/0017.jpg";s:4:"b4ae";s:19:"res/images/0019.jpg";s:4:"69aa";s:19:"res/images/0021.jpg";s:4:"ecfa";s:19:"res/images/0023.jpg";s:4:"5c4d";s:19:"res/images/0025.jpg";s:4:"a72f";s:19:"res/images/0027.jpg";s:4:"479b";s:19:"res/images/0029.jpg";s:4:"59f8";s:19:"res/images/0031.jpg";s:4:"5022";s:19:"res/images/0033.jpg";s:4:"ca0b";s:19:"res/images/0035.jpg";s:4:"7eac";s:19:"res/images/0037.jpg";s:4:"a304";s:19:"res/images/0039.jpg";s:4:"3434";s:19:"res/images/0041.jpg";s:4:"b61f";s:19:"res/images/0043.jpg";s:4:"d03b";s:19:"res/images/0045.jpg";s:4:"8b79";s:19:"res/images/0047.jpg";s:4:"662e";s:19:"res/images/0049.jpg";s:4:"716b";s:19:"res/images/0051.jpg";s:4:"378a";s:19:"res/images/0053.jpg";s:4:"0c4f";s:19:"res/images/0055.jpg";s:4:"4eef";s:19:"res/images/0057.jpg";s:4:"8d54";s:19:"res/images/0059.jpg";s:4:"8f28";s:19:"res/images/0061.jpg";s:4:"eeea";s:19:"res/images/0063.jpg";s:4:"664e";s:19:"res/images/0065.jpg";s:4:"b894";s:19:"res/images/0067.jpg";s:4:"93f4";s:19:"res/images/0069.jpg";s:4:"1024";s:19:"res/images/0071.jpg";s:4:"1311";s:19:"res/images/0073.jpg";s:4:"76c5";s:19:"res/images/0075.jpg";s:4:"1461";s:19:"res/images/0077.jpg";s:4:"df95";s:19:"res/images/0079.jpg";s:4:"e969";s:19:"res/images/0081.jpg";s:4:"75f8";s:19:"res/images/0083.jpg";s:4:"52c5";s:19:"res/images/0085.jpg";s:4:"c183";s:19:"res/images/0087.jpg";s:4:"726b";s:19:"res/images/0089.jpg";s:4:"57e2";s:19:"res/images/0091.jpg";s:4:"cdb2";s:19:"res/images/0093.jpg";s:4:"58f0";s:19:"res/images/0095.jpg";s:4:"8aee";s:19:"res/images/0097.jpg";s:4:"4ae0";s:19:"res/images/0099.jpg";s:4:"56bb";s:33:"res/jquery/js/jquery-1.7.2.min.js";s:4:"b8d6";s:44:"res/jquery/js/jquery.mousewheel-3.0.6.min.js";s:4:"25db";s:34:"res/jquery/js/jquery.reel-1.1.4.js";s:4:"b065";s:38:"res/jquery/js/jquery.reel-1.1.4.min.js";s:4:"c157";s:20:"static/constants.txt";s:4:"98c6";s:16:"static/setup.txt";s:4:"92fd";}',
	'suggests' => array(
	),
);

?>