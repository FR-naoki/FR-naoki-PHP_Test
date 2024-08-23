<?php

session_start();

header('X-FRAME-OPTIONS:DENY');

// スーパーグローバル変数 php 9種類
// 連想配列
if (!empty($_POST)) {
  echo '<pre>';
  var_dump($_POST);
  echo '</pre>';
}

function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


// 入力、確認、完了 input_7.php, confirm.php, thanks.php
// CSRF 偽物のinput_7.php->悪意のあるページ
// input_7.php

$pageFlag = 0;

if (!empty($_POST['btn_confirm'])) {
  $pageFlag = 1;
}
if (!empty($_POST['btn_submit'])) {
  $pageFlag = 2;
}


?>

<!DOCTYPE html>
<meta charset="utf-8">

<head></head>

<body>


  <?php if ($pageFlag === 1) : ?>
    <?php if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
      <form method="POST" action="input_7.php">
        氏名
        <?php echo h($_POST['your_name']); ?>
        <br>
        メールアドレス
        <?php echo h($_POST['email']); ?>
        <br>

        <input_7 type="submit" name="back" value="戻る">
          <input_7 type="submit" name="btn_submit" value="送信する">
            <input_7 type="hidden" name="your_name" value="<?php echo h($_POST['your_name']); ?>">
              <input_7 type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
                <input_7 type="hidden" name="csrf" value="<?php echo h($_POST['csrf']); ?>">
      </form>

    <?php endif; ?>

  <?php endif; ?>

  <?php if ($pageFlag === 2) : ?>
    <?php if ($_POST['csrf'] === $_SESSION['csrfToken']) : ?>
      送信が完了しました。

      <?php unset($_SESSION['csrfToken']); ?>
    <?php endif; ?>
  <?php endif; ?>


  <?php if ($pageFlag === 0) : ?>
    <?php
    if (!isset($_SESSION['csrfToken'])) {
      $csrfToken = bin2hex(random_bytes(32));
      $_SESSION['csrfToken'] = $csrfToken;
    }
    $token = $_SESSION['csrfToken'];
    ?>

    <form method="POST" action="input_7.php">
      氏名
      <input_7 type="text" name="your_name" value="<?php if (!empty($_POST['your_name'])) {
                                                      echo h($_POST['your_name']);
                                                    } ?>">
        <br>
        メールアドレス
        <input_7 type="email" name="email" value="<?php if (!empty($_POST['email'])) {
                                                    echo h($_POST['email']);
                                                  } ?>">
          <br>
          ホームページ
          <input_7 type="url" name="url" value="<?php if (!empty($_POST['url'])) {
                                                  echo h($_POST['url']);
                                                } ?>">
            <br>
            性別
            <input_7 type="radio" name="gender" value="0">男性
              <input_7 type="radio" name="gender" value="1">女性
                <br>
                年齢
                <select name="age">
                  <option value="">選択してください</option>
                  <option value="1">〜19歳</option>
                  <option value="2">20歳〜29歳</option>
                  <option value="3">30歳〜39歳</option>
                  <option value="4">40歳〜49歳</option>
                  <option value="5">50歳〜59歳</option>
                  <option value="6">60歳〜</option>
                </select>
                <br>
                お問い合わせ内容
                <textarea name="contact">
<?php if (!empty($_POST['contact'])) {
      echo h($_POST['contact']);
    } ?>
</textarea>
                <br>
                <input_7 type="checkbox" name="caution" value="1">注意事項にチェックする
                  <br>

                  <input_7 type="submit" name="btn_confirm" value="確認する">
                    <input_7 type="hidden" name="csrf" value="<?php echo $token; ?>">
    </form>
  <?php endif; ?>

</body>

</html>