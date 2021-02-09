<template>

<div class="container-fluid" >

    <div class="row" v-show="(hideCart)">
        <div class="col-md-8" >
            <div v-for="foodItem in cartFood" :key="foodItem.id">
                <cart-item-component @total-price="getCartItemData" @remove="getRemove" @badgeCount="getQuantity" :user-id="(userId)"
                :food="JSON.stringify(foodItem)"></cart-item-component>
            </div>
        </div>
        <div class="col-md-4">
            <h5>A KOSÁR ÖSSZESEN</h5>
            <p>ÖSSZEG {{totalPrice}}</p>
            <button class="btn btn-primary" @click="checkoutButton">Tovább a pénztárhoz</button>
            <!--<a class="btn btn-primary" v-bind:href="menuRoute">Vissza a menübe</a>-->
        </div>
        <div class="pt-2 pl-2 col-md-8" style="border-top: 1px black solid" >
        </div>
    </div>
    <div v-show="(hideCheckout)">
        <div v-if="hideCart == false">
            <checkout-component @checkout="getCart" :checkout-food-id="JSON.stringify(checkout)"
            :payment-route="(paymentRoute)" :total-price="(totalPrice)" :ordered="(ordered)" :check="(check)"></checkout-component>
        </div>
    </div>
</div>
</template>
<script>
import CartItemComponent from "./CartItemComponent";
import CheckoutComponent from './CheckoutComponent.vue';
export default {
    props: ['cart', 'userId', 'paymentRoute', 'ordered', 'check'],
    components: { CartItemComponent, CheckoutComponent},
    data(){
        this.cartFood = JSON.parse(this.cart);
        return {
            hideCart: true,
            hideCheckout: false,
            totalPrice: 0,
            badgeCount: 0,
            cartItemsData: [],
            cartItemsCount: [],
            checkout: []
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
        checkoutButton(){
            this.hideCart = false;
            this.hideCheckout = true;
        },
        getCart(){
            this.hideCart = true;
            this.hideCheckout = false;
        },
        getCartItemData: function(cartItemData) {
            this.cartItemsData[cartItemData.id] = cartItemData.sub_total;
            this.sumTotalPrice();
        },
        getRemove:function(cartItemData){
            this.cartItemsData[cartItemData.id] = cartItemData.sub_total;
            this.checkout[cartItemData.id] = null;
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
            this.checkout[cartItemCount.id] = [{'id': cartItemCount.id,'foodName': cartItemCount.name, 'qty' : cartItemCount.quantityCount, 'price': cartItemCount.price}]
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
            this.checkout[item.id] = [{'id': item.id,'foodName': item.name, 'qty' : item.quantity, 'price': item.price}];
            this.sumBridgeCount();
            });
        }
    }
}
</script>
