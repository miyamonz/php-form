
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム</title>
  </head>
  <body>
    <form action="form.php" method="post">
      ※ は必須項目です
      <ul>
        <li>名前 ※：<input type="text" name="person_name"></li>
        <li>ふりがな ※：<input type="text" name="person_furigana"></li>
        <li>メールアドレス ※：<input type="text" name="email"></li>
        <li>メールアドレス(確認) ※：<input type="text" name="email2"></li>
        <li>会社名 ※ <input type="text" name="company_name"></li>
        <li>役職
          <select name="company_pos">
            <option value="">...</option>
          </select>
        </li>
        <li>業種
          <select name="company_business">
            <option value="">...</option>
          </select>
        </li>
        <li>職種
          <select name="job_category">
            <option value="">...</option>
          </select>
        </li>
        <br>
        <li>
          郵便番号 ※：<input type="text" name="zip" placeholder="012-3456">
          <a href="">郵便番号から住所を入力</a>
        </li>
        <li>
          都道府県 ※：
          <select name="prefecture">
            <option value="">選択して下さい</option>
            <option value="">北海道</option>
            <option value="">...</option>
          </select>
        </li>
        <li>市区町村 ※：<input type="text" name="city" placeholder=""></li>
        <li>住所1(番地) ※：<input type="text" name="address1"></li>
        <li>住所2(建物名)：<input type="text" name="address2"></li>
        <br>
        <li>電話番号 ※：<input type="text" name="phone_number" placeholder="012-345-6789"></li>
        <li>FAX番号：<input type="text" name="fax_number" placeholder="012-345-6789"></li>

        <br>
        <li>
          お問い合わせ項目 ※：<br>
          <input type="radio" name="0">価格、納期などに関するご質問<br>
          <input type="radio" name="1">技術的なご質問<br>
          <input type="radio" name="2">その他のご質問<br>
        </li>
        <li>
          お問い合わせ内容 ※：<br>
          <textarea type="text" name="naiyou" rows="7" cols="50"></textarea>
        </li>
        <li>
          このサイトをどちらでお知りになられましたか？<br>
            <input type="checkbox">サーチエンジン<br>
            <input type="checkbox">他サイトからのリンク<br>
            <input type="checkbox">新聞広告<br>
            <input type="checkbox">雑誌広告<br>
            <input type="checkbox">その他 <input type="text"><br>
        </li>
        <button>入力内容を確認</button>
      </ul>
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
</html>