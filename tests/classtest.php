<?php

require_once 'classes/LeavePlanDto.php';

$plan = new LeavePlanDto();
$plan->userName = 'clv219';
$plan->startDate = '2010-01-01';
$plan->endDate = '2010-03-01';

echo $plan->toString();


?>