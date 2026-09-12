<?php

return [
    // Provisional encoding limits, not an institutional passing policy.
    'minimum' => (float) env('GRADING_MINIMUM', 0),
    'maximum' => (float) env('GRADING_MAXIMUM', 100),
    'editable_quarters' => [1, 2, 3],
    'report_roles' => ['admin'],
    'report_permission' => 'grades.view',
];
