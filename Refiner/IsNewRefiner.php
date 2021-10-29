<?php
/*
 * Copyright © GhostUnicorns spa. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\CrtImporterCategory\Refiner;

use GhostUnicorns\CrtBase\Api\RefinerInterface;
use GhostUnicorns\CrtBase\Exception\CrtException;
use GhostUnicorns\CrtEntity\Api\Data\EntityInterface;
use GhostUnicorns\CrtUtils\Model\DotConvention;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class IsNewRefiner implements RefinerInterface
{
    /**
     * @var DotConvention
     */
    private $dotConvention;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param DotConvention $dotConvention
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        DotConvention $dotConvention,
        CategoryRepository $categoryRepository
    ) {
        $this->dotConvention = $dotConvention;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param int $activityId
     * @param string $refinerType
     * @param string $entityIdentifier
     * @param EntityInterface[] $entities
     * @throws CrtException|LocalizedException
     */
    public function execute(
        int $activityId,
        string $refinerType,
        string $entityIdentifier,
        array $entities
    ): void {
        $isNewField = 'category_data.is_new';
        $categoryIdField = 'category_data.id';
        $categoryId = $this->dotConvention->getValueFromEntities($entities, $categoryIdField);

        $isNew = true;

        try {
            $this->categoryRepository->get($categoryId);
        } catch (NoSuchEntityException $e) {
            $isNew = false;
        }

        $this->dotConvention->setValueFromEntities($entities, $isNewField, $isNew);
    }
}
