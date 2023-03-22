<?php

namespace Langnang\Module\Automate;

class Automate
{
  public $list = [];
  public $active;
  // 新增任务
  function insert(AutometeItem $item)
  {
    array_push($this->list, $item);
  }
  // 启动
  function start($name = null)
  {
    $list = array_filter($this->list, function ($item) use ($name) {
      if (is_null($name)) return true;
      return $item->name === $name;
    });
    $index = mt_rand(0, sizeof($list) - 1);
    $this->active = $list[$index];
    $result = $this->active->start();
    return $result;
  }
}


class AutometeItem
{
  public $name;
}
