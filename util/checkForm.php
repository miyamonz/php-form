<?php
require_once(__DIR__."/"."var.php");
require_once(__DIR__."/"."util.php");


// $errors = [ "value"=>"person_furigana", "isError"=>true, "errorText"=>[
//"値は◯◯でお願いします" 
//] ]
// errText は配列を許す
function isWritten($p, &$errors) {
  global $correctValues;
  $r = true;
  foreach ($correctValues as $row) {
    $value = $row["value"];
    $must  = $row["must"];
    $num = findRow($errors, "value", $value);
    $errors[$num]["isError"] = false;
    if($must && $p[$value] == "") {
      // echo $value , " is (0) string", PHP_EOL;
      $errors[$num]["isError"] = true;
      $errors[$num]["errText"] = "未記入です";
      $r = false;
    }
  }
  //全て記入されていればtrue
  return $r;
}

//value must isError errText
function setError($p) {
  global $correctValues;

  $result = $correctValues;

  //必須項目の未記入チェック
  // $isAllWritten =  isWritten($p, $result);
  isWritten($p, $result);

  //resultに対して、記入されたpost,確認表示のためのpostTextを入れる
  foreach ($result as &$row) {
    if($row['value'] == 'know_sonota') continue;//know_sonotaは列として表示しない
    
    $row['post']     = $p[$row['value']];
    $row['postText'] = $p[$row['value']];
    //チェック項目及び配列の値は表示用に加工
    if($row['value'] == 'about') $row['postText'] = getAboutText($p[$row['value']]);
    if($row['value'] == 'know') {
      $values = $p[$row['value']];
      $texts = array_map("getKikkakeText", $values);
      if(($key = array_search("その他", $texts)) !== false) {
        $texts[$key] .= "(".$p['know_sonota'].")";
        if($p['know_sonota'] === '') unset($texts[$key]);
      }
      $row['postText'] = implode(",", $texts );
    }
  }

  //[ ] ふりがなはひらがな
  if(!isHiragana($p["person_furigana"])) {
    $row = &getRow($result, "value","person_furigana");
    $row["isError"] = true;
    $row["errText"] = "ふりがなは全角ひらがなでお願いします";
  }

  //[ ] メールアドレスは正しいか
  if(is_valid_email($p["email1"])){
    //[ ] mail1,2 は同じか
    if($p["email1"] != $p["email2"]) {
      $row = &getRow($result, "value","email2");
    $row["isError"] = true;
      $row["errText"] = "メールアドレスが一致しません";
    }
    
  }else{
    $row = &getRow($result, "value","email1");
    $row["isError"] = true;
    $row["errText"] = "メールアドレスが正しくありません";
  }

  //[ ] 郵便番号の数字は正しいか
  // echo $p['zip1']," ", $p['zip2'];
  $zip1Wrong = !ctype_digit($p['zip1']) || strlen($p['zip1']) != 3;
  $zip1Wrong = !preg_match('/\A\d{3,3}\z/',$p['zip1']);
  $zip2Wrong = !ctype_digit($p['zip2']) || strlen($p['zip2']) != 4;
  $zip2Wrong = !preg_match('/\A\d{4,4}\z/',$p['zip2']);

  if($zip1Wrong || $zip2Wrong){
    $row = &getRow($result, "value","zip2");
    $row["isError"] = true;
    $row["errText"] = "郵便番号が正しくありません";
  }

  $zipFound = getByZip($p['zip1'].$p['zip2']);
  //郵便番号
  if($zipFound === false) {
    $row = &getRow($result, "value","zip2");
    $row["isError"] = true;
    $row["errText"] = "郵便番号が存在しません";
  }else {
    //[ ] 郵便番号と、住所が正しいか
    $getAddress = [ $zipFound[6],     $zipFound[7], $zipFound[8] ];
    $pAddress   = [ $p['prefecture'], $p['city'], $p['address1'] ];
    $equalPref = $getAddress[0] == $pAddress[0];
    $equalCity = $getAddress[1] == $pAddress[1];

    $length = mb_strlen($getAddress[2]);
    $equalAddr = ($getAddress[2] == mb_substr($pAddress[2], 0, $length));
    echo "<pre>";
    echo "</pre>";
    if(!$equalPref || !$equalCity || !$equalAddr) {
      $row = &getRow($result, "value","zip2");
      $row["isError"] = true;
      $row["errText"] = "郵便番号と住所が一致しません";
    }
  }
  
  //[ ] 電話番号,faxの数字は正しいか
  $isPhoneWrong = !isPhoneNumber($p['phone_number']);
  $isFaxWrong   = !isPhoneNumber($p['fax_number']);
  if($isPhoneWrong) {
    $row = &getRow($result, "value","phone_number");
    $row["isError"] = true;
    $row["errText"] = "電話番号が正しくありません。ハイフンは込みでお願いします。";
  }
  if(($p['fax_number'] !== "") && $isFaxWrong) {
    $row = &getRow($result, "value","fax_number");
    $row["isError"] = true;
    $row["errText"] = "FAX番号が正しくありません。ハイフンは込みでお願いします。";
  }
  //お問合わせ項目は正しいか
  $correctAboutVals = array_column($aboutVals, "value");
  if(in_array($p["about"], $correctAboutVals, true)){
    $row = &getRow($result, "value","about");
    $row["isError"] = true;
    $row["errText"] = "お問い合わせ項目を選択して下さい";
  }
  
  return $result;
}

