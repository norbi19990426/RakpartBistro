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
        <cart-item-component @total-price="getCartItemData" @remove="getRemove" @badgeCount="getQuantity" :user-id="(userId)" :food="JSON.stringify(foodItem)"></cart-item-component>
    </div>
    <div class="d-flex justify-content-end" >
        <h4>Teljes összeg: {{totalPrice}} HUF</h4>
    </div>
</div>

</template>
<script>
import CartItemComponent from "./CartItemComponent";
export default {
    props: ['cart', 'userId', 'user'],
    components: { CartItemComponent },
    data(){
        this.cartFood = JSON.parse(this.cart);
        return {
            totalPrice: 0,
            badgeCount: 0,
            cartItemsData: [],
            cartItemsCount: []

        }
    },
    beforeMount(){
        this.defaultTotalPrice();
        this.defaultTotalCount();
    },
    created(){
        this.sumTotalPrice();
        this.defaultTotalPrice();
        this.sumBridgeCount();
        this.defaultTotalCount();
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
        getQuantity(cartItemCount){
            this.cartItemsCount[cartItemCount.id] =  cartItemCount.quantityCount;
            this.sumBridgeCount();
        },
        sumBridgeCount(){
            this.badgeCount = 0;
            this.cartItemsCount.forEach(cartItemCount =>{
                this.badgeCount += cartItemCount;
            });

            this.$store.commit("sumBridgeCount",this.badgeCount);
        },
        defaultTotalCount(){
            let keys = Object.keys(this.cartFood);
            keys.forEach(key => {
            let item = this.cartFood[key];
            this.cartItemsCount[item.id] = item.quantity;
            this.sumBridgeCount();
            });
        }
    }
}
</script>
