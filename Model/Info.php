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

namespace SimoneChinaglia\CustomCarrierTrackers\Model;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Serialize\Serializer\Json;

class Info
{
    const MODULE_NAME = 'Vettori Custom';

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var Json
     */
    protected $serializer;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param DriverInterface $driver
     * @param Json            $serializer
     * @param Reader          $reader
     */
    public function __construct(
        DriverInterface $driver,
        Json $serializer,
        Reader $reader
    ) {
        $this->driver = $driver;
        $this->serializer = $serializer;
        $this->reader = $reader;
    }

    /**
     * Returns extension version
     *
     * @throws FileSystemException
     *
     * @return null|string
     */
    public function getExtensionVersion(): ?string
    {
        $file = $this->reader->getModuleDir('', 'SimoneChinaglia_CustomCarrierTrackers') . '/composer.json';

        if ($this->driver->isExists($file)) {
            $content = $this->driver->fileGetContents($file);

            if ($content) {
                $jsonContent = $this->serializer->unserialize($content);

                if (!empty($jsonContent['version'])) {
                    return $jsonContent['version'];
                }
            }
        }

        return null;
    }

    /**
     * Returns extension name
     *
     * @return string
     */
    public function getExtensionName(): string
    {
        return self::MODULE_NAME;
    }
}
