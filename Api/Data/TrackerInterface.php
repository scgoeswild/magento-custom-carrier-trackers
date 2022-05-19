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

namespace SimoneChinaglia\CustomCarrierTrackers\Api\Data;

/**
 * Custom carrier tracker interface
 *
 * @api
 */
interface TrackerInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TRACKER_ID    = 'tracker_id';
    const TITLE         = 'carrier_title';
    const CODE          = 'carrier_code';
    const URL           = 'tracking_url';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const IS_ACTIVE     = 'is_active';
    /**
     * #@-
     */

    /**
     * Get Tracker ID
     *
     * @return int|null
     */
    public function getTrackerId();

    /**
     * Get carrie code
     *
     * @return string
     */
    public function getCarrierCode();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getCarrierTitle();

    /**
     * Get tracking url
     *
     * @return string|null
     */
    public function getTrackingUrl();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Get Is active
     *
     * @return bool|null
     */
    public function getIsActive();

    /**
     * Set Tracker ID
     *
     * @param  int $id
     * @return TrackerInterface
     */
    public function setTrackerId($id);

    /**
     * Set carrier code
     *
     * @param  string $carrierCode
     * @return TrackerInterface
     */
    public function setCarrierCode($carrierCode);

    /**
     * Set title
     *
     * @param  string $carrierTitle
     * @return TrackerInterface
     */
    public function setCarrierTitle($carrierTitle);

    /**
     * Set trackingUrl
     *
     * @param  string $trackingUrl
     * @return TrackerInterface
     */
    public function setTrackingUrl($trackingUrl);

    /**
     * Set creation time
     *
     * @param  string $creationTime
     * @return TrackerInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param  string $updateTime
     * @return TrackerInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param  bool|int $isActive
     * @return TrackerInterface
     */
    public function setIsActive($isActive);
}
