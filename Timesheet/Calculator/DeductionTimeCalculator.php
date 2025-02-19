<?php

/*
 * This file is part of the DeductionTimeBundle for Kimai.
 * All rights reserved by Kevin Papst (www.keleo.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DeductionTimeBundle\Timesheet\Calculator;

use App\Entity\Timesheet;
use App\Timesheet\CalculatorInterface;
use KimaiPlugin\DeductionTimeBundle\DeductionTimeBundle;

final class DeductionTimeCalculator implements CalculatorInterface
{
    public function calculate(Timesheet $record): void
    {
        if ($record->getActivity() === null) {
            return;
        }

        $meta = $record->getActivity()->getMetaFieldValue(DeductionTimeBundle::META_FIELD_DEDUCTION);

        if ($meta === null) {
            return;
        }

        if ((bool) $meta === true) {
            $duration = $record->getDuration(false);
            if ($duration > 0) {
                $record->setDuration($duration * -1);
            }
        }
    }

    public function getPriority(): int
    {
        return 9999;
    }
}
