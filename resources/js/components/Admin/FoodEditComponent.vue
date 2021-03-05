<template>
    <div>
        <modal name="food-edit" height="auto">
            <div class="modal-mask">
                <div class="modal-container" >
                    <div class="modal-header">
                        <h3>Az étel szerkeztés</h3>
                    </div>
                        <div class="modal-body"  v-for="food in allFood" :key="food.id" v-if="food.id == foodId" >
                            <form method="POST" enctype="multipart/form-data" @submit.prevent="submitFoodEdit(food.foodName, food.price, food.description, food.image)" >
                                <div class="form-group">
                                    <label for="foodName">Az étel neve:</label>
                                    <input type="text"  class="form-control" :value="food.foodName" @change="form.foodName = $event.target.value">
                                </div>
                                <div class="form-group ">
                                    <label for="price">Az étel ára:</label>
                                    <input type="number" class="form-control" :value="food.price" @change="form.price = $event.target.value">
                                </div>
                                 <div class="form-group">
                                    <label for="description">Az étel leírása:</label>
                                    <textarea class="form-control" :value="food.description" @change="form.description = $event.target.value">
                                    </textarea>
                                </div>
                                 <div class="input-group">
                                    <label for="image">Kép az ételről: </label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Az étel szerkeztése</button>
                            </form>
                        </div>
                    <div class="modal-footer text-right">
                        <button class="btn btn-primary" @click="$modal.hide('food-edit')">Kilépés</button>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
import Swal from "sweetalert2";

export default {
    props:['foods','foodId'],
    data(){
        this.allFood = JSON.parse(this.foods);
        return{
            edit: false,
            foodName: "",
            price: 0,
            description: "",
            image: "",
             form: new Form({
                foodName: "",
                price: 0,
                description: "",
                image: ""
            }),
        }
    },
    watch:{
        edit:function(){
            this.$emit("foodEdit",{foodId:this.foodId,foodName:this.foodName, price:this.price, description:this.description,image:this.image});
            this.edit = false;
        }
    },
    methods:{
        submitFoodEdit($foodName, $price, $description, $image){
            let data = new FormData();
            if(this.form.foodName != ""){
                data.append('foodName', this.form.foodName);
            }
            else{
                data.append('foodName',$foodName);
            }
            if(this.form.price != 0){
                data.append('price', this.form.price);
            }
            else{
                data.append('price',$price);
            }
            if(this.form.description != ""){
                data.append('description', this.form.description);
            }
            else{
                data.append('description',$description);
            }
            if(document.getElementById('image').files[0])
            {
                data.append('image', document.getElementById('image').files[0]);
            }
            else{
                data.append('image', $image);
            }
            Swal.fire({
                title: "Biztos benne?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Mégse",
                confirmButtonText: "Igen, szerkeztem!",
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Az étel szerkeztve!");
                    axios.post('/foodEdit/'+this.foodId, data)
                        .then((response) => {
                        this.foodName= response.data.foodName;
                        this.price = response.data.price;
                        this.description = response.data.description;
                        this.image = response.data.image;
                        this.edit = true;

                        this.form.foodName = "";
                        this.form.price = "";
                        this.form.description = "";
                        this.$modal.hide('food-edit');
                    })
                .catch(error => this.form.errors.record(error.response.data));
                }
            });
        },
        //MODEL BEZÁRÁS
        hide(){
            this.$modal.hide('food-edit');
        }
    }
}
</script>
