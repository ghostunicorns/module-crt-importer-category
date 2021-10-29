<?php
/*
 * Copyright © GhostUnicorns spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CrtImporterCategory\Model;

use GhostUnicorns\CrtBase\Api\CrtConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements CrtConfigInterface
{
    /** string */
    protected const CATEGORY_IMPORT_IS_ENABLED_CONFIG_PATH = 'crt_importer/category/enabled';

    /** string */
    protected const CATEGORY_IMPORT_CONTINUE_IN_CASE_OF_ERROR_CONFIG_PATH =
        'crt_importer/category/continue_in_case_of_errors';

    /** string */
    protected const CATEGORY_IMPORT_IS_LOG_ENABLED_CONFIG_PATH = 'crt_importer/category/log_enabled';

    /** string */
    protected const CATEGORY_IMPORT_LOG_LEVEL_CONFIG_PATH = 'crt_importer/category/log_level';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \GhostUnicorns\CrtImporter\Model\Config
     */
    private $baseConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param \GhostUnicorns\CrtImporter\Model\Config $baseConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \GhostUnicorns\CrtImporter\Model\Config $baseConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->baseConfig = $baseConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->baseConfig->isEnabled() && $this->scopeConfig->isSetFlag(
            self::CATEGORY_IMPORT_IS_ENABLED_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function isLogEnabled(): bool
    {
        return $this->baseConfig->isEnabled() && $this->scopeConfig->isSetFlag(
            self::CATEGORY_IMPORT_IS_LOG_ENABLED_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return int
     */
    public function getLogLevel(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::CATEGORY_IMPORT_LOG_LEVEL_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }

    /**
     * @return bool
     */
    public function continueInCaseOfErrors(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::CATEGORY_IMPORT_CONTINUE_IN_CASE_OF_ERROR_CONFIG_PATH,
            ScopeInterface::SCOPE_WEBSITE
        );
    }
}
