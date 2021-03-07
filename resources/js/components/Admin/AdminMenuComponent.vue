<template>
 <div>
   <nav class="main-nav">
     <admin-button-component></admin-button-component>
   </nav>

   <sidebar-component>
     <ul class="sidebar-panel-nav">
       <li><a v-bind:href="createCategory">Ételkategória</a></li>
       <li><a v-bind:href="createFood">Új étel</a></li>
       <li><a v-bind:href="orderManagement">Rendelések</a></li>
       <li><a v-bind:href="createCoupon">Új kupon</a></li>
        <li><a v-bind:href="couponManagement">Kuponok</a></li>
     </ul>
   </sidebar-component>
 </div>
</template>
<script>
import AdminButtonComponent from './AdminButtonComponent.vue';
import SidebarComponent from './SidebarComponent.vue';

export default {
    props:['createCategory', 'createFood', 'orderManagement', 'createCoupon', 'couponManagement'],
    components: {
    AdminButtonComponent,
    SidebarComponent
    }
}
</script>
<style>
/*  .logo {
   align-self: center;
   color: #fff;
   font-weight: bold;
   font-family: 'Lato'
 } */

 .main-nav {
   display: flex;
   justify-content: space-between;
   padding: 0.5rem 0.8rem;
 }

 ul.sidebar-panel-nav {
   list-style-type: none;
 }

 ul.sidebar-panel-nav > li > a {
   color: #fff;
   text-decoration: none;
   font-size: 1.5rem;
   display: block;
   padding-bottom: 0.5em;
 }
</style>
