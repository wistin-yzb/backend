<?php
/**
 * Created by PhpStorm.
 * User: huanglintian
 * Date: 2018/11/21
 * Time: 16:18
 */
set_time_limit(30);
$data = $_POST['data'];
if (empty($data)) {
    return;
}

$fileName = 'data.php';
$accessToken = './wechat/access_token.php';
$ticket = './wechat/jsapi_ticket.php';

// 更新数据
if (!file_exists($fileName)) {
    file_put_contents($fileName, '');
}
$content = var_export($data, 1);
$fileContent = <<<ab
<?php
    return {$content};
ab;

$f = fopen($fileName, 'r+');
if (flock($f, LOCK_EX)) {
    ftruncate($f, 0);
    rewind($f); // 必须配合rewind否则写入的json字符串无法解析
    fwrite($f, $fileContent);
    fflush($f); // flush output before releasing the lock
    flock($f, LOCK_UN);
}

fclose($f);

// 更新 公众号 缓存
$f = fopen($accessToken, 'r+');
if (flock($f, LOCK_EX)) {
    ftruncate($f, 0);
    rewind($f); // 必须配合rewind否则写入的json字符串无法解析
    fwrite($f, '<?php exit();?>{"access_token":"","expire_time":0}');
    fflush($f); // flush output before releasing the lock
    flock($f, LOCK_UN);
}
fclose($f);

$f = fopen($ticket, 'r+');
if (flock($f, LOCK_EX)) {
    ftruncate($f, 0);
    rewind($f); // 必须配合rewind否则写入的json字符串无法解析
    fwrite($f, '<?php exit();?>{"jsapi_ticket":"","expire_time":0}');
    fflush($f); // flush output before releasing the lock
    flock($f, LOCK_UN);
}
fclose($f);

// 刷新 opcached 缓存
if (extension_loaded('Zend OPcache')) {
    @opcache_reset();
}
ini_set('opcache.enable', false);
$config = include (__DIR__ . '/' . $fileName);

header('Content-Type:text/json;charset=utf-8');

echo json_encode($data) === json_encode($config) ? json_encode(['error' => 0, 'msg' => '同步成功'])
    : json_encode(['error' => 1, 'msg' => '同步失败']);