<template>
    <div class="menuRecommenderContainer">
        <div class="row menuRecommenderBorder"  v-for="food in allFood" :key="food.id" v-if="foodId == food.id" >
            <div class="col-lg-6 col-md-6">
                <div class="card customer">
                    <div class="card-header customerHeader">
                        <h1>Vendégajánló</h1>
                    </div>
                    <div class="container">
                        <div class="row foodHeader">
                            <h1>{{food.foodName}}</h1>
                            <food-avg-component :food-id="food.id" class="star"></food-avg-component>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="foodDescription">{{food.description}}</div>
                                    </div>
                                <div class="row foodPrice">
                                    <div>{{food.price}} HUF</div>
                                </div>
                            </div>
                            <div class="col-5">
                                <img class="imgClass" :src="('storage/'+food.image)">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer customerFooter">
                        <a :href="menuRoute" type="button" class="buttonBackground">Menü</a>
                        <add-to-cart-component
                            :food-id="(food.id)"
                            :user-id="(userId)">
                        </add-to-cart-component>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card customer">
                    <div class="card-header customerHeader">
                        <h1>Séfajánló</h1>
                    </div>
                    <div class="container">
                        <div class="row foodHeader">
                            <h1>{{food.foodName}}</h1>
                            <food-avg-component :food-id="food.id" class="star"></food-avg-component>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="row">
                                    <div class="foodDescription">{{food.description}}</div>
                                    </div>
                                <div class="row foodPrice">
                                    <div>{{food.price}} HUF</div>
                                </div>
                            </div>
                            <div class="col-5">
                                <img class="imgClass" :src="('storage/'+food.image)">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer customerFooter">
                        <a :href="menuRoute" type="button" class="buttonBackground">Menü</a>
                        <add-to-cart-component
                            :food-id="(food.id)"
                            :user-id="(userId)">
                        </add-to-cart-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['foods', 'rates', 'userId', 'menuRoute'],
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
<style scoped>
.menuRecommenderContainer{
    background-image: url("/logo/darkBrownBoard.jpeg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-radius: 30px;

}
.menuRecommenderBorder{
    border: 100px solid transparent;
    border-image: url("/logo/ropeBorder.png") 33% round;
}
.customer{
    background-color: rgba(225,198,153,0.5);
    color: white;
    margin-top: 10px;
    margin-left: 60px;
    width: 80%;
}
.imgClass{
    width: 100%;
    border-radius: 10%;
    margin-bottom: 10%;
}
.customerHeader{
    display: flex;
    justify-content: center;
    border-bottom: 1px solid rgba(225,198,153);
}
.foodHeader{
    display: flex;
    justify-content: space-between;
    padding: 10px;
}
h1{
    font-size:2.5vw;
}
.foodDescription{
    font-size: 1vw;
    margin: 10px;
    max-width:250px;
    width: 100%;
    word-wrap:break-word;
}
.foodPrice{
    font-size:1vw;
    display: flex;
    justify-content: flex-end;
}
.customerFooter{
    border-top: 1px solid rgba(225,198,153);
    display: flex;
    justify-content: space-between;
}
.buttonBackground{
    background-image: url("/logo/menuLink.png");
    background-size: 100% auto;
    background-repeat: no-repeat;
    cursor: pointer;
    overflow: hidden;
    padding: 15px 19px;
    font-size:1vw;
    text-align: center;
    color: white;
}
.buttonBackground:hover{
    color: white;
    text-decoration: none;
    transform: scale(1.2);
}
.buttonBackground:active{
    transform: scale(0.8);
}
@media screen and (max-width: 765px) {
  .foodDescription {
    font-size:1.5vw;
  }
  .foodPrice{
    font-size:1.5vw;
  }
}
@media screen and (max-width: 600px) {
  .foodDescription {
    font-size:1.2vw;
  }
  .foodPrice{
    font-size:1.2vw;
  }
}
@media screen and (max-width: 520px) {
  .foodDescription {
    font-size:1.1vw;
  }
  .foodPrice{
    font-size:1.1vw;
  }
  .star{
      display: none;
  }
  .customer{
    width: 100%;
    margin: 10px 0px 0px 0px;
  }
}
</style>
