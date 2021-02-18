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
                                    <p class="card-text">{{food.description}}</p>
                                </div>
                                <div class="col-3">
                                    <p >{{food.price}} HUF</p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">

                                <button v-if="userId != 0" class="btn btn-warning"  @click.prevent="show(food.id)">Értékelés</button>

                                <add-to-cart-component
                                    :food-id="(food.id)"
                                    :user-id="(userId)"
                                    >
                                </add-to-cart-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="user-rate">
            <div class="modal-mask">
                <star-rating-component
                    :food-id="(foodId)"
                    :user-id="(userId)"
                    :rate="(rate)">
                </star-rating-component>
            </div>
        </modal>
    </div>
</template>
<script>
import AddToCartComponent from './AddToCartComponent.vue';
import StarRatingComponent from './StarRatingComponent.vue';
export default {
  components: { AddToCartComponent, StarRatingComponent },
    props:['foods', 'userId', 'rate', 'categories'],
    data(){
        this.allCategory = JSON.parse(this.categories);
        this.allFood = JSON.parse(this.foods);
        return{
            storage: "storage/",
            foodId: 0
        }
    },
    methods:{
        //MODEL MEGJELENÍTÉS
        show(foodId){
            this.foodId = foodId;
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
    background-color: rgba(245, 245, 245, 0.4);
    opacity: 1;
    color: white;
}
img{
    margin: 10px;
}
h2{
    color: white;
}
</style>
