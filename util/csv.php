<?php

function findZip($zip) {
  $zip = preg_replace('/\A(\d{3,3})-(\d{4,4})\z/', '$1$2',$zip);
  if(!preg_match('/\A\d{7,7}\z/',$zip)) return false;

  $top = substr($zip, 0, 1);
  $file = new SplFileObject(__DIR__."/csvfile/".$top.".CSV");
  $file->setFlags(SplFileObject::READ_CSV);
  foreach($file as $line){
    if($zip == $line[2]) return true;
    // if($zip > $line[2]) return false;
  }
  return false;
}

// echo var_dump(findZip("6068261"));
function getByZip($zip) {
  $zip = preg_replace('/\A(\d{3,3})-(\d{4,4})\z/', '$1$2',$zip);
  if(!preg_match('/\A\d{7,7}\z/',$zip)) return false;

  $top = substr($zip, 0, 1);
  $file = new SplFileObject(__DIR__."/csvfile/".$top.".CSV");
  $file->setFlags(SplFileObject::READ_CSV);
  foreach($file as $line){
    if($zip == $line[2]) {  
      return $line;
    }
    // if($zip > $line[2]) return false;
  }
  return false;
}

// $line = getByZip("6068261");
// print_r($line);
