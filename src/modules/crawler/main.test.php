<?php

require_once __DIR__ . '/controllers.php';
require_once __DIR__ . '/../main.test.php';

use Langnang\Module\Crawler\Crawler;
use phpspider\core\requests;
use phpspider\core\selector;

global $_FAKER;

$crawler_controller = new Crawler();

$task = $crawler_controller->select_rand([
  "parent" => 0,
]);
$scan_url_list = $task['scan_urls'];
$index = 0;
while ($index < sizeof($scan_url_list)) {
  $url = $scan_url_list[$index];
  $parse_url = parse_url($url);
  $html = requests::get($url);
  $links = (array)selector::select($html, "//a/@href");

  $links = array_reduce($links, function ($total, $link) use ($parse_url, $task, &$scan_url_list) {
    $parse_link = array_merge($parse_url, parse_url($link));
    // 判断符合配置域名
    if (in_array($parse_link['scheme'], ['https', 'http']) && in_array($parse_link['host'], $task['domains'])) {
      $link = http_build_url($parse_link);
      array_push($total, $link);
    }
    return $total;
  }, []);
  // $scan_url_list = array_merge($scan_url_list, $links);
  var_dump($index);
  $index++;
}
var_dump($task);

foreach ($task['scan_urls'] as $url) {
  var_dump($url);
  var_dump(parse_url($url));
}
exit();
// $options = $options['value'];


$method = $_FAKER->randomElement($options);
$value = $_FAKER->{$method}();
if (is_array($value)) $value = json_encode($_FAKER->{$method}(), JSON_UNESCAPED_UNICODE);
// $value = addslashes(json_encode($_FAKER->{$method}(), JSON_UNESCAPED_UNICODE));
$row = [
  "title" => "mock-{$method}",
  "text" => $value,
  "type" => "mock",
  "status" => "{$method}",
  "created" => time(),
  "modified" => time(),
];

$content_controller = new Content();

$content = $content_controller->insert_item($row);

var_dump(array_merge($row, $content));

// $mock_controller->insert_item($row);
