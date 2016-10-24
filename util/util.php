<?php
require_once(__DIR__."/"."var.php");
require_once(__DIR__."/"."csv.php");

//func
function findRow($rows, $key,$value) {
  for($i=0; $i<count($rows); $i++){
    if($rows[$i][$key] == $value) return $i;
  };
  return null;
};
function &getRow(&$rows, $key, $value) {
  $i = findRow($rows, $key,$value);
  return $rows[$i];

}

function isHiragana($str) {
return preg_match("/^[ぁ-ゞ]+$/u",$str);
};

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/@\[[^\]]++\]\z/', $email);
}

function isPhoneNumber($str) {
  return preg_match('/\A0\d{1,3}-\d{2,4}-\d{4}\z/',$str);
};

// print_r(isPhoneNumber("092-12-233"));

function tableEcho($rows) {
  $keyNum = func_num_args() - 1;
  echo "<table>";

  for($i=0; $i<count($rows); $i++){
    echo "<tr>";
        // echo "<td>";
        // echo $i; 
        // echo "</td>";
      for($j=0; $j < $keyNum; $j++){
        echo "<td>";
        // echo (func_get_arg($j+1));
        echo $rows[$i][func_get_arg($j+1)];
        echo "</td>";
      }
    echo "</tr>";
  }
  echo "</table>";
}

function postDump($p){
  global $correctValues;
  $errors = setError($p);
  $cvals = array_column($correctValues,"value");
  echo "<table>";
  for($i=0; $i<count($cvals); $i++){
    echo "<tr>";
    $must = $correctValues[$i]["must"];
    $val  = $cvals[$i];
    echo "<td>", "val:",$val,"</td>";
    echo "<td>", "must:",var_dump($must),"</td>";
    echo "<td>", "err ", var_dump($errors[$i]["isError"]);
    echo "</td>";
    echo "<td>", var_dump($p[$val]), "</td>";

    echo "</tr>";
  }
}

// postDump($_POST);
