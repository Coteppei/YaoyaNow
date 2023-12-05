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

// 購入数の選択
// -ボタンを押すと数字が減る(最小1まで)
function decreaseCount(vegetableID) {
  const countElement = document.getElementById('buyCount_' + vegetableID);      // 
  const countInput = document.getElementById('buyCountInput_' + vegetableID);
  const maxCount = 1;

  let count = parseInt(countElement.innerText);
  if (count > maxCount) {
    count--;
    countElement.innerText = count;
    countInput.value = count;
  }
}

// +ボタンを押すと数字が増える(最大9まで)
function increaseCount(vegetableID, stockQuantity) {
  const countElement = document.getElementById('buyCount_' + vegetableID);
  const countInput = document.getElementById('buyCountInput_' + vegetableID);
  const maxCount = 9;

  let count = parseInt(countElement.innerText);
  if (count < stockQuantity && count < maxCount) {
    count++;
    countElement.innerText = count;
    countInput.value = count;
  }
}

// カート画面のみ+ボタンを押すと購入数に表示されている数字まで増える
function deleteIncreaseCount(vegetableID) {
  const countElement = document.getElementById('buyCount_' + vegetableID);
  const countInput = document.getElementById('buyCountInput_' + vegetableID);
  const orderQuantityInput = document.getElementById('orderQuantity_' + vegetableID);

  let count = parseInt(countElement.innerText);
  const orderQuantity = parseInt(orderQuantityInput.value);
  if (count < orderQuantity) {
    count++;
    countElement.innerText = count;
    countInput.value = count;
  }
}
