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

namespace SimoneChinaglia\CustomCarrierTrackers\Block\Adminhtml\Tracker\Edit;

use Magento\Backend\Block\Widget\Context;
use SimoneChinaglia\CustomCarrierTrackers\Api\TrackerRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var TrackerRepositoryInterface
     */
    protected $trackerRepository;

    /**
     * @param Context                    $context
     * @param TrackerRepositoryInterface $trackerRepository
     */
    public function __construct(
        Context $context,
        TrackerRepositoryInterface $trackerRepository
    ) {
        $this->context = $context;
        $this->trackerRepository = $trackerRepository;
    }

    /**
     * Return Tracker ID
     *
     * @return int|null
     */
    public function getTrackerId(): ?int
    {
        try {
            return $this->trackerRepository->getById(
                $this->context->getRequest()->getParam('tracker_id')
            )->getTrackerId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
