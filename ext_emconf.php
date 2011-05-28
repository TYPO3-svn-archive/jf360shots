<?php

########################################################################
# Extension Manager/Repository config file for ext "jf360shots".
#
# Auto generated 26-09-2010 20:54
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => '360 degrees shots',
	'description' => 'Implements a jQuery plugin for adding 360 degrees shot animation. Use t3jquery for better integration with other jQuery extensions.',
	'category' => 'plugin',
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'uploads/tx_jf360shots',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.2.5',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'php' => '5.0.0-5.3.99',
			'typo3' => '4.3.0-4.5.99',
			'jftcaforms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:27:{s:24:"class.tx_jf360shots.php";s:4:"58a6";s:12:"ext_icon.gif";s:4:"1eaf";s:17:"ext_localconf.php";s:4:"19e6";s:14:"ext_tables.php";s:4:"ce27";s:14:"ext_tables.sql";s:4:"04d7";s:15:"flexform_ds.xml";s:4:"05c7";s:13:"locallang.xml";s:4:"ab6c";s:16:"locallang_db.xml";s:4:"58f0";s:12:"mode_dam.gif";s:4:"999b";s:15:"mode_damcat.gif";s:4:"2596";s:15:"mode_folder.gif";s:4:"9d05";s:15:"mode_upload.gif";s:4:"fecd";s:12:"t3jquery.txt";s:4:"8543";s:14:"doc/manual.sxw";s:4:"b8fe";s:39:"lib/class.tx_jf360shots_cms_layout.php";s:4:"346c";s:42:"lib/class.tx_jf360shots_itemsProcFunc.php";s:4:"224c";s:14:"pi1/ce_wiz.gif";s:4:"f039";s:32:"pi1/class.tx_jf360shots_pi1.php";s:4:"30fa";s:40:"pi1/class.tx_jf360shots_pi1_wizicon.php";s:4:"fa09";s:17:"pi1/locallang.xml";s:4:"7e03";s:33:"res/jquery/js/jquery-1.4.2.min.js";s:4:"1009";s:39:"res/jquery/js/jquery.cloudzoom-1.0.2.js";s:4:"71ff";s:43:"res/jquery/js/jquery.cloudzoom-1.0.2.min.js";s:4:"c25f";s:20:"static/constants.txt";s:4:"2b47";s:16:"static/setup.txt";s:4:"947a";s:24:"static/tt_news/setup.txt";s:4:"2f6d";s:28:"static/tt_products/setup.txt";s:4:"fdb4";}',
	'suggests' => array(
	),
);

?>