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

namespace SimoneChinaglia\CustomCarrierTrackers\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime\DateTime;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;
use SimoneChinaglia\CustomCarrierTrackers\Model\ResourceModel\Tracker as ResourceTracker;

class Tracker extends AbstractModel implements TrackerInterface
{
    const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 0;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @param Context                         $context
     * @param Registry                        $registry
     * @param DateTime                        $dateTime
     * @param ResourceTracker|null            $resource
     * @param ResourceTracker\Collection|null $resourceCollection
     */
    public function __construct(
        Context $context,
        Registry $registry,
        DateTime $dateTime,
        ResourceTracker $resource = null,
        ResourceTracker\Collection $resourceCollection = null
    ) {
        $this->dateTime = $dateTime;
        parent::__construct($context, $registry, $resource, $resourceCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_init(ResourceTracker::class);
    }

    /**
     * Retrieve tracker id
     *
     * @return null|int
     */
    public function getTrackerId(): ?int
    {
        return (int) $this->getData(self::TRACKER_ID);
    }

    /**
     * Retrieve carrier code
     *
     * @return string
     */
    public function getCarrierCode(): string
    {
        return (string) $this->getData(self::CODE);
    }

    /**
     * Retrieve carrier title
     *
     * @return string
     */
    public function getCarrierTitle(): string
    {
        return (string) $this->getData(self::TITLE);
    }

    /**
     * Retrieve tracking url
     *
     * @return string
     */
    public function getTrackingUrl(): string
    {
        return (string) $this->getData(self::URL);
    }

    /**
     * Retrieve custom carrier tracker creation time
     *
     * @return null|string
     */
    public function getCreationTime(): ?string
    {
        return (string) $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve custom carrier tracker update time
     *
     * @return null|string
     */
    public function getUpdateTime(): ?string
    {
        return (string) $this->getData(self::UPDATE_TIME);
    }

    /**
     * Get Is active
     *
     * @return bool
     */
    public function getIsActive(): bool
    {
        return (bool) $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set Tracker ID
     *
     * @param int $id
     *
     * @return TrackerInterface
     */
    public function setTrackerId($id): TrackerInterface
    {
        return $this->setData(self::TRACKER_ID, $id);
    }

    /**
     * Set carrier code
     *
     * @param string $carrierCode
     *
     * @return TrackerInterface
     */
    public function setCarrierCode($carrierCode): TrackerInterface
    {
        return $this->setData(self::CODE, $carrierCode);
    }

    /**
     * Set carrier title
     *
     * @param string $title
     *
     * @return TrackerInterface
     */
    public function setCarrierTitle($title): TrackerInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set tracking url
     *
     * @param string $trackingUrl
     *
     * @return TrackerInterface
     */
    public function setTrackingUrl($trackingUrl): TrackerInterface
    {
        return $this->setData(self::URL, $trackingUrl);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     *
     * @return TrackerInterface
     */
    public function setCreationTime($creationTime): TrackerInterface
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     *
     * @return TrackerInterface
     */
    public function setUpdateTime($updateTime): TrackerInterface
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     *
     * @return TrackerInterface
     */
    public function setIsActive($isActive): TrackerInterface
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Load carrier tracker from DB by carrier code
     *
     * @param string $carrierCode
     *
     * @return $this
     */
    public function loadByCarrierCode($carrierCode): self
    {
        $this->addData($this->getResource()->loadByCarrierCode($carrierCode));

        return $this;
    }

    /**
     * Check for unique of carrier code
     *
     * @param DataObject $tracker
     *
     * @return bool
     */
    public function getIsUniqueCarrierCode(DataObject $tracker): bool
    {
        return $this->getResource()->getIsUniqueCarrierCode($tracker);
    }

    /**
     * Prepare tracker's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Perform operations before object save
     *
     * @throws LocalizedException
     *
     * @return $this
     */
    public function beforeSave(): self
    {
        $this->setTrackingUrl(trim($this->getTrackingUrl()));
        //create the carrier_code from the carrier_title
        $carrierCode = strtolower(preg_replace('/\s+/', '', $this->getCarrierTitle()));
        $this->setCarrierCode('cct_' . $carrierCode);

        if (!$this->getIsUniqueCarrierCode($this)) {
            throw new LocalizedException(
                __('A custom carrier tracker with the same title already exists.')
            );
        }

        $nowGmtDate = $this->dateTime->gmtDate();

        if ($this->isObjectNew()) {
            $this->setCreationTime($nowGmtDate);
        }
        $this->setUpdateTime($nowGmtDate);

        return parent::beforeSave();
    }
}
