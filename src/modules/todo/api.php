<?php
// TODO
global $_SWAGGER, $rewrite;
$module = "todo";
array_push($_SWAGGER, ["name" => "{$module}", "url" => "{$rewrite}/swagger/{$module}", "path" => __DIR__]);

use Langnang\Module\Todo\TodoModel;

require_once __DIR__ . '/controllers.php';
/**
 * @OA\Info(
 *   title="Todo",
 *   description="待办事项",
 *   version="0.0.1",
 * )
 */
$router->addGroup("/todo", function (FastRoute\RouteCollector $router) {
  /**
   * @OA\Post(
   *     path="/todo/create",
   *     tags={"create"},
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute('POST', '/create', function ($vars) {
    return $vars;
  });
  /**
   * @OA\Post(
   *     path="/todo/drop",
   *     tags={"drop"},
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute('POST', '/drop', function ($vars) {
    return $vars;
  });
  /**
   * @OA\Post(
   *     path="/todo/insert",
   *     summary="Insert Todo",
   *     tags={"insert"},
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute('POST', '/insert', function ($vars) {
    global $_CONNECTION;
    $todo = new TodoModel($vars['post']);
    $todo->set_done(false);
    try {
      $_CONNECTION->insert('todo', (array)$todo);
    } catch (Exception $e) {
      return 400;
    }
    $todo->id = $_CONNECTION->lastInsertId();
    return $todo;
  });
  /**
   * @OA\Post(
   *     path="/todo/delete",
   *     tags={"delete"},
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute('POST', '/delete', function ($vars) {
    return $vars;
  });
  /**
   * @OA\Post(
   *     path="/todo/update",
   *     tags={"update"},
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute('POST', '/update', function ($vars) {
    return $vars;
  });
  /**
   * @OA\Post(
   *     path="/todo/select",
   *     tags={"select"},
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute('POST', '/select', function ($vars) {
    global $_CONNECTION;
    try {
      $list = $_CONNECTION->fetchAllAssociative("SELECT * FROM `todo` ORDER BY `id` ASC");
      $total = $_CONNECTION->fetchOne("SELECT COUNT(*) FROM `todo`");
    } catch (Exception $e) {
      return 400;
    }
    $list = array_map(function ($item) {
      return new TodoModel($item);
    }, (array)$list);
    return array(
      "rows" => $list,
      "total" => (int)$total,
    );
  });
});
