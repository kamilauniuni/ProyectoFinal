

const cartIcon = document.getElementById('cart-icon');
const cartCount = document.getElementById('cart-count');
const cartItems = document.getElementById('cart-items');
const cartTotal = document.getElementById('cart-total');
const cartModal = document.getElementById('cart-modal');
const closeModalButton = document.querySelector('.close-modal');
const checkoutButton = document.getElementById('checkout-button');

// Almacenamiento del carrito (puedes usar localStorage o una base de datos)
let cart = {};

// Función para agregar artículos al carrito
function addToCart(productId) {
  if (cart[productId]) {
    cart[productId]++;
  } else {
    cart[productId] = 1;
  }
  updateCartCount();
  // Puedes agregar un artículo a la visualización del carrito aquí
}

// Función para actualizar la cuenta del carrito
function updateCartCount() {
  let totalItems = 0;
  for (const productId in cart) {
    totalItems += cart[productId];
  }
  cartCount.textContent = totalItems;
}

// Función para abrir el modal del carrito
function openCartModal() {
  // Actualizar la visualización de los artículos del carrito en el modal
  cartItems.innerHTML = ''; // Limpiar artículos anteriores
  let totalPrice = 0;
  for (const productId in cart) {
    const product = document.querySelector(`.product[data-product-id="${productId}"]`);
    if (product) {
      const productName = product.querySelector('h2').textContent;
      const productPrice = parseFloat(product.querySelector('.price').textContent.replace('$', ''));
      totalPrice += productPrice * cart[productId];
      cartItems.innerHTML += `
        <div class="cart-item">
          ${productName} x ${cart[productId]} - $${(productPrice * cart[productId]).toFixed(2)}
        </div>
      `;
    }
  }
  cartTotal.textContent = '$' + totalPrice.toFixed(2);
  cartModal.style.display = 'block';
}

// Función para cerrar el modal del carrito
function closeCartModal() {
  cartModal.style.display = 'none';
}

// Event listeners
cartIcon.addEventListener('click', openCartModal);
closeModalButton.addEventListener('click', closeCartModal);
checkoutButton.addEventListener('click', () => {
  // Manejar la lógica de pago (por ejemplo, enviar datos de pedido a un servidor)
  console.log("¡Botón de pago clicado!");
});

// Agregar event listeners a los botones de "Agregar al Carrito"
const addToCartButtons = document.querySelectorAll('.add-to-cart');
addToCartButtons.forEach(button => {
  button.addEventListener('click', () => {
    const productId = button.closest('.product').dataset.productId;
    addToCart(productId);
  });
});

//darra de categorias
document.body.addEventListener('click', function(event) {
if (event.target.matches('.add-to-cart')) {
const productId = event.target.closest('.product').dataset.productId;
addToCart(productId);
}
});



