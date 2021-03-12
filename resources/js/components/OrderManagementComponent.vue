<template>
<div class="container-fluid">
    <button class="btn btn-primary mb-3" @click="ordersDelete">Kijelölt rendelések törlése</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Rendelés</th>
                <th scope="col">Rendelés időpontja</th>
                <th scope="col">Vásárló</th>
                <th scope="col">Email</th>
                <th scope="col">Telefonszám</th>
                <th scope="col">Teljes összeg</th>
                <th scope="col">Státusz</th>
            </tr>
        </thead>
              <tbody v-for="order in ordersTable" :key="order.id" >
                <tr>
                    <td><input type="checkbox" :value="order.id"  v-model="selectId"></td>
                    <th class="orderInfoTable" @click.prevent="show(order.id)" scope="row">#{{order.id}}</th>
                    <td class="orderInfoTable" @click.prevent="show(order.id)">{{order.created_at}}</td>
                    <td class="orderInfoTable" @click.prevent="show(order.id)">{{order.vezeteknev}} {{order.keresztnev}}</td>
                    <td class="orderInfoTable" @click.prevent="show(order.id)">{{order.email}}</td>
                    <td class="orderInfoTable" @click.prevent="show(order.id)">{{order.telefonszam}}</td>
                    <td class="orderInfoTable" @click.prevent="show(order.id)">{{order.totalPrice}} HUF</td>
                    <td>
                       <select class="form-control" v-model="order.status" @change="changeOrderStatus(order.id, order.status)" >
                           <option v-for="status in statuses" :key="status.id" :value="status.id">
                                {{status.statusName}}
                           </option>
                        </select>
                    </td>
                </tr>
        </tbody>
    </table>
    <modal name="order-info" id="order_info" height="auto" >
        <div class="modal-mask">
            <div class="modal-container" >
                <div class="modal-header">
                    <h3>Rendelés információk</h3>
                </div>
                <div  v-for="order in ordersTable" :key="order.id">
                    <div class="modal-body" v-if="orderId == order.id">
                        <table>
                            <thead>
                                    <th scope="col" class="pr-5">Rendelő neve:</th>
                                    <th scope="col">Város:</th>
                                    <th scope="col">Lakcím:</th>
                            </thead>
                            <tbody>
                                    <td >{{order.vezeteknev}} {{order.keresztnev}} </td>
                                    <td class="pr-5">{{order.varos}}, {{order.iranyitoszam}}</td>
                                    <td>{{order.address}}</td>
                            </tbody>

                        </table>
                        <h5 class="mt-3"><strong>Rendelő megjegyzés:</strong></h5>
                        <p class="messageText">{{order.message}}</p>
                        <h5 class="mt-3"><strong>Kupon:</strong></h5>
                        <div v-for="coupon in allCoupon" :key="coupon.id">
                            <div v-if="coupon.id === order.coupon_id">
                               <p>Kupon neve: {{coupon.couponName}}</p>
                                <p>Százalék: {{coupon.couponPercent}} %</p>
                            </div>
                        </div>
                        <h5 class="mt-3"><strong>Megrendelés összesítő:</strong></h5>
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Étel</th>
                                    <th scope="col">Darab</th>
                                </tr>
                            </thead>
                            <tbody v-for="foodItem in orderItemsTable">
                                <tr v-if="foodItem.order_id === orderId">
                                    <th class="pr-5" scope="row" >#</th>
                                    <td class="pr-5">{{foodItem.foodName}}</td>
                                    <td class="pr-5">{{foodItem.qty}}</td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button @click="$modal.hide('order-info')">Kilépés</button>
                </div>
            </div>
        </div>
    </modal>
</div>
</template>
<script>
import Swal from "sweetalert2";
export default {
    props:['orderManagement','orderItems', 'food', 'orderStatuses', 'coupons'],
    data() {
        this.statuses = JSON.parse(this.orderStatuses);
        this.orders = JSON.parse(this.orderManagement);
        this.orderItem = JSON.parse(this.orderItems);
        this.foodItem = JSON.parse(this.food);
        this.allCoupon = JSON.parse(this.coupons);
        return{
            selectOption: [],
            selectId: [],
            ordersTable: [],
            orderItemsTable: [{
                foodName: "",
                qty: 0,
                price: 0
                }],
            orderId: 0,
            duplicate: false
        }
    },
    beforeMount(){
        this.getOrdersTable();
    },
    methods:{
        //A BEJÖVŐ ORDEREKET BELERAKOM EGY TÖMBBE
        getOrdersTable:function(){
            this.ordersTable = this.orders;
        },
        //AZ ORDER STÁTUSZ ÁLLÍTÓDIK ITT. (ELKÉSZÍTÉS ALATT, KISZÁLLÍTÁS ALATT, KISZÁLLÍTVA)
        changeOrderStatus(orderId, statusId){
            axios.put('/status/' + orderId + "/" +statusId);
        },
        //KIJELÖLT ORDEREKET TÖRLI
        ordersDelete(){
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
                    Swal.fire("Termék törölve!");
                this.selectId.forEach(element => {
                    this.ordersTable.forEach((x,y) => {//id és az index párja
                        if(element == x.id){
                        axios.delete("/orderRemove/" + x.id);
                        this.ordersTable.splice(y, 1);
                        }
                    })
                });
                }
            });
        },
        //MODEL MEGJELENÍTÉS, ÉS A BENNE LÉVŐ ADATOK FELDOLGOZÁSA
        show(event){
            this.orderId = event;
            let keys = Object.keys(this.orderItemsTable);
            keys.forEach(key => {
            let item = this.orderItemsTable[key];
                if(item.order_id === this.orderId){
                  this.duplicate = true;
                }
            })
            this.orderItem.forEach(orderItemElement => {
                this.foodItem.forEach(foodItemElement => {
                    if(orderItemElement.food_id === foodItemElement.id && orderItemElement.order_id === this.orderId && this.duplicate !== true ){
                        this.orderItemsTable.push({
                            order_id: this.orderId,
                            foodName: foodItemElement.foodName,
                            qty: orderItemElement.qty,
                            price: foodItemElement.price
                        })
                    }
                })
            })
            this.duplicate = false;
            this.$modal.show('order-info');
        },
        //MODEL KILÉPÉS
        hide(){
            this.$modal.hide('order-info');
        }
    },
}
</script>
<style>
.messageText{
    max-width:550px;
    word-wrap:break-word;
}
#order_info{
    overflow: scroll;
}
.orderInfoTable{
    cursor: pointer;
}
</style>
