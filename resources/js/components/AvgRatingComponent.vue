<template>
    <div>
        <star-rating
            :rating="(rating)"
            :read-only="true"
            :increment="0.01"
            v-bind:star-size="20"
            :show-rating="false">
        </star-rating>
    </div>
</template>
<script>
import { mapState } from 'vuex';
export default {
    props:['foodId'],
    data(){
        return{
            rating: 0,
        }
    },
    computed: mapState({
        whenUserRating: state => state.starRate.whenUserRating
    }),
    watch:{
        whenUserRating:function(){
            if(this.whenUserRating == true){
                this.avgRating();
            }
        }
    },
    beforeMount(){
        this.avgRating();
    },
    methods:{
        avgRating(){
            axios.get('/avgRating/'+this.foodId)
                .then(response =>{
                if(response.data == 0){
                    this.rating = 0;
                }
                else{
                    this.rating = parseFloat(response.data);
                }
                this.$store.commit("avgRating");
            })
        },
    }
}
</script>
