<?php 

namespace Ihidzhov\FaaS;

class Trigger {
  
  const TRIGGER_HTTP = 1;
  const TRIGGER_SCHEDULE = 2;

  const TRIGGER_HTTP_NAME = "HTTP(S)";
  const TRIGGER_SCHEDULE_NAME = "Time";

  const AS_ARRAY = [
    self::TRIGGER_HTTP => self::TRIGGER_HTTP_NAME,
    self::TRIGGER_SCHEDULE => self::TRIGGER_SCHEDULE_NAME,
  ];
  
}