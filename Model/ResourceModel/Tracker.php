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

namespace SimoneChinaglia\CustomCarrierTrackers\Model\ResourceModel;

use Magento\Framework\DataObject;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Tracker extends AbstractDb
{
    /**
     * DB connection
     *
     * @var AdapterInterface
     */
    protected $connection;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('simonechinaglia_custom_carrier_trackers', 'tracker_id');
        $this->connection = $this->getConnection();
    }

    /**
     * Load carrier tracker from DB by carrier code
     *
     * @param string $carrierCode
     *
     * @throws LocalizedException
     *
     * @return array
     */
    public function loadByCarrierCode($carrierCode): array
    {
        $select = $this->connection->select()->from(
            $this->getMainTable()
        )->where(
            'carrier_code = :carrier_code'
        );

        $binds = [':carrier_code' => $carrierCode];

        $result = $this->connection->fetchRow($select, $binds);

        if (!$result) {
            return [];
        }

        return $result;
    }

    /**
     * Check for unique of carrier code
     *
     * @param DataObject $tracker
     *
     * @throws LocalizedException
     *
     * @return bool
     */
    public function getIsUniqueCarrierCode(DataObject $tracker): bool
    {
        $select = $this->connection->select()->from(
            ['cct' => $this->getMainTable()]
        )->where(
            'cct.carrier_code = ?',
            $tracker->getData('carrier_code')
        );

        if ($tracker->getTrackerId()) {
            $select->where('cct.tracker_id <> ?', $tracker->getTrackerId());
        }

        if ($this->connection->fetchRow($select)) {
            return false;
        }

        return true;
    }
}
