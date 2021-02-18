<template>
    <div>
        <div v-if="userId != 0" class="mr-5">
        <star-rating
            @rating-selected="sendRating"
            :rating="(userRate)"
            v-model="(userRate)"
            :increment="0.5"
            v-bind:star-size="30"
            text-class="custome-text">
        </star-rating>
      </div>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    props:['foodId','rate','userId'],
    data(){
        this.allRate = JSON.parse(this.rate);
        return{
            userRate:0,
            ratePut: false,
            rateId: 0
        }
    },
    beforeMount(){
        this.getRating();
    },
    methods: {
        sendRating(){
            this.putRating();
            Swal.fire({
                title: 'Szavazni szeretnél?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Nem!',
                confirmButtonText: 'Igen!'
                }).then((result) => {
                if (result.isConfirmed) {
                    if(this.ratePut == false){
                        axios.post('/setRating/' + this.foodId + "/" + this.userRate)
                        .then(response => {
                            this.getRating();
                            this.$store.commit("sendRating");
                            Swal.fire({
                            icon: 'success',
                            title: 'Köszönjük a visszajelzését!',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        });
                    }
                    else{
                        axios.put('/putRating/' + this.rateId + "/" + this.userRate)
                        .then(response => {
                            this.getRating();
                            this.$store.commit("putRating");
                            Swal.fire({
                            icon: 'success',
                            title: 'Köszönjük a visszajelzését!',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        });
                    }
                }
                else{
                    this.userRate = 0;
                }
            })
        },
        getRating(){
            axios.get('/getRating/'+this.foodId+"/"+this.userId)
                .then(response =>{
                response.data.forEach(element => {
                    if(element.rating == 0){
                        this.userRate = 0;
                    }
                    else{
                        this.userRate = parseFloat(element.rating);
                    }
                })
            })
        },
        putRating(){
            this.allRate.forEach(rateElement => {
               if(rateElement.user_id == this.userId && rateElement.food_id == this.foodId){
                   this.ratePut = true;
                   this.rateId = rateElement.id;
               }
            })
        }
    }
}
</script>
