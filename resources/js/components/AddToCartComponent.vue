<template>
    <div>
        <button type="button" class="btn btn-success pull-right" v-on:click="cartButton">Kosár</button>
    </div>
</template>

<script>
    export default {

        props: ['foodId','userId'],
        methods:{
            cartButton(){
                axios.post('/add-to-cart/' + this.foodId);

                if(this.userId != 0){
                    axios.post('/addToUserCart/' + this.foodId + "/" + this.userId);
                }

                this.$store.commit("cartButton");
            },
        }
    }
</script>
