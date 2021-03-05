<template>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h1 class="col-xl-12 mt-3" style="text-align:center">Új étel</h1>
            <form method="POST" enctype="multipart/form-data" @submit.prevent="submitNewFood">
                <div class="form-group col-xl-12">
                    <label for="category_id">Az étel kategóriája: </label>
                    <select class="form-control" id="category_id" v-model="form.category_id">
                        <option v-for="category in categoryName" :key="category.id" :value="category.id">{{ category.categoryName }}</option>
                    </select>
                </div>
                <div class="form-group col-xl-12">
                    <label for="foodName">Az étel neve:</label>
                    <input type="text" v-model="form.foodName" class="form-control" style="width: 400px"
                    :class="{'is-invalid' : form.errors.has('foodName')}"
                    @keydown="form.errors.clear('foodName')">
                    <div class="invalid-feedback" v-show="form.errors.has('foodName')" v-text="form.errors.get('foodName')"></div>
                </div>
                 <div class="form-group col-xl-12">
                    <label for="price">Az étel ára:</label>
                    <input type="number" v-model="form.price" class="form-control" style="width: 400px"
                    :class="{'is-invalid' : form.errors.has('price')}"
                    @keydown="form.errors.clear('price')">
                    <div class="invalid-feedback" v-show="form.errors.has('price')" v-text="form.errors.get('price')"></div>
                </div>
                <div class="form-group col-xl-12">
                    <textarea class="form-control" placeholder="Leírás" v-model="form.description"
                    id="description" name="description" style="width: 400px"
                    :class="{'is-invalid' : form.errors.has('description')}"
                    @keydown="form.errors.clear('description')"></textarea>
                    <div class="invalid-feedback" v-show="form.errors.has('description')" v-text="form.errors.get('description')"></div>
                </div>
                <div class="input-group col-xl-12">
                    <label for="image">Kép az ételről: </label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="m-3 ">
                    <button type="submit" class="btn btn-primary">Új étel hozzáadása</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import { VueEditor } from "vue2-editor";
export default {
    props:['categories','menuRoute'],
    components: { VueEditor },
    data(){
        this.categoryName = JSON.parse(this.categories);
        return{
            form: new Form({
                category_id: 0,
                foodName: "",
                price: 0,
                description: "",
                image: ""
            }),
        }
    },
    methods:{
        submitNewFood(){
            let data = new FormData();
            data.append('category_id',this.form.category_id);
            data.append('foodName', this.form.foodName);
            data.append('price', this.form.price);
            data.append('description', this.form.description);
            if(document.getElementById('image').files[0]){data.append('image', document.getElementById('image').files[0])};
            axios.post('/f', data)
            .then((response) => {
                location.href = '/menu';
              })
             .catch(error => this.form.errors.record(error.response.data));
        }
    }
}
</script>
