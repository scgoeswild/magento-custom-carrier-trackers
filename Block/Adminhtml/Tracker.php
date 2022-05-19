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

namespace SimoneChinaglia\CustomCarrierTrackers\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Tracker extends Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'SimoneChinaglia_CustomCarrierTrackers';
        $this->_controller = 'adminhtml_tracker';
        $this->_headerText = __('Gestione vettori');
        $this->_addButtonLabel = __('Aggiungi vettore');
        parent::_construct();
    }
}
