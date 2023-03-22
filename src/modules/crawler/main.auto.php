<?php

use Langnang\Module\Automate\AutometeItem;
use Langnang\Module\Crawler\Crawler;
use phpspider\core\requests;
use phpspider\core\selector;

global $_AUTOMATE;

class AutoCrawlerItem extends AutometeItem
{

  public $name = "Crawler";
  public $task;
  public $scan_url_list = [];
  public $list_urls = [];
  public $content_urls = [];
  function __construct()
  {
    $crawler_controller = new Crawler();
    $task = $crawler_controller->select_rand([
      "parent" => 0,
    ]);
    $this->task = $task;
    $this->scan_url_list = $task['scan_urls'];
  }
  // 正则校验是否为内容页地址
  function is_content_url($url)
  {
    return sizeof(array_filter($this->task['content_url_regexes'], function ($reg) use ($url) {
      return preg_match($reg, $url) == true;
    }));
  }
  // 正则校验是否为列表页地址
  function is_list_url($url)
  {
    return sizeof(array_filter($this->task['list_url_regexes'], function ($reg) use ($url) {
      return preg_match($reg, $url);
    }));
  }
  // 提取页面内容及页面内超链接
  function get_html($url)
  {
    $html = requests::get($url);
    $parse_url = parse_url($url);

    $links = (array)selector::select($html, "//a/@href");

    $links = array_reduce($links, function ($total, $link) use ($parse_url) {
      $parse_link = array_merge($parse_url, parse_url($link));
      // 判断符合配置域名
      if (in_array($parse_link['scheme'], ['https', 'http']) && in_array($parse_link['host'], $this->task['domains'])) {
        $link = http_build_url($parse_link);
        array_push($total, $link);
      }
      return $total;
    }, []);

    $this->scan_url_list = array_unique(array_merge($this->scan_url_list, $links));
    return $html;
  }
  function crawler_list_page($url)
  {
  }
  function crawler_content_page($url)
  {
  }
  function start()
  {
    var_dump($this->task);
    $index = 0;
    // ["\/https:\\\/\\\/juejin\\.cn\\\/post\\\/\\\\d+\/"]
    // exit();
    while ($index < sizeof($this->scan_url_list)) {
      $url = strtolower($this->scan_url_list[$index]);
      var_dump($url);
      $is_content_url = $this->is_content_url($url);
      var_dump($is_content_url);
      $is_list_url = $this->is_list_url($url);
      var_dump($is_list_url);
      $html = $this->get_html($url);
      if ($is_content_url) {
      }
      if ($is_list_url) {
      }

      var_dump($index);
      var_dump($this->scan_url_list);
      break;
      $index++;
    }
    var_dump($this->task);
    // global $_FAKER;


    // $method = $_FAKER->randomElement($this->options);
    // $value = $_FAKER->{$method}();
    // if (is_array($value)) $value = json_encode($_FAKER->{$method}(), JSON_UNESCAPED_UNICODE);

    // $row = [
    //   "title" => "mock-{$method}",
    //   "text" => $value,
    //   "type" => "mock",
    //   "status" => "{$method}",
    //   "created" => time(),
    //   "modified" => time(),
    // ];

    // $content_controller = new Content();
    // $content = $content_controller->insert_item($row);
    // return array_merge($row, $content);
  }
}
$_AUTOMATE->insert(new AutoCrawlerItem());
