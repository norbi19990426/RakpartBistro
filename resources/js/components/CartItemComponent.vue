<template>
  <div class="container">
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

          <button type="button" class="btn btn-warning" @click="subButton">
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
  </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
  props: ["food"],
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
    };
  },

watch:{
      sub_total:function(){
         this.$emit("total-price", {id:this.id, sub_total:this.sub_total} );
      },
      seen:function(){
         this.$emit("remove", {id:this.id, sub_total:0} );
      }
  },
  methods: {
      getFormattedDate() {
    var date = new Date();
    var str = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + " " +  date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

    return str;
},
    sumButton() {
        console.log("start", this.getFormattedDate());
      axios
        .put("/updateSum/" + this.id)
        .then((response) => {
         console.log("a vég", this.getFormattedDate());
          this.quantityCount = response.data.quantity;
          this.sub_total = response.data.sub_total;
        })
        .catch((error) => {
          console.log(error);
          Swal.fire("Error", error.message, "error");
        });
      this.$store.commit("sumButton");
    },

    subButton() {
        if (this.quantityCount == 1) {
            this.removeButton();
        }
        else{
            axios
            .put("/updateSub/" + this.id)
                .then((response) => {
                this.quantityCount = response.data.quantity;
                this.sub_total = response.data.sub_total;
                this.$store.commit("subButton");
            })
        }
    },
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
            axios.delete("/remove/" + this.id)
            .then((response) => {
                this.seen = !this.seen;
                this.$store.commit("removeButton", response.data.quantity);
            });
          }
        });
    },
  },
};
</script>
