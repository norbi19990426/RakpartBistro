<template>
<table class="table" v-if="seen">
  <tbody>
        <tr>
          <td>
           <!-- <img
              src="/storage/{{ image }}"
              class="img-fluid"
              width="150"
            />-->

            <span>{{ name }}</span>
          </td>
          <td>{{ price }}</td>
          <td>

            <button type="button" class="btn btn-success" @click="sumButton">
              +
            </button>

            <input style="width: 40px" v-model="quantityCount" />

            <button type="button" class="btn btn-warning" @click="subButton">
              -
            </button>

          </td>
        <td>
        {{sub_total}}
        </td>
          <td>
              <button type="button" class="btn btn-dark" v-on:click="removeButton">Törlés</button>
          </td>
        </tr>

  </tbody>
</table>
</template>
<script>
import Swal from "sweetalert2";

export default {
  props: ["food"],
  data() {
      this.food = JSON.parse(this.food);
    return {
      seen: true,
      quantityCount: this.food.quantity,
      image: this.food.image,
      name: this.food.name,
      price: this.food.price,
      sub_total: this.food.price * this.food.quantity,

    };
  },
  methods: {
    sumButton() {
      axios.post("/updateSum/" + this.food.id)
        .then((response) => {
          this.quantityCount = response.data.quantity;
          this.sub_total = response.data.sub_total;

      }).catch((error) => {
          console.log(error);
            Swal.fire("Error", error.message, "error");
      })

        this.$store.commit("sumButton");
    },
    subButton() {
        this.$store.commit("subButton");
    },
    removeButton(){
        axios.post("/remove/" + this.food.id)
            .then((response) => {
            this.seen = !this.seen;
            this.$store.commit("removeButton", response.data.quantity);
      })
    }
  },

};
</script>
