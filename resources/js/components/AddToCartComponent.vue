<template>
    <div>
        <button type="button" class="btn btn-success pull-right" v-on:click="cartButton">Kosár</button>
    </div>
</template>

<script>
import BadgeComponent from './BadgeComponent'
    export default {
        props: ['foodId'],
        methods:{
            cartButton(){
                axios.post('/add-to-cart/' + this.foodId)
                    .then(response => {
                        response.data
                    })
            this.$store.commit("cartButton");
            },
        }
    }
</script>
