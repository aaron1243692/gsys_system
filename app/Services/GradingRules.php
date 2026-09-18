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

}
