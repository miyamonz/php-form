<?php

//郵便局のKEN_ALL.CSVファイルを郵便番号の先頭数字でファイルを分ける
//ファイルをutf-8に変換しておくと良いが、元はエンコードがlatin1だがunkown-8bitだか
//nkfコマンドで変換した

function splitCsvFle(){
  echo "split start";
  $file = new SplFileObject(__DIR__."/KEN_ALL.CSV");
  $file->setFlags(SplFileObject::READ_CSV);

  $files = [];
  for($i=0; $i<10; $i++){
    $filename = __DIR__.$i.".CSV";
    if(!file_exists($filename)) touch($i."CSV");
    $files[$i] = new SplFileObject(__DIR__."/".$i.".CSV",'w');
    $files[$i]->fwrite("");
  }

  foreach($file as $line){
    $top = substr($line[2],0,1);
    $files[$top]->fputcsv($line);
  }
  echo "split end";
}

splitCsvFle();
