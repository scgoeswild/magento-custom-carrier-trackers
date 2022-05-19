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

namespace SimoneChinaglia\CustomCarrierTrackers\Plugin\Shipping\Block\Adminhtml\Order;

use SimoneChinaglia\CustomCarrierTrackers\Model\Config;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface as TrackerRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use SimoneChinaglia\CustomCarrierTrackers\Model\Tracker;
use Magento\Shipping\Block\Adminhtml\Order\Tracking as OrderTracking;
use Magento\Framework\Exception\LocalizedException;

class Tracking
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param Config                $config
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param TrackerRepository     $trackerRepository
     */
    public function __construct(
        Config $config,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        TrackerRepository $trackerRepository
    ) {
        $this->config = $config;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->trackerRepository = $trackerRepository;
    }

    /**
     * Add custom carriers
     *
     * @param OrderTracking $subject
     * @param array         $result
     *
     * @return array
     * @throws LocalizedException
     */
    public function afterGetCarriers(
        OrderTracking $subject,
        $result
    ) {
        if ($this->config->isEnabled()) {
            $customCarrierTrackers = $this->trackerRepository->getList(
                $this->searchCriteriaBuilder->addFilter('is_active', Tracker::STATUS_ENABLED)->create()
            );

            foreach ($customCarrierTrackers->getItems() as $customCarrierTracker) {
                $result[$customCarrierTracker->getCarrierCode()] = $customCarrierTracker->getCarrierTitle();
            }

            $disabledDefaultCarriers = $this->config->getDisabledDefaultCarriers();
            if (!empty($disabledDefaultCarriers)) {
                foreach ($result as $code => $carrier) {
                    if (in_array($code, $disabledDefaultCarriers)) {
                        unset($result[$code]);
                    }
                }
            }
        }
        return $result;
    }
}
