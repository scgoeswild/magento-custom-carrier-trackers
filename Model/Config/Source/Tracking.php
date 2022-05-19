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

namespace SimoneChinaglia\CustomCarrierTrackers\Model\Config\Source;

use Magento\Shipping\Model\Config;
use Magento\Framework\Option\ArrayInterface;

class Tracking implements ArrayInterface
{
    /**
     * @var Config
     */
    protected $shippingConfig;

    /**
     * @param Config $shippingConfig
     */
    public function __construct(
        Config $shippingConfig
    ) {
        $this->shippingConfig = $shippingConfig;
    }

    /**
     * Return array of default tracking carriers.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $carriersArray = [];
        $carriers = $this->shippingConfig->getAllCarriers();
        foreach ($carriers as $code => $carrier) {
            if ($carrier->isTrackingAvailable()) {
                $carriersArray[] = ['value' => $code, 'label' => $carrier->getConfigData('title')];
            }
        }
        return $carriersArray;
    }
}
