<?php
session_start();
require_once(__DIR__."/"."util/util.php");
echo "<pre>";

//form は19列ある

if(isset($_SESSION)) {
  $rows = $_SESSION['rows'];
}

function getPostData($valName) {
  global $rows;
  $post =  &getRow($rows,'value',$valName)['post'];
  return $post;
}

//sqlにする前の加工
$dbRow = [
  'person_name'      => getPostData('person_name'     ),
  'person_furigana'  => getPostData('person_furigana' ),
  'email'            => getPostData('email1'          ),
  'company_name'     => getPostData('company_name'    ),
  'company_pos'      => getPostData('company_pos'     ),
  'company_business' => getPostData('company_business'),
  'job_category'     => getPostData('job_category'    ),
];
$dbRow['zip'] = getPostData('zip1') ."-".getPostData('zip2');
$dbRow['prefecture']   = getPostData('prefecture');
$dbRow['city']         = getPostData('city');
$dbRow['address1']     = getPostData('address1');
$dbRow['address2']     = getPostData('address2');
$dbRow['phone_number'] = getPostData('phone_number');
$dbRow['fax_number']   = getPostData('fax_number');
$dbRow['about']        = getPostData('about');
$dbRow['naiyou']       = getPostData('naiyou');
$dbRow['kikkake']      = &getRow($rows,'value', 'know')['postText'];


function sendToDb($rows){
  $keys = array_keys($rows);
  $sql = 'insert into form_receive ';
  $sql .= '(';
  foreach ($keys as $i => $k) {
    $sql .= " ".$k." ";
    if($i < count($keys)-1) $sql .= ", \n";
  }
  $sql .= ' )';
  $sql .= ' values (';
  foreach ($keys as $i => $k) {
    $sql .= " '".$rows[$k]."'";
    if($i < count($keys)-1) $sql .= ", \n";
  }
  $sql .= ' );';

  print_r($sql);
  $pdo = getPdo();
  $sta = $pdo->query($sql);

  return $sta;
}

function getPdo(){
  $user = "testuser";
  $password = "test";
  $dbName = "form";
  $host = "localhost:8889";
  $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

  try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // echo "データベース{$dbName}に接続しました。";
    return $pdo;
  }catch(Exception $e){
    echo "error";
    echo $e->getMessage();
  }
}

//tryで
sendToDb($dbRow);

function getTable($table){
  $pdo = getPdo();
  $sth = $pdo->query("select * from ".$table);

  $rows = [];
  while($row = $sth->fetch(PDO::FETCH_ASSOC)){
    $rows[] = $row;
  }
  return $rows;
}
echo '</pre>';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  送信されました。ありがとうございました。
  <a href="index.php">フォームへ戻る</a>

</body>
</html>
