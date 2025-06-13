<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
  <style>
    body {
      font-family: sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      border: 1px solid #000;
      padding: 30px;
      width: 300px;
      text-align: center;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
    }
    .error {
      color: red;
      font-size: 0.9em;
      margin-bottom: 10px;
      display: none; /* 初期は非表示 */
    }
    button {
      padding: 5px 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>新規登録</h2>
    <p>IDとパスワードを入力してください</p>
    <form id="registerForm" action="/register" method="post">
      <div>
        <label for="userId">ID</label><br>
        <input type="text" id="userId" name="userId" maxlength="20" required>
      </div>
      <div>
        <label for="password">パスワード</label><br>
        <input type="password" id="password" name="password" maxlength="36" required>
      </div>
      <div>
        <label for="confirmPassword">パスワード（確認用）</label><br>
        <input type="password" id="confirmPassword" name="confirmPassword" maxlength="36" required>
        <div class="error" id="passwordError">※パスワードが一致しません</div>
      </div>
      <button type="submit">登録する</button>
    </form>
  </div>

  <script>
    const form = document.getElementById("registerForm");
    const pwInput = document.getElementById("password");
    const confirmPwInput = document.getElementById("confirmPassword");
    const pwError = document.getElementById("passwordError");

    form.addEventListener("submit", function(event) {
      pwError.style.display = "none";

      if (pwInput.value !== confirmPwInput.value) {
        pwError.style.display = "block";
        event.preventDefault(); // フォーム送信中止
      }
    });
  </script>
</body>
</html>