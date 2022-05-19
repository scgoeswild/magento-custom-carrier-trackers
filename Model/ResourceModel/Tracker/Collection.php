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

namespace SimoneChinaglia\CustomCarrierTrackers\Model\ResourceModel\Tracker;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SimoneChinaglia\CustomCarrierTrackers\Model\Tracker;
use SimoneChinaglia\CustomCarrierTrackers\Model\ResourceModel\Tracker as ResourceTracker;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'tracker_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Tracker::class,
            ResourceTracker::class
        );
    }
}
