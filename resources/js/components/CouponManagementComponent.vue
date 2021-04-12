<template>
    <div class="container mt-3">
        <div class="d-flex justify-content-between">
            <button class="buttonStyle mb-3" @click="couponsDelete">Kijelölt kuponok törlése</button>
            <a class="linkStyle" v-bind:href="createCoupon">Új kupon</a>
        </div>
        <table class="table table-striped table-light">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Kupon</th>
                    <th scope="col">Kupon neve</th>
                    <th scope="col">Százalék mennyisége</th>
                    <th scope="col">Használhatóság</th>
                </tr>
            </thead>
            <tbody v-for="coupon in couponsTable" :key="coupon.id">
                <tr>
                    <td><input type="checkbox" :value="coupon.id"  v-model="selectId"></td>
                    <th scope="row"># {{coupon.id}}</th>
                    <td class="editCoupon" @click.prevent="show(coupon.id)">{{coupon.couponName}}</td>
                    <td class="editCoupon" @click.prevent="show(coupon.id)">{{coupon.couponPercent}} %</td>
                    <td v-for="usage in couponUsage" :key="usage.id" v-if="coupon.usages_id == usage.id">
                        <p>{{usage.usagesName}}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    <modal name="coupon-form" height="auto" >
        <div class="modal-mask">
            <div class="modal-container" >
                <div class="modal-header">
                    <h3>Kupon szerkeztés</h3>
                </div>
                <div>
                    <div class="modal-body"  v-for="coupon in couponsTable" :key="coupon.id" v-if="couponId == coupon.id">
                        <form method="PUT" enctype="multipart/form-data" @submit.prevent="submitCouponEdit(coupon.id,coupon.couponName, coupon.couponPercent)">
                            <div class="form-group">
                                <label for="couponName">Kupon elnezevezés:</label>
                                <input type="text" class="form-control" :value="coupon.couponName" @change="couponName = $event.target.value">
                            </div>
                            <div class="form-group">
                                <label for="couponPercent">Százalék mennyisége:</label>
                                <input type="number" class="form-control" :value="coupon.couponPercent" @change="couponPercent = $event.target.value">
                            </div>
                            <button type="submit" class="buttonStyle">Szerkeztés</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button class="buttonStyle" @click="$modal.hide('coupon-form')">Kilépés</button>
                </div>
            </div>
        </div>
    </modal>
    </div>
</template>
<script>
import Swal from "sweetalert2";

export default {
    props:['coupons', 'usage', 'createCoupon'],
    data(){
        this.allCoupon = JSON.parse(this.coupons);
        this.couponUsage = JSON.parse(this.usage);
        return{
            couponSelectName: "",
            selectId: [],
            couponsTable:[],
            couponId: 0,
            couponName: '',
            couponPercent: '',
        }
    },
    beforeMount(){
        this.getCouponsTable();
    },
    methods:{
        // A BEJÖVŐ KUPONOKAT BELEHELYEZI EGY TÖMB-BE
        getCouponsTable:function(){
            this.couponsTable = this.allCoupon;
        },
        // KUPON HASZNÁLHATÓSÁG VÁLTZOTATÁSA
        changeCouponUsage(couponId, usageId){
             Swal.fire({
                title: "Biztos benne?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Mégse",
                confirmButtonText: "Igen, megváltoztatom!",
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Kupon használhatósága beállítva!");
                    axios.put('/usage/' + couponId + "/" + usageId);
                }
            })
        },
        //KIJELÖLT KUPONOK TÖRLÉSE
        couponsDelete(){
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
                    Swal.fire("Kupon törölve!");
                    this.selectId.forEach(element => {
                        this.couponsTable.forEach((x,y) => {//id és az index párja
                            if(element == x.id){
                            axios.delete("/couponsRemove/" + x.id);
                            this.couponsTable.splice(y, 1);
                            }
                        })
                    });
                }
            });
        },
        //KUPON SZERKEZTÉS
        submitCouponEdit($couponId, $couponName, $couponPercent){
            if(this.couponName == "" && this.couponPercent == ""){
                this.couponName = $couponName;
                this.couponPercent = $couponPercent;
            }
            else if(this.couponName == ""){
                this.couponName = $couponName;
            }
            else if(this.couponPercent == ""){
                this.couponPercent = $couponPercent;
            }
            Swal.fire({
                title: "Biztos benne?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Mégse",
                confirmButtonText: "Igen, szerkeztem!",
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("Kupon szerkeztve!");
                    axios.put('/couponEdit/' + $couponId,{
                            couponName: this.couponName,
                            couponPercent: this.couponPercent,
                        })
                    .then(response =>{
                        this.couponsTable.forEach(element => {
                           if(element.id == $couponId){
                                element.couponName = response.data.couponName;
                                element.couponPercent = response.data.couponPercent;
                           }
                        })
                        this.couponName = "";
                        this.couponPercent = "";
                    });
                    this.$modal.hide('coupon-form');
                    }
                });

        },
        //MODEL MEGJELENÍTÉS
        show(event){
            this.couponId = event;
            this.$modal.show('coupon-form');
        },
        //MODEL BEZÁRÁS
        hide(){
            this.$modal.hide('coupon-form');
        }
    }

}
</script>
<style scoped>
.editCoupon{
    cursor: pointer;
}
.buttonStyle{
    background-color: rgba(225,198,153,0.5);
    border: 4px solid rgba(225,198,153);;
    border-radius: 10px;
    font-weight: bolder;
}
.buttonStyle:hover{
    transform: scale(1.1);
}
.buttonStyle:active{
    transform: scale(0.9);
}
.linkStyle{
    background-color: rgba(225,198,153,0.5);
    padding: 7px;
    margin-bottom: 15px;
    border: 4px solid rgba(225,198,153);;
    border-radius: 10px;
    font-weight: bolder;
    text-decoration: none;
    color: black;
}
.linkStyle:hover{
    transform: scale(1.1);
}
.linkStyle:active{
    transform: scale(0.9);
}
.modal-mask{
    background-color: rgba(225,198,153, 0.5);
    font-weight: bolder;
}

</style>
