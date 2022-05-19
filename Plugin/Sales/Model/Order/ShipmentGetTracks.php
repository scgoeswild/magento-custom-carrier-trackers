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

namespace SimoneChinaglia\CustomCarrierTrackers\Plugin\Sales\Model\Order;

use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Sales\Api\Data\ShipmentTrackInterface;
use Magento\Sales\Model\Order\Shipment;
use SimoneChinaglia\CustomCarrierTrackers\Helper\Data;

class ShipmentGetTracks
{
    /**
     * @var ExtensionAttributesFactory
     */
    protected $extensionFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param ExtensionAttributesFactory $extensionFactory
     * @param Data $helper
     */
    public function __construct(
        ExtensionAttributesFactory $extensionFactory,
        Data $helper
    ) {
        $this->extensionFactory = $extensionFactory;
        $this->helper = $helper;
    }

    /**
     * @param Shipment $subject
     * @param mixed    $result
     *
     * @return ShipmentTrackInterface[]|null
     */
    public function afterGetTracks(
        Shipment $subject,
        $result
    ) {
        if (null !== $result) {
            foreach ($result as $trackItem) {
                if ($trackItem->getParentId()) {
                    $extensionAttributes = $trackItem->getExtensionAttributes();

                    if ($extensionAttributes && $extensionAttributes->getTrackingUrl()) {
                        continue;
                    }

                    $trackItemExtension = $extensionAttributes
                        ? $extensionAttributes
                        : $this->extensionFactory->create();

                    $trackingUrl = $this->getTracingUrl($trackItem);
                    $trackItemExtension->setTrackingUrl($trackingUrl);
                    $trackItem->setExtensionAttributes($trackItemExtension);
                }
            }
        }

        return $result;
    }

    /**
     * @param ShipmentTrackInterface $trackItem
     *
     * @return string|null
     */
    private function getTracingUrl(ShipmentTrackInterface $trackItem): ?string
    {
        return $this->helper->getTrackingUrl(
            $trackItem->getCarrierCode(),
            $trackItem->getTrackNumber(),
            $trackItem->getParentId()
        );
    }
}
