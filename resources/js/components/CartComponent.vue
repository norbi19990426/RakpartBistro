<template>
<div class="container">
    <div class="row pb-2">
            <div class="col-2"></div>
            <div class="col-2">Étel</div>
            <div class="col-2">Étel ár</div>
            <div class="col-2 pl-5">Darab</div>
            <div class="col-2">Összérték</div>
            <div class="col-2"></div>
    </div>
    <div v-for="foodItem in cartFood" :key="foodItem.id" >
        <cart-item-component  :food="JSON.stringify(foodItem)"></cart-item-component>
    </div>
    <div class="d-flex justify-content-end" >
        Totalprice: {{ totalPrice }}
    </div>
</div>
</template>
<script>
export default {
    props: ['cart'],
    data(){
        this.cart = JSON.parse(this.cart);
        return {
            cartFood: this.cart,
            totalPrice: 0
        }
    },
}
</script>
