<template>
    <div id="#top">
        <a class="scrollToTopButton" href="#top">
            <img class="arrow" src="/logo/arrow.png" />
        </a>
        <div class="row d-flex justify-content-center">
            <a  v-for="category in allCategory" :key="category.id" :href="'#'+category.id" class="menuLink"> {{ category.categoryName }}</a>
        </div>
        <div v-for="category in allCategory" :key="category.id" :id="category.id" class="categoryName">
                <h1>{{category.categoryName}}</h1>
            <div class="row">
            <div class="col-md-12" v-for="food in foodsTable" :key="food.id" v-if="category.id == food.category_id">
                <div class="card">
                    <div class="d-flex justify-content-between">
                        <img :src="(storage+food.image)" class="foodImg" />
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="card-title">{{ food.foodName }}</p>
                                <div class="d-flex">
                                    <food-avg-component :food-id="food.id"></food-avg-component>
                                    <div v-show="admin" class="adminButtonBorder">
                                        <a @click.prevent="foodEdit(food.id)">
                                            <img class="adminButton" v-show="admin" src="/logo/edit.png" style="height: 30px;">
                                        </a>
                                        <a @click="deleteFood(food.id)">
                                            <img class="adminButton" v-show="admin" src="/logo/deleteFood.png" style="height: 30px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <div class="description">{{food.description}}</div>
                                </div>
                                <div class="col-2 price">
                                    <p>{{food.price}} HUF</p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex justify-content-start">
                                    <a type="button" v-show="userId != 0" class="buttonBackground" @click.prevent="show(food.id,food.foodName)">Értékelés</a>
                                </div>
                                <div class="d-flex justify-content-end">
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
        </div>
        <food-edit-component
        v-show="admin"
        :foods="JSON.stringify(allFood)"
        :food-id="foodId"
        @foodEdit="getFoodEdit">
        </food-edit-component>
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
import FoodAvgComponent from './FoodAvgComponent.vue';
import Swal from "sweetalert2";
export default {
  components: { AddToCartComponent, StarRatingComponent, FoodAvgComponent },
    props:['foods', 'userId', 'rate', 'categories', 'users','admin'],
    data(){
        this.allCategory = JSON.parse(this.categories);
        this.allFood = JSON.parse(this.foods);
        this.allUser = JSON.parse(this.users);
        this.allRate = JSON.parse(this.rate);
        return{
            foodId: 0,
            foodName: "",
            storage: "storage/",
            foodsTable: [],
        }
    },
    beforeMount(){
        this.setFoodsTable();
    },
    methods:{
        setFoodsTable:function(){
            this.foodsTable = this.allFood;
        },
        getFoodEdit:function(foodEdit){
            this.foodsTable.forEach(element => {
               if(element.id == foodEdit.foodId){
                    element.foodName = foodEdit.foodName;
                    element.price = foodEdit.price;
                    element.description = foodEdit.description;
                    element.image = foodEdit.image;
               }
            });
        },
        deleteFood($foodId){
            Swal.fire({
                title: "Biztos törölni akarja ezt az ételt?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Mégse",
                confirmButtonText: "Igen, törlöm!",
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Az étel törölve!");
                    this.foodsTable.forEach((x,y) => {//id és az index párja
                        if($foodId == x.id){
                            axios.delete("/deleteFood/" + x.id);
                            this.foodsTable.splice(y, 1);
                        }
                    })
                }
            });
        },
        foodEdit(foodId){
            this.foodId = foodId;
            this.$modal.show('food-edit');
        },
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
<style lang="scss" scoped>
.categoryName{
    padding-top: 100px;
    color: white;
}
.menuLink{
    background-image: url("/logo/menuLink.png");
    background-size: 110px;
    background-repeat: no-repeat;
    width: 110px;
    height: 80px;
    cursor: pointer;
    overflow: hidden;
    padding: 25px 6px;
    text-align: center;
    color: white;
    margin-right: 20px;
    margin-top: 20px;
}
.menuLink:hover{
    color: white;
    text-decoration: none;
    transform: scale(1.2);
}
.menuLink:active{
    transform: scale(0.8);
}
.card-title{
    font-size: 4vh;
    font-weight: bolder;
}
.card{
    margin-bottom: 30px;
    background-color: rgba(245, 245, 245, 0.5);
    color: white;
}
.foodImg{
    margin: 10px;
    border-radius: 10px;
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
.buttonBackground:hover{
    transform: scale(1.2);
}
.buttonBackground:active{
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
.adminButtonBorder{
    border: 3px solid black;
    border-radius: 20px;
    margin-left: 10px;
}
.adminButton{
    margin: 10px;
}
.adminButton:hover{
    transform: scale(1.3);
}
.adminButton:active{
    transform: scale(0.8);
}
.scrollToTopButton {
  transition: all .25s ease-in-out;
  position: fixed;
  bottom: 0;
  right: 0;
  display: inline-flex;

  cursor: pointer;
  align-items: center;
  justify-content: center;
  margin: 0 3em 3em 0;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  background-color: rgb(255,255,255, 0.3);
  color: white;
  &:hover {
    background-color: rgb(255,255,255, 0.7);
  }
}
.description{
    font-size: 2.5vh;
}
.price{
    font-size: 2.5vh;
    display: flex;
    justify-content: flex-end;
}
.arrow{
    width: 100%;
    height: auto;
}
</style>
