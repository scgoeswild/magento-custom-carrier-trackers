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

namespace SimoneChinaglia\CustomCarrierTrackers\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use SimoneChinaglia\CustomCarrierTrackers\Model\Info as ExtensionInfo;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Backend\Block\AbstractBlock;
use Magento\Framework\Exception\FileSystemException;

class Info extends AbstractBlock implements RendererInterface
{
    /**
     * @var ExtensionInfo
     */
    protected $info;

    /**
     * @param Context       $context
     * @param ExtensionInfo $info
     */
    public function __construct(
        Context $context,
        ExtensionInfo $info
    ) {
        $this->info = $info;
        parent::__construct($context);
    }

    /**
     * Render form element as HTML
     *
     * @param  AbstractElement $element
     * @return string
     * @throws FileSystemException
     */
    public function render(AbstractElement $element): string
    {
        $version = $this->info->getExtensionVersion();
        $name = $this->info->getExtensionName();
        $logoUrl = 'https://simonechinaglia.net/wp-content/uploads/2020/12/cropped-simone-favicon.png';

        $html = <<<HTML
<div style="background: url('$logoUrl') no-repeat scroll 15px 15px #fff;
background-size: 65px;
border:1px solid #e3e3e3; min-height:65px; display;block;
padding:15px 15px 15px 130px;">
<p>
<strong>$name Extension v$version</strong> by <strong><a href="https://www.simonechinaglia.net" target="_blank">SimoneChinaglia</a></strong></p>
<p>If you need support or have any questions, please contact me at
<a href="mailto:hello@simonechinaglia.net">hello@simonechinaglia.net</a>.
</p>
</div>
HTML;
        return $html;
    }
}
