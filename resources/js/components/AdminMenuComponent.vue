<template>
 <div>
   <nav class="main-nav">
     <admin-button-component></admin-button-component>
   </nav>

   <sidebar-component>
     <ul class="sidebar-panel-nav">
       <li><a href="#home">Home</a></li>
       <li><a href="#about">About</a></li>
       <li><a href="#contact">Contact</a></li>
     </ul>
   </sidebar-component>
 </div>
</template>
<script>
import AdminButtonComponent from './AdminButtonComponent.vue';
import SidebarComponent from './SidebarComponent.vue';

export default {
 components: {
   AdminButtonComponent,
   SidebarComponent
 }
}
</script>
<style>
 .logo {
   align-self: center;
   color: #fff;
   font-weight: bold;
   font-family: 'Lato'
 }

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
