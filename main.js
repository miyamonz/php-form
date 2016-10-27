inputs = [
{ "value": "person_name",      "text": "お名前",                                       "must": true   },
{ "value": "person_furigana",  "text": "ふりがな",                                     "must": true   },
{ "value": "email1",           "text": "メールアドレス",                               "must": true   },
{ "value": "email2",           "text": "メールアドレス（確認）",                       "must": true   },
{ "value": "company_name",     "text": "会社名",                                       "must": true   },
{ "value": "company_pos",      "text": "役職",                                         "must": false },
{ "value": "company_business", "text": "業種",                                         "must": false },
{ "value": "job_category",     "text": "職種",                                         "must": false },
{ "value": "zip1",             "text": "郵便番号",                                     "must": true   },
{ "value": "zip2",             "text": "郵便番号",                                     "must": true   },
{ "value": "prefecture",       "text": "都道府県",                                     "must": true   },
{ "value": "city",             "text": "市区町村",                                     "must": true   },
{ "value": "address1",         "text": "住所1(番地)",                                  "must": true   },
{ "value": "address2",         "text": "住所2(建物名)",                                "must": false },
{ "value": "phone_number",     "text": "電話番号",                                     "must": true   },
{ "value": "fax_number",       "text": "FAX番号",                                      "must": false },
{ "value": "about",            "text": "お問い合わせ項目",                             "must": true   },
{ "value": "naiyou",           "text": "お問い合わせ内容",                             "must": true   },
{ "value": "know[]",           "text": "このサイトをどちらでお知りになられましたか？", "must": false },
{ "value": "know_sonota",      "text": "",                                             "must": false },
  ];

function Input(param) {
  this.value   = param.value;
  this.text    = param.text;
  this.must    = param.must;
  this.errText = "";
  this.ok      = !this.must;
  this.$       = $("*[name='"+this.value+"']");

  //{func,errText}
  this.validations = [];
  this.checkValidation = function (val){
    for(var i=0; i<this.validations.length; i++){
      if(this.validations[i].func(val) == false ) {
        this.errText = this.validations[i].errText;
        return false;
      }
    }
    return true;
  }
  this.setErrText = function(){
    var result = this.checkValidation(this.$.val());
    var $alert =this.$.next(".alert"); 
    if(!result) $alert.text(this.errText);
    else $alert.text("");
    this.ok = (result);
  }
};

var inputList = [];
inputs.forEach(function(row){
  inputList.push(new Input(row));
})

function getByValue(val){
  for(var i=0; i<inputList.length; i++){
    if(inputList[i].value == val) return inputList[i];
  }
}
//Validation---------------------------------------------------------------------
//未入力判定をまとめて
inputList.forEach(function(row){
  if(row.must == false) return;
  var func = function(val) {return val !== ""};
  if(row.value == "zip1") return;
  row.validations.push({"errText": "未入力です", "func":func});
})

function addValidation(val,errText, func){
  inputList.forEach(function(row){
    if(val !== row.value) return;
    var valid = {"func":func, "errText": errText};
    row.validations.push(valid);
  })
}

addValidation("person_furigana","ひらがなを入力して下さい", function(val){
  if (val.match(/^[\u3040-\u309F]+$/)) return true;
  else  return false;
});
addValidation("email1", "メールアドレスが正しくありません", function(val){
  var pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  if(val.match(pattern)) return true;
  else return false;
});
addValidation("email2", "メールアドレスが一致しません", function(val){
  var $email1 = $('*[name=email1]');
  if($email1.val() == val) return true;
  else return false;
});
addValidation("zip2", "郵便番号が正しくありません", function(val){
  zip = $('*[name=zip1]').val()+val;
  //csvファイルから取ってくる
  getByZip(zip);
  return true;
});
addValidation("prefecture", "郵便番号と一致しません", function(val){
  if(address.region == val) return true;
  else return false;
});
addValidation("city", "郵便番号と一致しません", function(val){
  if(address.city == val) return true;
  else return false;
});
addValidation("address1", "郵便番号と一致しません", function(val){
  var atama = val.substr(0, address.address1.length);
  if(address.address1 == atama) return true;
  else return false;
});
addValidation("address1", "住所が不足しています", function(val){
  if(address.address1.length < val.length) return true;
  else if(address.address1.length == val.length) return false;
  else return true;
});
function isPhoneNumber(val){
  if(/^0\d{1,4}-\d{1,4}-\d{4}$/.test(val)) {
    var nums = val.split("-");
    var naigaiLength = nums[0].length + nums[1].length;
    if(naigaiLength == 6){
      //固定
      $(this).attr("ok",true).next('.alert').text("");
    } else if(naigaiLength == 7) {
      //携帯
      if(/^0[1-9]0/.test(nums[0]) )return true;
      else return false;
    }
    else return false;
  }else return false;
}
addValidation("phone_number", "電話番号が正しくありません", function(val){
  return isPhoneNumber(val);
})
addValidation("fax_number", "電話番号が正しくありません", function(val){
  if(val == "") return true;
  return isPhoneNumber(val);
})

//about はvalue = kakakuが入っているのでちぇっくを入れればOK

//validation 終わり---------------------------------------------------

//アラート表示するspanを入れる
inputs.forEach(function(row){
  var a      = '*[name="'+row.value+'"]';
  var $input = $('*[name="'+row.value+'"]');
  $input.after('<span class="alert"></span>')
    .attr("ok", false);
  if(!row.must) $input.attr("ok", true);

})

var eventList = 'keyup focusout';
inputList.forEach(function(row){
  row.$.on(eventList, function(){
    row.setErrText();
  })
  if(row.value == 'zip2'){
    row.$.on("focusout",function(){
      getByValue('prefecture').setErrText();
      getByValue('city').setErrText();
      getByValue('address1').setErrText();
    })
  }
})


//button 
function isInputOk() {
  for(var i=0; i<inputList.length; i++){
    if(inputList[i].ok == false) return false;
  }
  return true;
}
$('#sendButton').attr('disabled', !isInputOk());
$('body').on(eventList, function(){
  $('#sendButton').attr('disabled', !isInputOk());

})
