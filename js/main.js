function confirmAction(actionMessage) {
  return window.confirm(actionMessage);
}
// ログアウトの最終確認
function checkLogout() {
  return confirmAction('ログアウトしますか？');
}

// カート削除の最終確認
function checkDelete() {
  return confirmAction('対象商品をカートから削除しますか？');
}

// 商品購入の最終確認
function checkPurchase() {
  return confirmAction('商品の購入を確定してよろしいですか。');
}

// アカウント新規登録の最終確認
function checkSignUp() {
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  const email = document.getElementById('email').value;

  const message = `アカウントを作成します。以下の内容でよろしいでしょうか\n\nユーザー名: ${username}\nパスワード: ${password}\nメールアドレス: ${email}`;
  return confirmAction(message);
}

