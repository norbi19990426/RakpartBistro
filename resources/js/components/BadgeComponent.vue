<template>
    <div>
                <img src="/logo/kosarLogo.png" style="height: 25px;">
                <span class='badge badge-warning'>{{badgeCount}} </span>
    </div>
</template>
<script>

import { mapState } from 'vuex'
export default {
    props: ['cart'],
    data(){
        this.cartItem = JSON.parse(this.cart);
        return{
            count: 0
        }
    },
   computed: mapState({
         badgeCount: state => state.count.badgeCount
    }),

    created(){
        this.userLog();
    },
    methods:{
        userLog(){
            if(this.cartItem === null || this.cartItem === []){
                this.$store.commit("userLog",0);
                return;
            }
                let keys = Object.keys(this.cartItem);
                keys.forEach(key => {
                let item = this.cartItem[key];
                    this.count += item.quantity;
                });
            this.$store.commit("userLog",this.count);
        }
    }
}
</script>
