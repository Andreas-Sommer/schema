<?php
defined('TYPO3_MODE') || die();

$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_schema_webpagetype';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-postProcess'][] =
    \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class . '->execute';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing'][] =
    \Brotkrueml\Schema\Hooks\TableConfiguration\Pages::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'] = ['Brotkrueml\\Schema\\ViewHelpers'];
