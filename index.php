<?php
session_start();
session_unset();
require_once(__DIR__ . "/"."util/util.php");
//$aboutVals
//$kikkakeKoumoku

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム</title>
  </head>
  <body>
    <form class="h-adr" action="form.php" method="post">
      ※ は必須項目です
      <table>
        <tr><td>名前 ※</td><td><input type="text" name="person_name"></td></tr>
        <tr><td>ふりがな ※</td><td><input type="text" name="person_furigana"></td></tr>
        <tr><td>メールアドレス ※</td><td><input type="text" name="email1"></td></tr>
        <tr><td>メールアドレス(確認) ※</td><td><input type="text" name="email2"></td></tr>
        <tr><td>会社名 ※</td><td><input type="text" name="company_name"></td></tr>
        <tr><td>役職</td>
          <td>
            <select name="company_pos">
              <option value="">...</option>
            </select>
          </td>
        </tr>
        <tr><td>業種</td>
          <td>
            <select name="company_business">
              <option value="">...</option>
            </select>
          </td>
        </tr>
        <tr><td>職種</td>
          <td>
            <select name="job_category">
              <option value="">...</option>
            </select>
          </td>
        </tr>
        <!-- 郵便番号-->
        <input type="hidden" class="p-country-name" value="Japan">
        <tr> 
          <td>郵便番号 ※</td>
          <td>
            <input class="p-postal-code" type="text" size="3" maxlength="3" name="zip1" placeholder="012"> -
            <input class="p-postal-code" type="text" size="4" maxlength="4" name="zip2" placeholder="3456">
          </td>
        </tr>
        <tr><td>都道府県 ※</td><td><input    class="p-region"           type="text" name="prefecture" placeholder=""></td></tr>
        <tr><td>市区町村 ※</td><td><input    class="p-locality"         type="text" name="city"       placeholder=""></td></tr>
        <tr><td>住所1(番地) ※</td><td><input class="p-street-address"   type="text" name="address1"></td></tr>
        <tr><td>住所2(建物名)</td><td><input class="p-extended-address" type="text" name="address2"></td></tr>
        <br>
        <tr><td>電話番号 ※</td><td><input type="text" name="phone_number" placeholder="012-345-6789"></td></tr>
        <tr><td>FAX番号</td><td><input type="text" name="fax_number" placeholder="012-345-6789"></td></tr>
      </table>
      <br>
      <table>
        <ul>
          <li> 
          お問い合わせ項目 ※<br>
          <?php for($i=0; $i<count($aboutVals); $i++){ ?>
          <input type="radio" name="about" value="<?= $aboutVals[$i]["value"]?>"><?= $aboutVals[$i]["text"]?><br>
          <?php } ?>

          </li>
          <li> 
          お問い合わせ内容 ※<br>
          <textarea type="text" name="naiyou" rows="7" cols="50"></textarea>

          </li>
          <li> 
          このサイトをどちらでお知りになられましたか？(複数選択可)<br>
          <?php for($i=0; $i<count($kikkakeKoumoku); $i++){ ?>
          <input type="checkbox" name="know[]" value="<?= $kikkakeKoumoku[$i]["value"]?>"><?= $kikkakeKoumoku[$i]["text"]?>
          <?php if($kikkakeKoumoku[$i]["value"] =="sonota") {?>
          <input type="text" name="know_sonota">
          <?php } ?>
          <br>
          <?php } ?>

          </li>
        </ul>
      </table>
      <button id="sendButton">入力内容を確認</button>
    </form>
    <p>
    <br> 
    <!-- jsでバリデーション<br>                         -->
    <!-- phpでバリデーション<br>                        -->
    <!-- →間違ってたらとめてエラー表示<br>      -->
    <!-- →OKなら「ありがとうございました」<br> -->
    <!-- DB登録<br>                                           -->
    <!-- メール送信<br>                                    -->
    </p>
  </body>

  <script src="./util/jquery-3.1.1.min.js"></script>
  <script src="./util/csv.js"></script>
  <script src="./main.js"></script>
  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
</html>
