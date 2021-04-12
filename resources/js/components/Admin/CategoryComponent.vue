<template>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <form method="POST" enctype="multipart/form-data" @submit.prevent="submitNewCategory()">
                    <div class="form-group">
                        <label for="newCategory"><h1>Új Ételkategória</h1></label>
                         <input type="text"  class="form-control" v-model="form.newCategory"
                        :class="{'is-invalid' : form.errors.has('newCategory')}"
                        @keydown="form.errors.clear('newCategory')">
                        <div class="invalid-feedback" v-show="form.errors.has('newCategory')" v-text="form.errors.get('newCategory')"></div>
                    </div>
                    <button class="buttonStyle mt-4">Új kategória hozzáadása</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-5">
                <h1>Ételkategória szerkeztés</h1>
                <select class="form-control" v-model="selectCategory">
                    <option v-for="category in allCategory" :key="category.id" :value="category.id">{{category.categoryName}}</option>
                </select>
                <form v-for="category in allCategory" :key="category.id" v-if="selectCategory == category.id" method="POST" enctype="multipart/form-data" @submit.prevent="submitCategoryEdit(selectCategory, category.categoryName)" >
                    <div class="form-group">
                        <input type="text" class="form-control mt-3" :value="category.categoryName" @change="form.changeCategory = $event.target.value"
                        :class="{'is-invalid' : form.errors.has('changeCategory')}"
                        @keydown="form.errors.clear('changeCategory')">
                        <div class="invalid-feedback" v-show="form.errors.has('changeCategory')" v-text="form.errors.get('changeCategory')"></div>
                    </div>
                    <button type="submit" class="buttonStyle">Szerkeztés</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-5">
                <form method="get" enctype="multipart/form-data" @submit.prevent="submitCategoryDelete()" >
                    <div class="form-group">
                        <h1>Ételkategória törlése</h1>
                        <select class="form-control" v-model="deleteCategory">
                            <option v-for="category in allCategory" :key="category.id" :value="category.id">{{category.categoryName}}</option>
                        </select>
                    </div>
                    <button type="submit" class="buttonStyle">Törlés</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";

export default {
    props:['categories'],
    data(){
        this.allCategory = JSON.parse(this.categories);
        return{
            selectCategory: 0,
            deleteCategory: 0,
            test:[],
            form: new Form({
                newCategory: "",
                changeCategory: ""
            })
        }
    },
    methods:{
        submitNewCategory(){
            axios.post('/c',{'categoryName': this.form.newCategory})
            .then(response => {
                location.href = '/menu';
            })
            .catch(error => this.form.errors.record(error.response.data));
        },
        submitCategoryEdit($categoryId, $categoryName){
            if(this.form.changeCategory == ""){
                this.form.changeCategory = $categoryName;
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
                    axios.post('/categoryEdit/'+$categoryId,{'categoryName': this.form.changeCategory})
                    .then(response => {
                        this.form.changeCategory = "";
                        location.href = '/menu';
                    })
                    .catch(error => this.form.errors.record(error.response.data));
                }
            });
        },
        submitCategoryDelete(){
            Swal.fire({
                title: "Biztos benne?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Mégse",
                confirmButtonText: "Igen, törlöm!",
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Az étel szerkeztve!");
                    axios.get('/categoryDelete/'+this.deleteCategory)
                    .then(response => {
                        response.data.forEach(element => {
                        let keys = Object.keys(element);
                        keys.forEach(key => {
                        let item = element[key];
                             axios.delete("/deleteFood/" + item.id);
                        })
                    location.href = '/menu';
                    });
                })
            }
            });
        }
    }
}
</script>
<style scoped>
.buttonStyle{
    background-color: rgba(225,198,153,0.5);
    border: 4px solid rgba(225,198,153);;
    border-radius: 10px;
    font-weight: bolder;
}
.buttonStyle:hover{
    transform: scale(1.1);
}
.buttonStyle:active{
    transform: scale(0.9);
}
</style>
