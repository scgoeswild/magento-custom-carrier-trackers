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

namespace SimoneChinaglia\CustomCarrierTrackers\Plugin\Shipping\Model\Order;

use Magento\Shipping\Model\CarrierFactory;
use Magento\Shipping\Model\Order\Track as OrderTrack;

class Track
{
    /**
     * @var CarrierFactory
     */
    protected $carrierFactory;

    /**
     * @param CarrierFactory $carrierFactory
     */
    public function __construct(
        CarrierFactory $carrierFactory
    ) {
        $this->carrierFactory = $carrierFactory;
    }

    /**
     * Retrieve detail for shipment track
     *
     * @param OrderTrack $subject
     * @param array      $result
     *
     * @return array
     */
    public function afterGetNumberDetail(
        OrderTrack $subject,
        $result
    ) {
        $carrierInstance = $this->carrierFactory->create($subject->getCarrierCode());
        if (!$carrierInstance) {
            $result['carrier_code'] = $subject->getCarrierCode();
            return $result;
        }
        return $result;
    }
}
