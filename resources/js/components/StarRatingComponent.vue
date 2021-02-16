<template>
    <div>
        <star-rating
        @rating-selected="sendRating"
        v-model="rating"
        :increment="0.5"
        v-bind:star-size="30"
        text-class="custome-text">
        </star-rating>
    </div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    props:['foodId','rate','userId'],
    data(){
        this.allRate = JSON.parse(this.rate);
        return{
            rating: 0,
            ratePut: false,
            rateId: 0
        }
    },
    beforeMount(){
        this.setRating();
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
                        axios.post('/setRating/' + this.foodId + "/" + this.rating)
                        .then(response => {
                            Swal.fire({
                            icon: 'success',
                            title: 'Köszönjük a visszajelzését!',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        });
                    }
                    else{
                        axios.put('/putRating/' + this.rateId + "/" + this.rating)
                        .then(response => {
                            console.log(response.data);
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
                    this.rating = 0;
                }
            })
        },
        setRating(){
            this.allRate.forEach(rateElement => {
               if(rateElement.user_id == this.userId && rateElement.food_id == this.foodId){
                 this.rating = rateElement.rating;
               }
            });
        },
        putRating(){
            this.allRate.forEach(rateElement => {
               if(rateElement.user_id == this.userId && rateElement.food_id == this.foodId){
                   this.ratePut = true;
                   this.rateId = rateElement.id;
               }
            });
        }
    }
}
</script>
