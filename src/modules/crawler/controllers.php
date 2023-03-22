<?php

namespace Langnang\Module\Crawler;

use Langnang\Module\Root\RootController;

require_once __DIR__ . '/../.mysql/mysql.php';

class Crawler extends RootController
{
  protected $_class = __CLASS__;
  protected $_table_path = __DIR__ . '/table.json';
}
