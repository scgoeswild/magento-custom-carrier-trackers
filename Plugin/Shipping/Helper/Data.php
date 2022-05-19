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

namespace SimoneChinaglia\CustomCarrierTrackers\Plugin\Shipping\Helper;

use SimoneChinaglia\CustomCarrierTrackers\Model\Config;
use SimoneChinaglia\CustomCarrierTrackers\Helper\Data as TrackerHelper;
use Magento\Sales\Model\Order\Shipment\Track;
use Magento\Sales\Model\AbstractModel;
use Magento\Shipping\Helper\Data as ShippingHelperData;

class Data
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var TrackerHelper
     */
    protected $dataHelper;

    /**
     * @param Config        $config
     * @param TrackerHelper $dataHelper
     */
    public function __construct(
        Config $config,
        TrackerHelper $dataHelper
    ) {
        $this->config = $config;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Shipping tracking popup URL getter
     *
     * @param  ShippingHelperData $subject
     * @param  \Closure           $proceed
     * @param  AbstractModel      $model
     * @return string
     */
    public function aroundGetTrackingPopupUrlBySalesModel(
        ShippingHelperData $subject,
        \Closure $proceed,
        $model
    ) {
        $result = $proceed($model);
        if ($this->config->isEnabled()) {
            if ($model instanceof Track) {
                if ($trackingUrl = $this->dataHelper->getTrackingUrl(
                    $model->getCarrierCode(),
                    $model->getNumber(),
                    $model->getParentId()
                )
                ) {
                    return $trackingUrl;
                }
            }
        }
        return $result;
    }
}
