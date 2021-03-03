<template>
    <div >
        <div v-for="category in allCategory" :key="category.id">
            <h2>{{category.categoryName}}</h2>
            <div class="row">
            <div class="col-md-6" v-for="food in allFood" :key="food.id" v-if="category.id == food.category_id">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <img :src="(storage+food.image)" class="float-left pr-3" >
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title">{{ food.foodName }}</h4>
                                    <avg-rating-component
                                        :food-id="(food.id)">
                                    </avg-rating-component>
                            </div>
                            <div class="row" >
                                <div class="col-9">
                                    <div v-html="food.description"></div>
                                </div>
                                <div class="col-3">
                                    <p >{{food.price}} HUF</p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a type="button" v-show="userId != 0" class="buttonBackground" @click.prevent="show(food.id,food.foodName)">Értékelés</a>
                                <add-to-cart-component
                                    :food-id="(food.id)"
                                    :user-id="(userId)">
                                </add-to-cart-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="user-rate" height="auto">
            <div class="modal-mask">
                <div class="modal-container">
                    <div class="modal-header">
                        <h1>{{foodName}}</h1>
                    </div>
                    <div class="modal-body">
                        <div >
                        <h3>Saját szavazatod:</h3>
                            <star-rating-component
                                :food-id="(foodId)"
                                :user-id="(userId)"
                                :rate="(rate)">
                            </star-rating-component>
                        </div>
                        <h3 class="mt-5">Akik még szavaztak:</h3>
                        <div v-for="user in allUser" :key="user.id">
                            <div v-for="rate in allRate" :key="rate.id">
                                <div class="d-flex" v-if="foodId == rate.food_id && user.id == rate.user_id && userId != rate.user_id">
                                    <div class="col-3"></div>
                                    <div class="col-3">
                                        {{user.name}}

                                    </div>
                                    <div class="col-3 ">
                                        <star-rating
                                            :rating="(rate.rating)"
                                            :read-only="true"
                                            :increment="0.01"
                                            v-bind:star-size="20"
                                            class="custom-text">
                                        </star-rating>
                                    </div>
                                    <div class="col-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
import AddToCartComponent from './AddToCartComponent.vue';
import StarRatingComponent from './StarRatingComponent.vue';
export default {
  components: { AddToCartComponent, StarRatingComponent },
    props:['foods', 'userId', 'rate', 'categories', 'users'],
    data(){
        this.allCategory = JSON.parse(this.categories);
        this.allFood = JSON.parse(this.foods);
        this.allUser = JSON.parse(this.users);
        this.allRate = JSON.parse(this.rate);
        return{
            foodId: 0,
            foodName: "",
            rating: 0,
            storage: "storage/"
        }
    },
    methods:{
        //MODEL MEGJELENÍTÉS
        show(foodId, foodName){
            this.foodId = foodId;
            this.foodName = foodName;
            this.$modal.show('user-rate');
        },
        //MODEL BEZÁRÁS
        hide(){
            this.$modal.hide('user-rate');
        }
    }
}
</script>
<style scoped>
.card-text{
    max-width:420px;
    word-wrap:break-word;
}
.card{
    margin-bottom: 30px;
    background-color: rgba(245, 245, 245, 0.5);
    color: white;
}
img{
    margin: 10px;
}
h2{
    color: white;
}
.buttonBackground{
    background-image: url("/logo/menuLink.png");
    background-size: 100% auto;
    background-repeat: no-repeat;
    cursor: pointer;
    overflow: hidden;
    padding: 15px 7px;
    display: block;
    text-align: center;
    color: white;
    text-decoration: none;
}
a:hover{
    transform: scale(1.2);
}
a:active{
    transform: scale(0.8);
}
.custom-text {
  font-weight: bold;
  font-size: 1.0em;
  padding-left: 10px;
  padding-right: 10px;
  color: #999;
}
#user-rate{
    overflow: scroll;
}
</style>
