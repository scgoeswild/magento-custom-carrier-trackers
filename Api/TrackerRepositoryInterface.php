<?php
/**
 * SimoneChinaglia Custom Carrier Trackers Extension
 *
 * @category  SimoneChinaglia
 * @package   SimoneChinaglia_CustomCarrierTrackers
 * @author    Simone Chinaglia
 * @copyright Copyright (c) 2022 SimoneChinaglia (https://www.simonechinaglia.com)
 * @license   LICENSE_MV.txt or https://www.simonechinaglia.com/license-agreement/
 */
declare(strict_types=1);

namespace SimoneChinaglia\CustomCarrierTrackers\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerSearchResultsInterface;

/**
 * Custom carrier tracker CRUD interface.
 *
 * @api
 */
interface TrackerRepositoryInterface
{
    /**
     * Save custom carrier tracker.
     *
     * @param  TrackerInterface $tracker
     * @return TrackerInterface
     * @throws LocalizedException
     */
    public function save(TrackerInterface $tracker);

    /**
     * Retrieve custom carrier tracker.
     *
     * @param  int $trackerId
     * @return TrackerInterface
     * @throws LocalizedException
     */
    public function getById($trackerId);

    /**
     * Retrieve customer carrier trackers matching the specified criteria.
     *
     * @param  SearchCriteriaInterface $searchCriteria
     * @return TrackerSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete custom carrier tracker.
     *
     * @param  TrackerInterface $tracker
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(TrackerInterface $tracker);

    /**
     * Delete custom carrier tracker by ID.
     *
     * @param  int $trackerId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($trackerId);
}
