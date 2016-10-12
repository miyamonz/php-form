<?php
echo "<pre>";
// echo var_dump($_POST);
echo "</pre>";


function checkPost($p) {
  $correctKeys = [
    "person_name",
    "person_furigana",
  ];
  echo var_dump($p);
  foreach ($correctKeys as $ckey) {
    if (!(isset($p[$ckey]))) return false;
  }
  return true;
} 

//値が入って無くてもstring ""なのでtrue
echo var_dump(checkPost($_POST));
