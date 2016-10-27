<?php
session_start();
require_once(__DIR__ . "/"."util/util.php");
require_once(__DIR__ . "/"."util/checkForm.php");

//正しいpostがissetがすべてはいってればtrue
//ただし、空文字もissetされている
function checkPost($p) {
  global $correctValues;
  foreach ($correctValues as $row) {
      $value=$row["value"];
    if (!(isset( $p[$value] ))) return false;
  }
  return true;
} 

//関係ないpostがあるのもチェック
function hasAnotherKey($p){
  global $correctValues;
  $cvals = array_column($correctValues,"value");
  $akeys = [];
  foreach ($p as $key => $value) {
    // echo $key, $value, PHP_EOL;
    if(!in_array($key, $cvals)) return true;
  }
  return false;
}

//escape
$_POST = es($_POST);
// postの値からerrorを抽出
//checked = [ value must isError errText ]
$checked = setError($_POST);

$_SESSION['rows'] = $checked;

//errorじゃないものは削る
function stripError($rows) {
  $r = [];
  foreach ($rows as $row) {
    if($row['isError']) $r[] = $row;
  }
  return $r;
}
$stripErrors = stripError($checked);

$isError = false;
if(count($stripErrors) > 0 ) $isError = true;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <?php if($isError) { ?>
  <p>以下の場所にエラーがありました。</p>
  <?php tableEcho($stripErrors,"text", "errText"); ?>
  <a href="" onclick="history.back()">戻る</a>
  <?php }else{ ?>
  <?php tableEcho($checked,"text", "postText" ); ?>
  <hr>
  <p>以上の内容で送信します。よろしいですか？</p>
  <a href="" onclick="history.back()">戻る</a>
  <a href="sendToDb.php" >送信</a>
  
  <?php } ?>
  
</body>
</html>
