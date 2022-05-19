/**
 * SimoneChinaglia Custom Carrier Trackers Extension
 *
 * @category  SimoneChinaglia
 * @package   SimoneChinaglia_CustomCarrierTrackers
 * @author    Simone Chinaglia
 * @copyright Copyright (c) 2022 SimoneChinaglia (https://www.simonechinaglia.com)
 * @license   LICENSE_MV.txt or https://www.simonechinaglia.com/license-agreement/
 */

define(
    [
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'Magento_Ui/js/lib/validation/validator'
    ], function ($, Abstract, validator) {
        'use strict';

        validator.addRule(
            'validate-tracking-url',
            function (value) {
                value = (value || '').replace(/^\s+/, '').replace(/\s+$/, '');
                return value.match(/#TRACKNUM#/) && (/^(http|https):\/\/(([A-Z0-9]([A-Z0-9_-]*[A-Z0-9]|))(\.[A-Z0-9]([A-Z0-9_-]*[A-Z0-9]|))*)(:(\d+))?(\/[A-Z0-9~](([A-Z0-9_~-]|\.)*[A-Z0-9~]|))*\/?(.*)?$/i).test(value);
            },
            $.mage.__('Inserisci un URl valido. Protocolo (http:// or https://) e #TRACKNUM# .')
        );

        return Abstract;
    }
);
