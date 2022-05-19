<?php
/**
 * SimoneChinaglia Custom Carrier Trackers Extension
 *
 * @category SimoneChinaglia
 * @package  SimoneChinaglia_CustomCarrierTrackers
 *
 * @author    Simone Chinaglia
 * @copyright Copyright (c) 2022 SimoneChinaglia (https://www.simonechinaglia.com)
 * @license   LICENSE_MV.txt or https://www.simonechinaglia.com/license-agreement/
 */
declare(strict_types=1);

namespace SimoneChinaglia\CustomCarrierTrackers\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for custom carrier tracker search results.
 *
 * @api
 */
interface TrackerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get custom carrier tracker list.
     *
     * @return \SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface[]
     */
    public function getItems();

    /**
     * Set custom carrier tracker list.
     *
     * @param \SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
