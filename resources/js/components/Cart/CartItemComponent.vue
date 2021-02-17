<template>
    <div v-if="seen">
      <div class="row pt-3 pb-3" style="border-top: 1px solid black">
        <div class="col-md-2">
          <img :src="image" />
        </div>

        <div class="col-md-2">
          <h3>{{ name }}</h3>
        </div>

        <div class="col-md-2">{{ price }} Ft</div>

        <div class="col-md">
          <button type="button" class="btn btn-success" @click="sumButton" >
            +
          </button>

          <input style="width: 35px" v-model="quantityCount" />

          <button type="button" :disabled="requestProcessing" class="btn btn-warning" @click="subButton">
            -
          </button>
        </div>

        <div class="col-md-2">{{ sub_total }} HUF</div>

        <div class="col-md-2">
          <button type="button" class="btn btn-dark" v-on:click="removeButton">
            Törlés
          </button>
        </div>
      </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
  props: ["food", 'userId'],
  data() {
    this.foodItem = JSON.parse(this.food);
    return {
      seen: true,
      id: this.foodItem.id,
      quantityCount: this.foodItem.quantity,
      image: "storage/" + this.foodItem.image,
      name: this.foodItem.name,
      price: this.foodItem.price,
      sub_total: this.foodItem.price * this.foodItem.quantity,
      requestProcessing: false
    };
  },

watch:{
      sub_total:function(){
         this.$emit("total-price", {id:this.id, sub_total:this.sub_total} );
      },
      seen:function(){
         this.$emit("remove", {id:this.id, sub_total:0});
      },
      quantityCount:function(){
          this.$emit("badgeCount", {id:this.id, quantityCount:this.quantityCount,name:this.name,price:this.price});
      },
  },
  methods: {
    //NÖVELI A QUANTITY DARABSZÁMÁT ÉS HA VAN BEJELENTKEZVE FELHASZNÁLÓ ADATBÁZISBA IS NÖVELI
    sumButton() {
      axios
        .put("/updateItemSum/" + this.id)
        .then((response) => {
          this.quantityCount = response.data.quantity;
          this.sub_total = response.data.sub_total;
        })
        .catch((error) => {
          console.log(error);
          Swal.fire("Error", error.message, "error");
        });
        if(this.userId != 0){
            axios.post('/addToUserCart/' + this.id + "/" + this.userId)
        }
    },
    //CSÖKKENTI A QUANTITY DARABSZÁMÁT ÉS HA VAN BEJELENTKEZVE FELHASZNÁLÓ ADATBÁZISBA IS CSÖKKENTI
    //HA 1 LESZ A QUANTITY ÉRTÉKE TÖRLÉS GOMBOT AJÁNL FEL A KÖVETKEZŐ CSÖKKENTÉSNÉL, LETILTJA A GOMBOT, HA TÚL GYORSAN KEDZIK EL NYOMKODNI
    subButton() {
        if (this.quantityCount == 1) {
            this.removeButton();
        }
        else{
            this.requestProcessing = true;
            axios
            .put("/updateItemSub/" + this.id)
                .then((response) => {
                this.quantityCount = response.data.quantity;
                this.sub_total = response.data.sub_total;
                this.requestProcessing = false;
            })
            if(this.userId != 0){
                axios.post('/addToUserCart/' + this.id + "/" + this.userId)
            }
        }
    },
    //TÖRLI A CART-BA RAKOTT TERMÉKET
    removeButton() {
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
            Swal.fire("Termék törölve!");
            axios.delete("/itemRemove/" + this.id)
            .then((response) => {
                this.seen = false;
                this.$store.commit("removeButton", response.data.quantity);
            });
            if(this.userId != 0){
                axios.delete('/userItemRemove/' + this.id + "/" + this.userId)

            }
          }
        });
    },
  },
};
</script>
