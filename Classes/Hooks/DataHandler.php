<?php
declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Causal\EasySlug\Hooks;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\Model\RecordStateFactory;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

class DataHandler
{

    /**
     * Collects slugs of persisted records before having been updated.
     *
     * @param array $incomingFieldArray
     * @param string $table
     * @param string|int $id (id could be string, for this reason no type hint)
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler
     */
    public function processDatamap_preProcessFieldArray(array &$incomingFieldArray, string $table, $id, \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler): void
    {
        if (
            $table !== 'pages'
            || !MathUtility::canBeInterpretedAsInteger($id)
            || !empty($incomingFieldArray['slug'])
            || (empty($incomingFieldArray['title']) && empty($incomingFieldArray['nav_title']))
        ) {
            return;
        }

        $record = BackendUtility::getRecordWSOL($table, $id);
        $record = array_merge($record, $incomingFieldArray);

        $incomingFieldArray['slug'] = $this->buildSlug($record);
    }

    /**
     * Build a unique Slug URI
     *
     * @param array $record
     * @param int|null $pid
     * @param string $table
     * @param string $slugFieldName
     * @return string
     */
    public function buildSlug(array $record, ?int $pid = null, string $table = 'pages', string $slugFieldName = 'slug'): string
    {
        $fieldConfig = $GLOBALS['TCA'][$table]['columns'][$slugFieldName]['config'];

        $slugHelper = GeneralUtility::makeInstance(
            SlugHelper::class,
            $table,
            $slugFieldName,
            $fieldConfig
        );

        $pid = ($pid !== null) ? $pid : $record['pid'];
        $slug = $slugHelper->generate($record, $pid);

        $state = RecordStateFactory::forName($table)->fromArray($record, $pid);

        if (strpos($fieldConfig['eval'], 'uniqueInSite') !== false) {
            $slug = $slugHelper->buildSlugForUniqueInSite($slug, $state);
        }

        if (strpos($fieldConfig['eval'], 'uniqueInPid') !== false) {
            $slug = $slugHelper->buildSlugForUniqueInPid($slug, $state);
        }

        $slug = $slugHelper->sanitize($slug);

        return $slug;
    }

}
