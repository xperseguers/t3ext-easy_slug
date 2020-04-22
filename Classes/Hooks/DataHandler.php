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
     * @param string|int $uid (uid could be string, for this reason no type hint)
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler
     */
    public function processDatamap_preProcessFieldArray(array &$incomingFieldArray, string $table, $uid, \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler): void
    {
        if (
            $table !== 'pages'
            || !MathUtility::canBeInterpretedAsInteger($uid)
            || (empty($incomingFieldArray['title']) && empty($incomingFieldArray['nav_title']))
        ) {
            return;
        }

        $incomingFieldArray['slug'] = $this->regenerateSlug($table, $uid, $incomingFieldArray);
    }

    /**
     * Reacts to a page moved.
     *
     * @param string $command
     * @param string $table
     * @param int $uid
     * @param int $value
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler
     * @param bool|string $pasteUpdate
     * @param array $pasteDatamap
     */
    public function processCmdmap_postProcess(string $command, string $table, int $uid, int $value, \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler, $pasteUpdate, array &$pasteDatamap): void
    {
        if ($table !== 'pages' || $command !== 'move') {
            return;
        }

        // Create a new event to update the slug
        $pasteDatamap[$table][$uid] = [
            'slug' => $this->regenerateSlug($table, $uid),
        ];
    }

    /**
     * Regenerates the slug.
     *
     * @param string $table
     * @param int $uid
     * @param array $fields
     * @return string
     */
    protected function regenerateSlug(string $table, int $uid, array $fields = []): string
    {
        $record = BackendUtility::getRecordWSOL($table, $uid);
        $record = array_merge($record, $fields);
        if (!empty($record['nav_title'])) {
            // The navigation title should logically be used if present in place
            // of the title to generate the slug
            $record['title'] = $record['nav_title'];
        }

        return $this->buildSlug($record);
    }

    /**
     * Builds a unique slug URI.
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
