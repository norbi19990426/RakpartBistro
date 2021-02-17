<template>
    <div class="col-sm-6">
          <div class="card">
            <div class="d-flex justify-content-between">
                <img :src="(image)" class="float-left pr-3" >
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">{{ foodName }}</h4>
                        <p class="text-md-right">{{ price}} HUF</p>
                    </div>
                    <p class="card-text">{{ description}}</p>
                </div>
            </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <star-rating-component
                            :food-id="(foodId)"
                            :user-id="(userId)"
                            :rate="(rate)">
                        </star-rating-component>

                        <add-to-cart-component
                            :food-id="(foodId)"
                            :user-id="(userId)">
                        </add-to-cart-component>
                    </div>
                </div>
        </div>
    </div>
</template>
<script>
import AddToCartComponent from './AddToCartComponent.vue';
import StarRatingComponent from './StarRatingComponent.vue';
export default {
  components: { AddToCartComponent, StarRatingComponent },
    props:['foods', 'userId', 'rate'],
    data(){
        this.allFood = JSON.parse(this.foods);
        return{
            foodId: this.allFood.id,
            foodName: this.allFood.foodName,
            image: "storage/"+this.allFood.image,
            price: this.allFood.price,
            description: this.allFood.description
        }
    }
}
</script>
<style scoped>
.card-text{
    max-width:500px;
    word-wrap:break-word;
}
.card{
    margin-bottom: 30px;
}
</style>
