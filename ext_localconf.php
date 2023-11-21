<?php
defined('TYPO3') || die();

(static function (string $_EXTKEY) {
    // We absolutely need to be registered BEFORE EXT:redirects since we expect it should do most of the job for us
    $hooks = [];
    $found = false;
    foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'] as $key => $hook) {
        if ($key === 'redirects') {
            $hooks[$_EXTKEY] = \Causal\EasySlug\Hooks\DataHandler::class;
            $found = true;
        }
        $hooks[$key] = $hook;
    }
    if (!$found) {
        // EXT:redirects was not yet loaded?
        $hooks[$_EXTKEY] = \Causal\EasySlug\Hooks\DataHandler::class;
    }
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'] = $hooks;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][$_EXTKEY] = \Causal\EasySlug\Hooks\DataHandler::class;
})('easy_slug');
