<?php
declare(strict_types=1);

namespace HimaMage\RoundedDiscountPrice\Model\Rule\Action;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class RoundingTypeProvider
 * @package HimaMage\RoundedDiscountPrice\Model\Rule\Action
 */
class RoundingTypeProvider implements OptionSourceInterface
{
    // this are the only three value available
    public const ROUNDING_TYPE_NONE = 'none';
    public const ROUNDING_TYPE_UP = 'up';
    public const ROUNDING_TYPE_DOWN = 'down';

    /**
     *  option for ui_component will return array contain each value and it's label displayed on the form
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('None'),
                'value' => self::ROUNDING_TYPE_NONE
            ],
            [
                'label' => __('Up'),
                'value' => self::ROUNDING_TYPE_UP
            ],
            [
                'label' => __('Down'),
                'value' => self::ROUNDING_TYPE_DOWN
            ]
        ];
    }
}

