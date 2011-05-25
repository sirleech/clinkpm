<?php

$start_date = '2009-06-17';

$end_date = '2009-09-05';

$date_from_user = '2009-07-28';

echo check_in_range($start_date, $end_date, $date_from_user);


function check_in_range($start_date, $end_date, $date_from_user)
{
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

?>