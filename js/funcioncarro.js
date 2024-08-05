
        document.addEventListener("DOMContentLoaded", () => {
            updateTotals();
        });
        function changeQuantity(item) {
            const quantity = document.getElementById(`cant${item}`).value;
            const price = parseInt(document.getElementById(`price${item}`).innerText);
            const subtotal = quantity * price;
            document.getElementById(`subtotal${item}`).innerText = subtotal;
            updateTotals();
        }
        function removeItem(item) {
            const row = document.querySelector(`tr[data-item="${item}"]`);
            row.remove();
            updateTotals();
        }
        function updateTotals() {
            const subtotals = document.querySelectorAll(".cart-subtotal");
            let total = 0;
            let totalCant = 0;

            subtotals.forEach(subtotal => {
                total += parseInt(subtotal.innerText);
                totalCant += 1;
            });
            document.getElementById("total").innerText = total;
            document.getElementById("totalCant").innerText = totalCant;
            document.getElementById("totalPay").value = total * 100; // Convert to cents
        }
          Swal.fire("eliminado");

          // Assuming we have a product element with ID "product1"
const product1Quantity = document.getElementById("product1-quantity"); 
const product1AddButton = document.getElementById("product1-add"); 

product1AddButton.addEventListener("click", () => {
  // Increase the quantity (make sure to handle maximums)
  product1Quantity.value++; 

  // Send updated quantity to the server (using AJAX)
  // ...

  // Update the cart total visually
  // ...
});
   