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
    background-size: 75px;
    background-repeat: no-repeat;
    width: 75px;
    height: 50px;
    cursor: pointer;
    overflow: hidden;
    padding: 15px 0;
    text-align: center;
    color: white;
    text-decoration: none;
}
a:hover{
      transform: scale(1.2);
}
</style>
