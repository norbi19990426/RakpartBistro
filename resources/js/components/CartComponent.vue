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
          <button type="button" id="sumButton" class="btn btn-success" @click="sumButton">
            +
          </button>

          <input style="width: 35px" v-model="quantityCount" />

          <button type="button" class="btn btn-warning" @click="subButton">
            -
          </button>
        </div>

        <div class="col-md-2">{{ sub_total }} Ft</div>

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
  props: ["cart"],
  data() {
    this.food = JSON.parse(this.cart);
    return {
      seen: true,
      id: this.food.id,
      quantityCount: this.food.quantity,
      image: "storage/" + this.food.image,
      name: this.food.name,
      price: this.food.price,
      sub_total: this.food.price * this.food.quantity,
    };
  },

  watch:{
      sumButton:function(){
          this.$emit("total-price",  this.price);
      }
  },
  methods: {
    sumButton() {
      axios
        .post("/updateSum/" + this.food.id)
        .then((response) => {
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
      axios
        .post("/updateSub/" + this.food.id)
        .then((response) => {
          if (response.data.quantity >= 1) {
            this.quantityCount = response.data.quantity;
            this.sub_total = response.data.sub_total;
            this.$store.commit("subButton");
          } else {
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
                this.seen = !this.seen;
                this.$store.commit("subButton");
              }
            });
          }
        })
        .catch((error) => {
          console.log(error);
          Swal.fire("Error", error.message, "error");
        });
    },
    removeButton() {
      axios.post("/remove/" + this.food.id).then((response) => {
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
            this.seen = !this.seen;
            this.$store.commit("removeButton", response.data.quantity);
          }
        });
      });
    },
  },
};
</script>
