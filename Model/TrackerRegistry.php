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

namespace SimoneChinaglia\CustomCarrierTrackers\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\EntityManager\EntityManager;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterface;
use SimoneChinaglia\CustomCarrierTrackers\Api\Data\TrackerInterfaceFactory;

class TrackerRegistry
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TrackerInterfaceFactory
     */
    private $trackerDataFactory;

    /**
     * @var array
     */
    private $trackerRegistry = [];

    /**
     * @param EntityManager           $entityManager,
     * @param TrackerInterfaceFactory $trackerDataFactory
     */
    public function __construct(
        EntityManager $entityManager,
        TrackerInterfaceFactory $trackerDataFactory
    ) {
        $this->entityManager = $entityManager;
        $this->trackerDataFactory = $trackerDataFactory;
    }

    /**
     * Retrieve Tracker from registry by ID
     *
     * @param  int $trackerId
     * @return Tracker
     * @throws NoSuchEntityException
     */
    public function retrieve($trackerId)
    {
        if (!isset($this->trackerRegistry[$trackerId])) {
            $tracker = $this->trackerDataFactory->create();
            $this->entityManager->load($tracker, $trackerId);
            if (!$tracker->getTrackerId()) {
                throw NoSuchEntityException::singleField('trackerId', $trackerId);
            } else {
                $this->trackerRegistry[$trackerId] = $tracker;
            }
        }
        return $this->trackerRegistry[$trackerId];
    }

    /**
     * Remove instance of the Tracker from registry by ID
     *
     * @param  int $trackerId
     * @return void
     */
    public function remove($trackerId)
    {
        if (isset($this->trackerRegistry[$trackerId])) {
            unset($this->trackerRegistry[$trackerId]);
        }
    }

    /**
     * Replace existing Tracker with a new one
     *
     * @param  TrackerInterface $tracker
     * @return $this
     */
    public function push(TrackerInterface $tracker)
    {
        $this->trackerRegistry[$tracker->getTrackerId()] = $tracker;
        return $this;
    }
}
