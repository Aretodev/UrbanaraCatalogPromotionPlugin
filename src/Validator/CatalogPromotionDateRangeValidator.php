<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Validator;

use Urbanara\CatalogPromotionPlugin\Entity\CatalogPromotionInterface;
use Urbanara\CatalogPromotionPlugin\Validator\Constraints\CatalogPromotionDateRange;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class CatalogPromotionDateRangeValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        /** @var CatalogPromotionInterface $value */
        Assert::isInstanceOf($value, CatalogPromotionInterface::class);

        /** @var CatalogPromotionDateRange $constraint */
        Assert::isInstanceOf($constraint, CatalogPromotionDateRange::class);

        if (null === $value->getStartsAt() || null === $value->getEndsAt()) {
            return;
        }

        if ($value->getStartsAt()->getTimestamp() > $value->getEndsAt()->getTimestamp()) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('endsAt')
                ->addViolation()
            ;
        }
    }
}
