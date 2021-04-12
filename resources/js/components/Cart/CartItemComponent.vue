<template>
    <div v-if="seen">
      <div class="row cartItem">
        <div>
          <img :src="image" />
        </div>

        <div>
          <span class="foodName">{{ name }}</span>
        </div>

        <div>{{ price }} Ft</div>

        <div>
          <button type="button" class="cartItemButton" @click="sumButton" >
            +
          </button>

          <input style="width: 35px" v-model="quantityCount" />

          <button type="button" :disabled="requestProcessing" class="cartItemButton" @click="subButton">
            -
          </button>
        </div>

        <div>{{ sub_total }} HUF</div>

        <div>
          <button type="button" class="cartItemButton" v-on:click="removeButton">
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
<style scoped>
.cartItem{
    margin: 20px;
    padding: 10px;
    font-size: 2.5vh;
    color: white;
    font-weight: 900;
    border: 2px solid rgba(225,198,153);
    border-radius: 20px;
    box-shadow: 0px 0px 0px 3px rgba(225,198,153,0.8);
    display: flex;
    justify-content: space-between;
}
.foodName{
    font-size: 3.5vh;
    color: white;
    font-weight: 900;
}
img{
    border-radius: 10px;
}
.cartItemButton{
    background-color: rgba(225,198,153,0.5);
    border: 4px solid rgba(225,198,153);
    border-radius: 10px;
    color: white;
    font-weight: bolder;
}
.cartItemButton:hover{
    transform: scale(1.1);
}
.cartItemButton:active{
    transform: scale(0.9);
}
.stepBorder::after{
    content: "";
    display: block;
    width: 6%;
    height: 3px;
    background-color: rgba(225,198,153);
}
</style>
