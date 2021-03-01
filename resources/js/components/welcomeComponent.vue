<template>
    <div>
        <div class="row"  v-for="food in allFood" :key="food.id" v-if="foodId == food.id" >
            <div class="col-md-6">
                <div class="card customer">
                    <div class="card-header customerHeader">
                        <h1>Vendégajánló</h1>
                        <avg-rating-component
                            :food-id="(food.id)">
                        </avg-rating-component>
                    </div>
                    <div class="row card-body">
                        <div class="row">
                            <div class="col-12">
                                <h2>{{food.foodName}}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <img class="imgClass" :src="('storage/'+food.image)">
                            </div>

                            <div class="col-md-9 foodDescription" >
                                <div class="col-md-8 col-sm-10">
                                    <p class="card-text">{{food.description}}</p>
                                </div>
                                <div class="col-md-4 col-sm-2">
                                    <p >{{food.price}} HUF</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer customerFooter">
                        <a type="button" class="buttonBackground">Menü</a>
                        <add-to-cart-component
                            :food-id="(food.id)"
                            :user-id="(userId)">
                        </add-to-cart-component>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['foods', 'rates', 'userId'],
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
.customer{
    background-color: rgba(225,198,153,0.5);
    color: white;
}
.imgClass{
    width: 100%;
    height: auto;
    display: flex;
    justify-content: flex-end;
}
.customerHeader{
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid rgba(225,198,153);
}
.foodDescription{
    display: flex;
    justify-content: space-between;
}
.customerFooter{
    border-top: 1px solid rgba(225,198,153);
    display: flex;
    justify-content: space-between;
}
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
</style>
