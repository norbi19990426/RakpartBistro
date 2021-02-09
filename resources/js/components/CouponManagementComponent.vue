<template>
    <div class="container">
        <table>
            <thead>
                <th scope="col"></th>
                <th scope="col">Kupon neve</th>
                <th scope="col">Százalék mennyisége</th>
                <th scope="col">Használhatóság</th>
            </thead>
            <tbody v-for="coupon in allCoupon" :key="coupon.id">
                <tr>
                    <th scope="row">#</th>
                    <td>{{coupon.couponName}}</td>
                    <td>{{coupon.couponPercent}}</td>
                    <td>{{coupon.couponOneUsed}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props:['coupons'],
    data(){
        this.allCoupon = JSON.parse(this.coupons);
        return{

        }
    }

}
</script>
