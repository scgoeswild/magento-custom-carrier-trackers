# Custom carries trackers
Add unlimited new custom ship carriers and allow to your customers to track their shipment directly from their account and the shipment email.

<div align="center">
  <img src="https://img.shields.io/badge/magento-2.4-brightgreen.svg?logo=magento&longCache=true" alt="Supported Magento Versions" />
   <a href="https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity" target="_blank"><img src="https://img.shields.io/badge/maintained%3F-yes-brightgreen.svg" alt="Maintained - Yes" /></a>
  <a href="https://opensource.org/licenses/GPL-3.0" target="_blank"><img src="https://img.shields.io/badge/license-GPL-blue.svg" /></a>
  <a href="https://packagist.org/packages/simonechinaglia/module-custom-carrier-trackers"><img src="http://poser.pugx.org/simonechinaglia/module-custom-carrier-trackers/v" alt="Latest Stable Version"></a> 
<a href="https://packagist.org/packages/simonechinaglia/module-custom-carrier-trackers"><img src="http://poser.pugx.org/simonechinaglia/module-custom-carrier-trackers/downloads" alt="Total Downloads"></a> 
<a href="https://packagist.org/packages/simonechinaglia/module-custom-carrier-trackers"><img src="http://poser.pugx.org/simonechinaglia/module-custom-carrier-trackers/v/unstable" alt="Latest Unstable Version"></a> 
<a href="https://packagist.org/packages/simonechinaglia/module-custom-carrier-trackers"><img src="http://poser.pugx.org/simonechinaglia/module-custom-carrier-trackers/license" alt="License"></a> 
<a href="https://packagist.org/packages/simonechinaglia/module-custom-carrier-trackers"><img src="http://poser.pugx.org/simonechinaglia/module-custom-carrier-trackers/require/php" alt="PHP Version Require"></a></p>
</div>

## Overview

Are the Magento default shipping carriers not enough for your store? Do you need to add more custom carriers? Do you want your customers to track their shipment directly from their account and the shipment email? We have the solution for all those questions!

The Custom Carrier Trackers extension gives you the ability to add new custom tracking carriers. As is well known Magento provides default shipping carriers only for DHL, UPS, USPS and FedEx, which sometimes are not enough. So with this extension you will solve that problem. Add as many new tracking carriers as you need with a fully configurable tracking carrier title and URL. The default Magento tracking methods can be disabled. Give the possibility to your customers to track their shipment directly from their account section and the shipment email. Easy management and a full overview of all your custom carrier trackers in Magento admin.

## Key Features

- Unlimited new completely custom carrier trackers
- Each carrier tracker is fully configurable. Title, tracking url, enable/disabled
- The tracking number gets replaced in the tracking URL automatically, just use the variable #TRACKNUM#
- Additional extra variables #FIRSTNAME#, #LASTNAME#, #COUNTRYCODE#, #POSTCODE#
- Customers can track their order directly from the shipment email
- Customers can track their order directly from their account section
- Default Magento shipping carriers can be disabled
- Store owners also can track shipments from Magento admin directly
- Custom carrier trackers quick inline edit in Magento admin grid
- Custom carrier trackers Magento admin grid for a better overview
- Manage custom carrier trackers via API

## Other Features

- Developed by a Magento Certified Developer
- Meets Magento standard development practices
- Simple installation
- 100% open source

## Introduction installation:

### Option 1: Manual installation
- Download file
- Unzip the file
- Create a folder [root]/app/code/SimoneChinaglia/CustomCarrierTrackers
- Copy to folder

### Option 2: Composer installation (suggest)
```
composer require simonechinaglia/module-custom-carrier-trackers
```
### Enable Extension

```
php bin/magento module:enable SimoneChinaglia_CustomCarrierTrackers
php bin/magento setup:upgrade
php bin/magento cache:clean
php bin/magento setup:static-content:deploy
