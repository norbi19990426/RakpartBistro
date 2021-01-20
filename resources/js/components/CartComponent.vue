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
        <cart-item-component @total-price="getCartItemData" @remove="getRemove" :food="JSON.stringify(foodItem)"></cart-item-component>
    </div>
    <div class="d-flex justify-content-end" >
        <h4>Teljes összeg: {{totalPrice}} HUF</h4>
    </div>
</div>
</template>
<script>
import CartItemComponent from "./CartItemComponent";

export default {
    props: ['cart'],
    components: { CartItemComponent },
    data(){
        this.cart = JSON.parse(this.cart);
        return {
            cartFood: this.cart,
            totalPrice: 0,
            cartItemsData: []
        }
    },
    beforeMount(){
        this.defaultTotalPrice();
    },
    created(){
        this.sumTotalPrice();
        this.defaultTotalPrice();

    },
    methods: {
        getCartItemData: function(cartItemData) {
            this.cartItemsData[cartItemData.id] = cartItemData.sub_total;
            this.sumTotalPrice();
        },
        getRemove:function(cartItemData){
            this.cartItemsData[cartItemData.id] = cartItemData.sub_total;
            this.sumTotalPrice();
        },
        sumTotalPrice(){
            this.totalPrice = 0;
            this.cartItemsData.forEach(cartItemData => {
                this.totalPrice += cartItemData;
            });

        },
        defaultTotalPrice(){
            let keys = Object.keys(this.cartFood);
            keys.forEach(key => {
            let item = this.cartFood[key];
            this.cartItemsData[item.id] = item.price*item.quantity;
                        this.sumTotalPrice();

            });
        },
    }
}
</script>
