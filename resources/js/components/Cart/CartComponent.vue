<template>
<div class="container-fluid" >
    <div v-show="emptyCart">
        <h1>Még nincs terméke</h1>
    </div>
    <div v-show="!emptyCart">
        <div class="row" v-show="(hideCart)">
        <div class="col-md-8" >
            <div v-for="foodItem in cartFood" :key="foodItem.id">
                <cart-item-component
                @total-price="getCartItemData"
                @remove="getRemove"
                @badgeCount="getQuantity"
                :user-id="(userId)"
                :food="JSON.stringify(foodItem)">
                </cart-item-component>
            </div>
        </div>
            <div class="col-md-4">
                <div>
                    <h5>A KOSÁR ÖSSZESEN</h5>
                </div>
                <div>
                    TELJES ÖSSZEG: {{totalPrice}} HUF
                </div>
                <div v-if="couponPrice !== 1">
                    <div>
                    TELJES ÖSSZEG KUPONNAL: {{couponTotalPrice}} HUF
                    </div>
                    <div>
                    Használt kupon: {{couponName}}
                    </div>
                    <div>
                        Százalék: {{couponPercent}}%
                    </div>
                </div>
                <form class="mt-3" v-show="coupon" method="POST" enctype="multipart/form-data" @submit.prevent="getCoupon()">
                    <div class="form-group">
                        <input class="form-control form-control-lg" :disabled="usedCoupon" v-model="couponText" type="text" placeholder="Kuponkód">
                    </div>
                    <div class="form-group">
                        <button type="submit" :disabled="usedCoupon" class="btn btn-primary">Kupon beváltása</button>
                    </div>
                </form>
                <button class="btn btn-primary" @click="checkoutButton">Tovább a pénztárhoz</button>
                <!--<a class="btn btn-primary" v-bind:href="menuRoute">Vissza a menübe</a>-->
            </div>
            <div class="pt-2 pl-2 col-md-8" style="border-top: 1px black solid" >
            </div>
        </div>
        <div v-show="(hideCheckout)">
            <div v-if="hideCart == false">
                <checkout-component
                @checkout="getCart"
                :checkout-food-id="JSON.stringify(checkout)"
                :payment-route="(paymentRoute)"
                :total-price="(couponTotalPrice)"
                :ordered="(ordered)"
                :check="(check)"
                :coupons="(coupons)"
                :coupon-id="(couponId)">
                </checkout-component>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import CartItemComponent from "./CartItemComponent";
import CheckoutComponent from './CheckoutComponent.vue';
import Swal from "sweetalert2";
export default {
    props: ['cart', 'userId', 'paymentRoute', 'ordered', 'check', 'coupons', 'usedCoupons', 'couponUsedOnce'],
    components: { CartItemComponent, CheckoutComponent},
    data(){
        this.allCoupon = JSON.parse(this.coupons);
        this.cartFood = JSON.parse(this.cart);
        this.allUsedCoupons = JSON.parse(this.usedCoupons);
        this.allCouponUsedOnce = JSON.parse(this.couponUsedOnce);
        return {
            emptyCart: this.cartFood.length === 0,
            hideCart: true,
            hideCheckout: false,
            totalPrice: 0,
            couponTotalPrice: 0,
            badgeCount: 0,
            cartItemsData: [],
            cartItemsCount: [],
            checkout: [],
            coupon: false,
            couponText: "",
            correctOrFailCoupon:false,
            couponPrice: 1,
            usedCoupon: false,
            couponId: 0,
            couponOnceUsed: true,
            couponName: "",
            couponPercent: 0
        }
    },
    beforeMount(){
        this.getDefaultCoupon();
        this.defaultTotalPrice();
        this.defaultTotalCount();
        this.getUserOrdered();
    },
    created(){
        this.sumTotalPrice();
        this.defaultTotalPrice();
        this.sumBridgeCount();
        this.defaultTotalCount();
    },
    methods: {
        //MEGNÉZI, HOGY A BEÍRT KUPON LÉTEZIK-E A COUPON_USED_ONCE TÁBLÁBA
        getCouponUsedOnce(){
            this.couponOnceUsed = true;
             this.allCoupon.forEach(element => {
                if(this.couponText === element.couponName){
                    this.allCouponUsedOnce.forEach(usedOnceElement => {
                        if(usedOnceElement.user_id == this.userId && usedOnceElement.coupon_id == element.id){
                        this.couponOnceUsed = false;
                        }
                    })
                }
            })
        },
        //ELKÜLD EGY POSTOT AZ USER_ID-VAL ÉS A COUPON_ID-VAL ÉS BELERAKJA A USED_COUPONS ÉS A COUPON_USED_ONCE TÁBLÁBA.
        //ELDÖNTI HOGY LÉTEZIK-E A MEGADOTT KUPONKÓD VAGY HOGY AZ EGYSZER FELHASZNÁLHATÓ KUPONT FELHASZNÁLTA-E MÁR A USER
        //HA FELHASZNÁLÓ BEÍR EGY KUPOONT AKKOR ITT FOGJA LETILTANI IS A MEZŐT
        getCoupon(){
            this.getCouponUsedOnce();
            this.correctOrFailCoupon = false;
            this.allCoupon.forEach(element => {
                if(this.couponText === element.couponName && this.couponOnceUsed === true){
                            this.correctOrFailCoupon = true;
                            axios.post('/userUseCoupon/' + this.userId + "/" + element.id)
                                .then(response => {
                                    this.couponId= element.id,
                                    this.usedCoupon = true;
                                    this.couponName = element.couponName;
                                    this.couponPercent = element.couponPercent;
                            });
                            if(element.usages_id === 1){
                            axios.post('/couponUseOnce/' + this.userId + "/" + element.id)
                                .then(response =>{
                                    console.log(response.data);
                                }).catch(error => {
                                    console.log(error.response)
                                });
                            }
                            this.couponPrice = 1-element.couponPercent/100;
                            this.couponTotalPrice = this.totalPrice*this.couponPrice;
                }
            })
            if(this.correctOrFailCoupon == false){
                Swal.fire({
                        icon: 'error',
                        title: 'Helytelen kuponkód!',
                })
            }
        },
        //ELDÖNTI HOGY A USER RENDELT-E MÁR VAGY SEM
        getUserOrdered(){
            if(this.check == true){
                this.getOrdered = JSON.parse(this.ordered);
                this.getOrdered.forEach(element => {
                this.userOrdered = element.ordered;
            });
            }
            if(this.userOrdered == 1){
                this.coupon = true;
            }
        },
        //HA A USER HASZNÁLT MÁR KUPONT EZ FOGJA ELLENŐRIZNI ÉS BEÁLLÍTANI A KUPON SZÁZALÉKOT
        getDefaultCoupon(){
            this.allUsedCoupons.forEach(usedCouponElement =>{
                this.allCoupon.forEach(couponElement => {
                    if(usedCouponElement.user_id == this.userId && usedCouponElement.coupon_id == couponElement.id){
                        this.couponPrice = 1-couponElement.couponPercent/100;
                        this.usedCoupon = true;
                        this.couponId = usedCouponElement.coupon_id;
                        this.couponName = couponElement.couponName;
                        this.couponPercent = couponElement.couponPercent;
                    }
                })
            })
        },
        //EZ A CART-RÓL A CHECKOUTRA MENŐ BUTTON
        checkoutButton(){
            this.hideCart = false;
            this.hideCheckout = true;
        },
        //EZ A KASSZÁRÓL VALÓ VISSZATÉRÉST KEZELI (WATCH)
        getCart(){
            this.hideCart = true;
            this.hideCheckout = false;
        },
        //EZ TÁROLJA EL A CARTITEM-RŐL JÖVŐ ADATOKAT(TOTALPRICE)
        getCartItemData: function(cartItemData) {
            this.cartItemsData[cartItemData.id] = cartItemData.sub_total;
            this.sumTotalPrice();
        },
        //EZ HA TÖRÖLNEK EGY ITEMET KIVONJA AZ ÖSSZÉRTÉKBŐL
        getRemove:function(cartItemData){
            this.cartItemsData[cartItemData.id] = cartItemData.sub_total;
            this.checkout[cartItemData.id] = null;
            this.sumTotalPrice();
        },
        //EZ AZ ÁRAK ÖSSZEADÁSA
        sumTotalPrice(){
            this.totalPrice = 0;
            this.couponTotalPrice = 0;
            this.cartItemsData.forEach(cartItemData => {
                this.totalPrice += cartItemData;
            });
                this.couponTotalPrice = this.totalPrice*this.couponPrice;
        },
        //EZ TARTJA MEG AZ ÖSSZÉRTÉK ÉRTÉKÉT
        defaultTotalPrice(){
            let keys = Object.keys(this.cartFood);
            keys.forEach(key => {
            let item = this.cartFood[key];
            this.cartItemsData[item.id] = item.price*item.quantity;
            this.sumTotalPrice();
            });
        },
        //EZ TÁROLJA EL A QUANTITY-T + FELHASZNÁLTAM A CHECKOUT-HOZ ÖSSZESÍTŐ KIJELZÉSÉBEN
        getQuantity(cartItemCount){
            this.cartItemsCount[cartItemCount.id] =  cartItemCount.quantityCount;

            this.checkout[cartItemCount.id] = [{'id': cartItemCount.id,'foodName': cartItemCount.name, 'qty' : cartItemCount.quantityCount, 'price': cartItemCount.price}]

            this.sumBridgeCount();
        },
        //QUANTITY-T SZÁMOLJA ÖSSZE ÉS KÜLDI EL A VUEX-BE, HOGY A BADGECOUNT MEGKAPJA
        sumBridgeCount(){
            this.badgeCount = 0;
            this.cartItemsCount.forEach(cartItemCount =>{
                this.badgeCount += cartItemCount;
            });

            this.$store.commit("sumBridgeCount",this.badgeCount);
        },
        //EZ TÁROLJA EL A BUDGECOUNT-OT + EZT IS FELHASZNÁLTAM A CHECKOUT TÁROLT ADATAIHOZ
        defaultTotalCount(){
            let keys = Object.keys(this.cartFood);
            keys.forEach(key => {
            let item = this.cartFood[key];
            this.cartItemsCount[item.id] = item.quantity;
            this.checkout[item.id] = [{'id': item.id,'foodName': item.name, 'qty' : item.quantity, 'price': item.price}];
            this.sumBridgeCount();
            });
        }
    }
}
</script>
<style scoped>
</style>
