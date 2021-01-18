<template>
    <div class="app">

        <!--<cart-component @total-price="price"></cart-component>-->
    </div>
</template>

<script>
import CartComponent from "./CartComponent";
export default {
    comments:{ CartComponent },
    data(){
        return{
            totalPrice: 0
        }
    },
    methods: {
        price: function(params){
            this.totalPrice = params.price;
        }
    }
}
</script>
