<template>
    <div>
        <star-rating
            :rating="(foodAvgRating)"
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
            foodAvgId: 0,
            foodAvgRating: 0,
        }
    },
    computed: mapState({
        whenUserRating: state => state.starRate.whenUserRating
    }),
    //Ha a user szavaz/újra szavaz a Vuex-ben tárolt whenUserRating true lesz és újra lekéri az raing átlagot (avgRating() function).
    watch:{
        whenUserRating:function(){
            if(this.whenUserRating == true){
                this.avgRating();
            }
        }
    },
    beforeMount(){
        this.avgRating()
    },
    methods:{
        //Lekérem az ételek rating átlagját és a bejövő foodId alapján kiíratom. A Vuexben lévő whenUserRating-et false-ra teszem.
        avgRating(){
            axios.get('/avgRating')
                .then(response =>{
                    let keys = Object.keys(response.data);
                    keys.forEach(key => {
                    let item = response.data[key];
                        if(item.food_id == this.foodId){
                            this.foodAvgRating = item.avgRating;
                        }
                    });
                this.$store.commit("avgRating");
            })
        },
    }
}
</script>
