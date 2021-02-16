<template>
    <div class="container">
        <button class="btn btn-primary mb-3" @click="couponsDelete">Kijelölt kuponok törlése</button>
        <table class="table">
            <thead>
                <th scope="col"></th>
                <th scope="col">Kupon</th>
                <th scope="col">Kupon neve</th>
                <th scope="col">Százalék mennyisége</th>
                <th scope="col">Használhatóság</th>
            </thead>
            <tbody v-for="coupon in couponsTable" :key="coupon.id">
                <tr>
                    <td><input type="checkbox" :value="coupon.id"  v-model="selectId"></td>
                    <th scope="row"># {{coupon.id}}</th>
                    <td  @click.prevent="show(coupon.id)">{{coupon.couponName}}</td>
                    <td  @click.prevent="show(coupon.id)">{{coupon.couponPercent}} %</td>
                    <td>
                       <select class="form-control" v-model="coupon.usages_id" @change="changeCouponUsage(coupon.id, coupon.usages_id)">
                           <option v-for="usage in couponUsage" :key="usage.id" :value="usage.id">
                               {{usage.usagesName}}
                           </option>
                       </select>
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
                    <div class="modal-body"  v-for="coupon in couponsTable" :key="coupon.id">
                        <form method="PUT" enctype="multipart/form-data" @submit.prevent="submitCouponEdit(coupon.id,coupon.couponName, coupon.couponPercent)" v-if="couponId == coupon.id">
                            <div class="form-group">
                                <label for="couponName">Kupon elnezevezés:</label>
                                <input type="text" class="form-control" :value="coupon.couponName" @change="couponName = $event.target.value">
                            </div>
                            <div class="form-group">
                                <label for="couponPercent">Százalék mennyisége:</label>
                                <input type="number" class="form-control" :value="coupon.couponPercent" @change="couponPercent = $event.target.value">
                            </div>
                            <button type="submit" class="btn btn-primary">Szerkeztés</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button @click="$modal.hide('coupon-form')">Kilépés</button>
                </div>
            </div>
        </div>
    </modal>
    </div>
</template>
<script>
import Swal from "sweetalert2";

export default {
    props:['coupons', 'usage'],
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
                    });
                    this.$modal.hide('coupon-form');
                    }
                });

        },//MODEL MEGJELENÍTÉS
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
