<?php
declare(strict_types=1);

namespace HimaMage\RoundedDiscountPrice\Plugin;

use HimaMage\RoundedDiscountPrice\Model\Rule\Action\RoundingTypeProvider;
use Magento\CatalogRule\Api\Data\RuleInterface;
use Magento\CatalogRule\Model\Indexer\ProductPriceCalculator;
use Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory as CatalogRuleCollectionFactory;

/**
 * Class ProductPriceCalculatorPlugin
 * @package HimaMage\RoundedDiscountPrice\Plugin
 **/
class ProductPriceCalculatorPlugin
{
    protected CatalogRuleCollectionFactory $catalogRuleCollectionFactory;

    public function __construct(
        CatalogRuleCollectionFactory $catalogRuleCollectionFactory
    ) {
        $this->catalogRuleCollectionFactory = $catalogRuleCollectionFactory;
    }

    /**
     * Round discounted price if needed
     *
     * @param ProductPriceCalculator $subject
     * @param float $result
     * @param array $ruleData
     * @param null $productData
     * @return float
     */
    public function afterCalculate(
        ProductPriceCalculator $subject,
        float $result,
        $ruleData,
        $productData = null
    ): float {
        $roundingType = $this->getRuleRoundingType($ruleData['rule_id']);

        if ($roundingType === null || $roundingType === RoundingTypeProvider::ROUNDING_TYPE_NONE) {
            return $result;
        }

        return $roundingType === RoundingTypeProvider::ROUNDING_TYPE_DOWN ? floor($result) : ceil($result);
    }

    /**
     * Get rounding type of the current catalog rule
     *
     * @param int|string $ruleId
     * @return string|null
     */
    protected function getRuleRoundingType($ruleId): ?string
    {
        return $this->catalogRuleCollectionFactory->create()
            ->addFieldToSelect('rounding_type')
            ->addFieldToFilter(RuleInterface::RULE_ID, $ruleId)
            ->getFirstItem()->getData('rounding_type');
    }
}
