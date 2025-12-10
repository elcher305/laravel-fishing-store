<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Корзина товаров</title>
  <link rel="stylesheet" href="css/style-basket.css">

</head>
<body>
  <div class="container">
    <div class="header">
      <b class="fas fa-shopping-cart">Корзина</b>
    </div>

    <div class="cart-item">
      <div class="item-info">
        <div class="item-title">Прикормка DUNAEV BLACK Series 1 ит BREAM</div>
        <div class="item-subtitle">Серия Black, для леща, вес: 500г</div>
        <div class="item-details">
          <div class="item-price">230 ₽</div>
          <div class="quantity-control">
            <button class="quantity-btn minus-btn"><img src="img/fi-rr-minus.svg" alt=""></button>
            <input type="text" class="quantity-input" value="1" readonly>
            <button class="quantity-btn plus-btn"><img src="img/fi-rr-plus.svg" alt=""></button>
          </div>
        </div>
      </div>
      <button class="delete-btn">
        <b class="fas fa-trash-alt">Удалить</b>
      </button>
    </div>

    <div class="cart-item">
      <div class="item-info">
        <div class="item-title">Прикормка DUNAEV BLACK Series 1 ит BREAM</div>
        <div class="item-subtitle">Серия Black, для леща, вес: 500г</div>
        <div class="item-details">
          <div class="item-price">230 ₽</div>
          <div class="quantity-control">
            <button class="quantity-btn minus-btn"><img src="img/fi-rr-minus.svg" alt=""></button>
            <input type="text" class="quantity-input" value="1" readonly>
            <button class="quantity-btn plus-btn"><img src="img/fi-rr-plus.svg" alt=""></button>
          </div>
        </div>
      </div>
      <button class="delete-btn">
        <b class="fas fa-trash-alt">Удалить</b>
      </button>
    </div>

    <div class="cart-item">
      <div class="item-info">
        <div class="item-title">Прикормка DUNAEV BLACK Series 1 ит BREAM</div>
        <div class="item-subtitle">Серия Black, для леща, вес: 500г</div>
        <div class="item-details">
          <div class="item-price">230 ₽</div>
          <div class="quantity-control">
            <button class="quantity-btn minus-btn"><img src="img/fi-rr-minus.svg" alt=""></button>
            <input type="text" class="quantity-input" value="1" readonly>
            <button class="quantity-btn plus-btn"><img src="img/fi-rr-plus.svg" alt=""></button>
          </div>
        </div>
      </div>
      <button class="delete-btn">
        <b class="fas fa-trash-alt">Удалить</b>
      </button>
    </div>

    <div class="divider"></div>

    <div class="summary">
      <div class="total">
        <span class="total-label">Стоимость товаров</span>
        <span class="total-price">690 ₽</span>
      </div>

      <a id="btn-summary-pay">Подтвердить</a>

      <div class="conditions">
        Оформляя заказ, вы подтверждаете свое совершеннолетие и соглашаетесь с нашими условиями обработки персональных данных.
      </div>
    </div>
  </div>

  <div class="footer-note">
    <p>Все цены указаны в рублях. Товары в корзине сохраняются 30 дней.</p>
  </div>

</body>
</html>