<?php
//index.php
$company_pos = [
  ["value"=> "not_select",      "text" => "(未選択)"],
  ["value"=> "management",      "text" => "経営者、役員"],
  ["value"=> "general_manager", "text" => "部長"],
  ["value"=> "manager",         "text" => "課長"],
  ["value"=> "chief",           "text" => "係長"],
  ["value"=> "general_staff",   "text" => "一般社員"],
  ["value"=> "other",           "text" => "その他"],
];
$company_business = [
  ["value"=> "not_select", "text" => "(未選択)"],
  ["value"=> "trading",    "text" => "商社"],
  ["value"=> "retail",     "text" => "小売"],
  ["value"=> "school",     "text" => "大学、学校"],
  ["value"=> "food",       "text" => "食品"],
  ["value"=> "electric",   "text" => "電機"],
  ["value"=> "other",      "text" => "その他"],
];
$job_category = [
  ["value"=> "not_select", "text" => "(未選択)"],
  ["value"=> "management", "text" => "経営"],
  ["value"=> "design",     "text" => "設計"],
  ["value"=> "technology", "text" => "技術"],
  ["value"=> "manufactur", "text" => "製造"],
  ["value"=> "sales",      "text" => "営業"],
  ["value"=> "student",    "text" => "学生"],
  ["value"=> "other",      "text" => "その他"],
];
$aboutVals = [
  ["value" => "kakaku",  "text" => "価格、納期に関するご質問" ],
  ["value" => "gijutsu", "text" => "技術的な質問" ],
  ["value" => "sonota", "text" => "その他のご質問" ],
];
function getAboutText($val) {
  global $aboutVals;
  $vals = array_column($aboutVals, "value");
  $findid = array_search($val, $vals);
  if($findid === false) return false;
  return $aboutVals[$findid]["text"];
}

$kikkakeKoumoku = [
  ["value"=>"search",  "text"=>"サーチエンジン"],
  ["value"=>"another", "text"=>"他のサイトからのリンク"],
  ["value"=>"shinbun", "text"=>"新聞広告"],
  ["value"=>"zasshi",  "text"=>"雑誌広告"],
  ["value"=>"sonota",  "text"=>"その他"],
];
function getKikkakeText($val) {
  global $kikkakeKoumoku;
  $vals = array_column($kikkakeKoumoku, "value");
  $findid = array_search($val, $vals);
  if($findid === false) return false;
  return $kikkakeKoumoku[$findid]["text"];
}

$correctValues = [
["value" => "person_name",     "text" => "お名前", "must"                                     => true ],
["value" => "person_furigana", "text" => "ふりがな", "must"                                   => true ],
["value" => "email1",          "text" => "メールアドレス", "must"                             => true ],
["value" => "email2",          "text" => "メールアドレス（確認）", "must"                     => true ],
["value" => "company_name",    "text" => "会社名", "must"                                     => true ],
["value" => "company_pos",     "text" => "役職", "must"                                       => false ],
["value" => "company_business","text" => "業種", "must"                                       => false ],
["value" => "job_category",    "text" => "職種", "must"                                       => false ],
["value" => "zip1",            "text" => "郵便番号", "must"                                   => true ],
["value" => "zip2",            "text" => "郵便番号", "must"                                   => true ],
["value" => "prefecture",      "text" => "都道府県", "must"                                   => true ],
["value" => "city",            "text" => "市区町村", "must"                                   => true ],
["value" => "address1",        "text" => "住所1(番地)", "must"                                => true ],
["value" => "address2",        "text" => "住所2(建物名)", "must"                              => false ],
["value" => "phone_number",    "text" => "電話番号", "must"                                   => true ],
["value" => "fax_number",      "text" => "FAX番号", "must"                                    => false ],

["value" => "about",           "text" => "お問い合わせ項目", "must"                           => true ],
["value" => "naiyou",          "text" => "お問い合わせ内容", "must"                           => true ],

["value" => "know",            "text" => "このサイトをどちらでお知りになられましたか？", "must" => false ] ,
["value" => "know_sonota",     "text" => "", "must"                                     => false ],
];
