<template>
    <div class="menuRecommenderContainer">
        <div class="row menuRecommenderBorder"  v-for="food in allFood" :key="food.id" v-if="foodId == food.id" >
            <div class="col-lg-6 col-md-12">
                <div class="card customer">
                        <div class="card-header customerHeader">
                        <h1 class="customerHONE">Vendégajánló</h1>
                    </div>
                    <div class="row card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h1 class="customerHONE">{{food.foodName}}</h1>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-12">
                                <img class="imgClass" :src="('storage/'+food.image)">
                            </div>

                                <div class="col-xl-9 col-lg-8 col-md-9 col-sm-9 col-12 foodDescription">
                                <div class="row">
                                     <div class="col-xl-8 col-lg-8 col-md-9 col-sm-9 col-12">
                                    <p class="card-text">{{food.description}}</p>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-12">
                                        <p >{{food.price}} HUF</p>
                                    </div>
                                </div>
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
            <div class="col-lg-6 col-md-12">
                <div class="card customer">
                        <div class="card-header customerHeader">
                        <h1 class="customerHONE">Séfajánló</h1>
                    </div>
                    <div class="row card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h1 class="customerHONE">{{food.foodName}}</h1>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-12">
                                <img class="imgClass" :src="('storage/'+food.image)">
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-9 col-sm-9 col-12 foodDescription">
                               <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-9 col-sm-9 col-12">
                                        <p class="card-text">{{food.description}}</p>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-12">
                                        <p>{{food.price}} HUF</p>
                                    </div>
                               </div>
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
<style>
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
}
.imgClass{
    width: 100%;
    height: auto;
    margin-bottom: 10px;
}
.customerHeader{
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid rgba(225,198,153);
}
.customerHONE{
    font-size:2.5vw;
}
.foodDescription{
    font-size:1vw;
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
    background-size: 100% auto;
    background-repeat: no-repeat;
    cursor: pointer;
    overflow: hidden;
    padding: 15px 19px;
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
@media screen and (max-width: 470px) {
  .star {
    display: none;
  }
}
@media screen and (max-width: 576px) {
  .customerHONE {
    font-size:4vw;
    display: flex;
    justify-content: center;
  }
  .imgClass{
    width: 100px;
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
  }
  .foodDescription{
    font-size:2vw;
  }
}
</style>
