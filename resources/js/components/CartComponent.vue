<template>
    <div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Food</th>
                <th>price</th>
                <th>qty</th>
                <th>sub total</th>
            </tr>
        </thead>
        <tbody>
            <div v-for="foodItem in cart" :key="foodItem.id">
                <cart-item-component  :food="JSON.stringify(foodItem)"></cart-item-component>
            </div>
          </tbody>
        <tfoot>
            <tr>
              <td colspan="2"></td>
              <td>
                <strong></strong>
              </td>
            </tr>
          </tfoot>
    </table>
</div>
</template>
<script>
export default {
    props: ['cart'],
    data(){
        this.cart = JSON.parse(this.cart);
        return {
            cart: this.cart
        }
    }
}
</script>
