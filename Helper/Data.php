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

namespace SimoneChinaglia\CustomCarrierTrackers\Helper;

use Magento\Framework\App\Helper\Context;
use SimoneChinaglia\CustomCarrierTrackers\Model\Config;
use SimoneChinaglia\CustomCarrierTrackers\Model\TrackerFactory;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use \Magento\Sales\Model\Order;

class Data extends AbstractHelper
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
     * @var ShipmentRepositoryInterface
     */
    protected $shipmentRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param Context                     $context
     * @param Config                      $config
     * @param TrackerFactory              $trackerFactory
     * @param ShipmentRepositoryInterface $shipmentRepository
     * @param OrderRepositoryInterface    $orderRepository
     * @param ModuleListInterface         $moduleList
     */
    public function __construct(
        Context $context,
        Config $config,
        TrackerFactory $trackerFactory,
        ShipmentRepositoryInterface $shipmentRepository,
        OrderRepositoryInterface $orderRepository,
        ModuleListInterface $moduleList
    ) {
        $this->config = $config;
        $this->trackerFactory = $trackerFactory;
        $this->shipmentRepository = $shipmentRepository;
        $this->orderRepository = $orderRepository;
        $this->moduleList = $moduleList;
        parent::__construct($context);
    }

    /**
     * Retrieve tracking url
     *
     * @param  string $carrierCode
     * @param  string $trackingNumber
     * @param  int    $shipId
     * @return null|string
     */
    public function getTrackingUrl($carrierCode, $trackingNumber, $shipId): ?string
    {
        $trackingUrl = null;
        if ($this->config->isEnabled()) {
            $trackingUrl = $this->_getTrackingUrl($carrierCode, $trackingNumber, $shipId);
        }

        return $trackingUrl;
    }

    /**
     * Retrieve tracking url with replaced variables
     *
     * @param  string $carrierCode
     * @param  string $trackingNumber
     * @param  int    $shipId
     * @return null|string
     */
    protected function _getTrackingUrl($carrierCode, $trackingNumber, $shipId): ?string
    {
        $trackingUrl = null;
        $customCarrier = $this->trackerFactory->create()->loadByCarrierCode($carrierCode);
        if ($customCarrier->getTrackerId()) {
            $customTrackingUrl = $customCarrier->getTrackingUrl();
            $trackingUrl = str_replace('#TRACKNUM#', $trackingNumber, $customTrackingUrl);
            if ($this->hasTrackingUrlExtraVariables($customTrackingUrl)) {
                $shipment = $this->shipmentRepository->get($shipId);
                if ($shipment) {
                    $orderId = $shipment->getOrderId();
                    $order = $this->orderRepository->get($orderId);
                    $trackingUrl = $this->replaceExtraVariables($trackingUrl, $order);
                }
            }
        }
        return $trackingUrl;
    }

    /**
     * Retrieve tracking url with replaced extra variables
     *
     * @param  string $trackingUrl
     * @param  $order       Order
     * @return string
     */
    protected function replaceExtraVariables($trackingUrl, $order): string
    {
        $address = $order->getShippingAddress();
        if ($address) {
            if (preg_match('#FIRSTNAME#', $trackingUrl)) {
                $trackingUrl = str_replace('#FIRSTNAME#', $address->getFirstname(), $trackingUrl);
            }
            if (preg_match('#LASTNAME#', $trackingUrl)) {
                $trackingUrl = str_replace('#LASTNAME#', $address->getLastname(), $trackingUrl);
            }
            if (preg_match('#COUNTRYCODE#', $trackingUrl)) {
                $trackingUrl = str_replace('#COUNTRYCODE#', $address->getCountryId(), $trackingUrl);
            }
            if (preg_match('#POSTCODE#', $trackingUrl)) {
                $trackingUrl = str_replace('#POSTCODE#', $address->getPostcode(), $trackingUrl);
            }
        }
        return $trackingUrl;
    }

    /**
     * Check tracking url for extra variables
     *
     * @param  string $customTrackingUrl
     * @return bool
     */
    protected function hasTrackingUrlExtraVariables($customTrackingUrl): bool
    {
        if (preg_match('#FIRSTNAME#', $customTrackingUrl) || preg_match('#LASTNAME#', $customTrackingUrl)
            || preg_match('#COUNTRYCODE#', $customTrackingUrl) || preg_match('#POSTCODE#', $customTrackingUrl)
        ) {
            return true;
        }
        return false;
    }
}
