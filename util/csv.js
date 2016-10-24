// CSV形式のファイルを読み込み

var address = {
  region: "",
  city: "",
  address1: "",
  address2: ""
};
function getByZip(zip){
  var top = zip.substr(0,1);
  var re;
  $.ajax({
    url: 'util/csvfile/'+top+'.CSV',
    type:     'get',
    dataType: 'text',     // CSV形式のデータを受信
    cache:    false,
    success: function(csv){ 
      var rows = csv.split("\n");
      // var rows = $.csv()(csv);    // CSVを配列に変換
      for(var i=0; i<rows.length; i++){
        var arr = rows[i].split(',');
        if(arr[2] == zip) {
          address.region  = arr[6];
          address.city    = arr[7];
          address.address1 = arr[8];
          address.address2 = arr[9];
          break;
        }
        if(i == rows.length-1) address = {};
      }
    }
  });
}
