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

namespace SimoneChinaglia\CustomCarrierTrackers\Model\Tracker\Source;

use Magento\Framework\Data\OptionSourceInterface;
use SimoneChinaglia\CustomCarrierTrackers\Model\Tracker;

class IsActive implements OptionSourceInterface
{
    /**
     * @var Tracker
     */
    protected $tracker;

    /**
     * Constructor
     *
     * @param Tracker $tracker
     */
    public function __construct(
        Tracker $tracker
    ) {
        $this->tracker = $tracker;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $availableOptions = $this->tracker->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
