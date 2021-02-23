<template>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-5 bestFood">
            <div  v-for="food in allFood" :key="food.id" v-if="foodId == food.id" >
               <!-- <img :src="('storage/'+food.image)">-->
            </div>
            <img class="menuRecommender" src="/logo/RakpartAjánlóTábla.jpg">
        </div>
        <div class="col-1"></div>
        <div class="col-5">
            <img class="menuRecommender" src="/logo/RakpartAjánlóTábla.jpg">
        </div>
    </div>
</template>
<script>
export default {
    props:['foods', 'rates'],
    data(){
        this.allFood = JSON.parse(this.foods);
        return{
            foodId: 0,
            bestRate: 0
        }
    },
    beforeMount(){
        this.getBestFood();
    },
    methods:{
        getBestFood(){
            axios.get('/getBestFood')
                .then(response => {
                    response.data.forEach(dataElement => {
                        this.foodId = dataElement.food_id;
                        this.bestRate = dataElement.bestRating;
                    });
            });
        }
    }
}
</script>
<style>
.menuRecommender{
    width: 80%;
    max-height: 100vh;
    margin: auto;

}
</style>
