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

namespace SimoneChinaglia\CustomCarrierTrackers\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;

class Tracker extends AbstractExtensibleObject implements TrackerInterface
{
    /**
     * Retrieve tracker id
     *
     * @return int
     */
    public function getTrackerId()
    {
        return $this->_get(self::TRACKER_ID);
    }

    /**
     * Retrieve carrier code
     *
     * @return string
     */
    public function getCarrierCode()
    {
        return (string)$this->_get(self::CODE);
    }

    /**
     * Retrieve carrier title
     *
     * @return string
     */
    public function getCarrierTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Retrieve tracking url
     *
     * @return string
     */
    public function getTrackingUrl()
    {
        return $this->_get(self::URL);
    }

    /**
     * Retrieve custom carrier tracker creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->_get(self::CREATION_TIME);
    }

    /**
     * Retrieve custom carrier tracker update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->_get(self::UPDATE_TIME);
    }

    /**
     * Get Is active
     *
     * @return bool
     */
    public function getIsActive()
    {
        return (bool)$this->_get(self::IS_ACTIVE);
    }

    /**
     * Set Tracker ID
     *
     * @param  int $id
     * @return TrackerInterface
     */
    public function setTrackerId($id)
    {
        return $this->setData(self::TRACKER_ID, $id);
    }

    /**
     * Set carrier code
     *
     * @param  string $carrierCode
     * @return TrackerInterface
     */
    public function setCarrierCode($carrierCode)
    {
        return $this->setData(self::CODE, $carrierCode);
    }

    /**
     * Set carrier title
     *
     * @param  string $title
     * @return TrackerInterface
     */
    public function setCarrierTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set tracking url
     *
     * @param  string $trackingUrl
     * @return TrackerInterface
     */
    public function setTrackingUrl($trackingUrl)
    {
        return $this->setData(self::URL, $trackingUrl);
    }

    /**
     * Set creation time
     *
     * @param  string $creationTime
     * @return TrackerInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param  string $updateTime
     * @return TrackerInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param  bool|int $isActive
     * @return TrackerInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}
