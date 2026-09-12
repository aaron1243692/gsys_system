<?php

namespace App\Services;

class GradingRules
{
    public function gradeRules(): array
    {
        $min = max(0, (float) config('grading.minimum'));
        $max = min(999.99, (float) config('grading.maximum'));

        return ['nullable', 'numeric', 'decimal:0,2', 'between:'.$min.','.$max];
    }

    public function assertEditable(int $quarter): void
    {
        abort_unless(in_array($quarter, [1, 2, 3], true)
            && in_array($quarter, config('grading.editable_quarters'), true), 403, 'This quarter is not editable.');
    }
}
