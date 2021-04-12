<template>
    <div>
        <a type="button" class="buttonBackground" v-on:click="cartButton">Kosár</a>
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
<style scoped>
.buttonBackground{
    background-image: url("/logo/menuLink.png");
    background-size: 100% auto;
    background-repeat: no-repeat;
    cursor: pointer;
    overflow: hidden;
    padding: 15px 19px;
    text-align: center;
    color: white;
    font-size:1vw;
    text-decoration: none;
}
a:hover{
    transform: scale(1.2);
}
a:active{
    transform: scale(0.8);
}
</style>
