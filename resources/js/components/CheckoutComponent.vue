<template>
    <div class="row ml-5 mr-5">
        <div class="col-md-8">
            <form method="POST" enctype="multipart/form-data" @submit.prevent="submitOrder">
                <div class="d-flex">
                    <div class="form-group pr-5">
                        <label for="vezeteknev">Vezetéknév:</label>
                        <input type="text" v-model="form.vezeteknev" class="form-control" style="width: 400px"
                        :class="{'is-invalid' : form.errors.has('vezeteknev')}"
                        @keydown="form.errors.clear('vezeteknev')">
                        <div class="invalid-feedback" v-show="form.errors.has('vezeteknev')" v-text="form.errors.get('vezeteknev')"></div>
                    </div>
                    <div class="form-group">
                        <label for="keresztnev">Keresztnév:</label>
                        <input type="text"
                         v-model="form.keresztnev" class="form-control" style="width: 400px"
                        :class="{'is-invalid' : form.errors.has('keresztnev')}"
                        @keydown="form.errors.clear('keresztnev')">
                        <div class="invalid-feedback" v-show="form.errors.has('keresztnev')" v-text="form.errors.get('keresztnev')"></div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-gorup pr-5">
                        <label for="iranyitoszam">Irányítószám:</label>
                        <input type="number"
                        v-model="form.iranyitoszam" class="form-control" style="width: 400px"
                        :class="{'is-invalid' : form.errors.has('iranyitoszam')}"
                        @keydown="form.errors.clear('iranyitoszam')">
                        <div class="invalid-feedback" v-show="form.errors.has('iranyitoszam')" v-text="form.errors.get('iranyitoszam')"></div>
                    </div>
                    <div class="form-group">
                       <label for="varos">Város:</label>
                        <input type="text"
                        v-model="form.varos" class="form-control" style="width: 400px"
                        :class="{'is-invalid' : form.errors.has('varos')}"
                        @keydown="form.errors.clear('varos')">
                        <div class="invalid-feedback" v-show="form.errors.has('varos')" v-text="form.errors.get('varos')"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Utca, házszám:</label>
                    <input type="text" placeholder="Utcanév, házszám"
                    v-model="form.address" class="form-control" style="width: 850px"
                    :class="{'is-invalid' : form.errors.has('address')}"
                    @keydown="form.errors.clear('address')">
                    <div class="invalid-feedback" v-show="form.errors.has('address')" v-text="form.errors.get('address')"></div>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Lépcsőház, emelet, ajtó, stb. (nem kötelező)"
                    v-model="form.emelet" class="form-control" style="width: 850px">
                </div>
                <div class="form-group">
                    <label for="telefonszam">Telefonszám:</label>
                    <input type="number" placeholder="Pl.: 0630 123 4567" v-model="form.telefonszam"
                    class="form-control" style="width: 850px"
                      :class="{'is-invalid' : form.errors.has('telefonszam')}"
                        @keydown="form.errors.clear('telefonszam')">
                        <div class="invalid-feedback" v-show="form.errors.has('telefonszam')" v-text="form.errors.get('telefonszam')"></div>
                </div>
                <div class="form-group">
                    <label for="email">E-mail cím:</label>
                    <input type="email" v-model="form.email"
                    class="form-control" style="width: 850px"
                      :class="{'is-invalid' : form.errors.has('email')}"
                        @keydown="form.errors.clear('email')">
                        <div class="invalid-feedback" v-show="form.errors.has('email')" v-text="form.errors.get('email')"></div>
                </div>
                <div class="form-group">
                    <label for="message">Rendeléshez megjegyzés:</label>
                    <textarea class="form-control" placeholder="Megjegyzés"
                    v-model="form.message" style="width: 850px"></textarea>
                </div>
                <div class="justify-content-between">
                    <button type="submit" class="btn btn-primary">Fizetés</button>
                </div>
            </form>
        </div>
        <div class="col-md-4 p-5">
            <h5>RENDELÉS TARTALMA</h5>
            <button class="btn btn-primary" @click="cartButton">Visszatérés a kosárhoz</button>
            <div class="d-flex justify-content-between pt-3" style="border-bottom: 1px solid black">
                <h5>Termék</h5>
                <h5>Összeg</h5>
            </div>
            <div v-for="item in foodItem" class="mt-3">
                <div v-if="item != null">
                    <div v-for="food in item" :key="food.id" class="d-flex justify-content-between">
                        <p>{{food.foodName}}
                        {{food.qty}}X</p>
                        {{food.price*food.qty}}HUF
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between" style="border-top: 1px solid black">
                <div>Teljes Összeg</div>
                <div>{{total}} HUF</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['checkoutFoodId','totalPrice', 'paymentRoute', 'ordered'],
    data(){
    this.foodItem = JSON.parse(this.checkoutFoodId);
        return{
            cart: false,
            total: this.totalPrice,
            form: new Form({
                vezeteknev: '',
                keresztnev: '',
                iranyitoszam: '',
                email: '',
                varos: '',
                address: '',
                emelet: '',
                telefonszam: '',
                message: '',
                userOrdered: 0,
            }),

        }
    },
    watch:{
        cart:function(){
            this.cart = false;
            this.$emit("checkout");
        }
    },
    methods: {
        cartButton(){
            this.cart = true;
        },
        submitOrder(){
            let data = new FormData();
            data.append('vezeteknev',this.form.vezeteknev);
            data.append('keresztnev',this.form.keresztnev);
            data.append('iranyitoszam',this.form.iranyitoszam);
            data.append('varos',this.form.varos);
            data.append('email',this.form.email);
            if(this.form.emelet != ''){
            data.append('address',this.form.address+" "+this.form.emelet);
            }
            else{
            data.append('address',this.form.address);
            }
            data.append('telefonszam',this.form.telefonszam);
            data.append('message',this.form.message);
            data.append('totalPrice', this.totalPrice);
            axios.post('/order', data)
            .then((response) => {
                this.form.reset();
                location.href = '/paymentSuccessFull';
              })
             .catch(error => this.form.errors.record(error.response.data));
        }
    }
}
</script>
