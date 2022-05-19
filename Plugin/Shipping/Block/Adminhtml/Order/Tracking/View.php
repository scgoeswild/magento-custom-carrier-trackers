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

namespace SimoneChinaglia\CustomCarrierTrackers\Plugin\Shipping\Block\Adminhtml\Order\Tracking;

use SimoneChinaglia\CustomCarrierTrackers\Model\Config;
use SimoneChinaglia\CustomCarrierTrackers\Model\TrackerFactory;
use Magento\Framework\Phrase;
use Magento\Shipping\Block\Adminhtml\Order\Tracking\View as TrackingView;

class View
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var TrackerFactory
     */
    protected $trackerFactory;

    /**
     * @param Config         $config
     * @param TrackerFactory $trackerFactory
     */
    public function __construct(
        Config $config,
        TrackerFactory $trackerFactory
    ) {
        $this->config = $config;
        $this->trackerFactory = $trackerFactory;
    }

    /**
     * @param  TrackingView $subject
     * @param  \Closure     $proceed
     * @param  string       $code
     * @return Phrase|string|bool
     */
    public function aroundGetCarrierTitle(
        TrackingView $subject,
        \Closure $proceed,
        $code
    ) {
        $result = $proceed($code);
        if ($this->config->isEnabled()) {
            $customCarrier = $this->trackerFactory->create()->loadByCarrierCode($code);
            if ($customCarrier->getTrackerId()) {
                return $customCarrier->getCarrierTitle();
            }
        }
        return $result;
    }
}
