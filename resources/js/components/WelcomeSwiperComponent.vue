<template>
<div class="swiper" v-swiper="swiperOption">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <div>
                <p>Ételrendelés, kiszállítás</p>
                <p>Kóstoltad már az egyedi ízvilágú ételeinket? Ha még nem, vagy szeretnéd feleleveníteni az élményt, most otthonodban is megkóstolhatod a Rakpart Bistro különleges és nem mindennapi fogásait! Add le a rendelésed és gyere érte éttermünkbe vagy rendelj házhoz, ételeinket Debrecen területén bárhova elvisszük. Rendelés leadás a 06-30-1111111-es telefonszámon 9:30 és 19:30 között lehetséges.</p>
                <a :href="menuRoute" type="button" class="welcomeMenuButton">Menü</a>
            </div>
        </div>
        <div class="swiper-slide">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta, unde alias consequatur aperiam ea eos ullam consectetur fugit similique optio temporibus delectus. Facere magnam at quasi iusto maxime! Aut, deleniti?</p>
        </div>
        <div class="swiper-slide">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis libero, quidem consectetur corrupti dolores voluptas sed vero id facere, cumque odit vitae aspernatur at eaque voluptatem iure ab est impedit.</p>
        </div>
    </div>
    <div class="swiper-pagination swiper-pagination-white" slot="pagination"></div>
    <div class="swiper-button-prev swiper-button-white" slot="button-prev"></div>
    <div class="swiper-button-next swiper-button-white" slot="button-next"></div>
</div>
</template>

<script>
 import { directive } from 'vue-awesome-swiper'
import 'swiper/swiper-bundle.min.css'
export default {
  directives: {
    swiper: directive
  },
props:['menuRoute'],
data() {
    return {
        swiperOption: {
          spaceBetween: 30,
          centeredSlides: true,
          autoplay: {
            delay: 3500,
            disableOnInteraction: false
          },
          pagination: {
            el: '.swiper-pagination',
            clickable: true
          },
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
          }
        }
      }
    }
}
</script>
<style lang="scss" scoped>
.welcome{
    width: 100%;
    max-height: 100vh;
    margin: auto;
}
.swiper {
    background-color: rgb(0,0,0, 0.4);
    width: 100%;
    height: 660px;
}
.swiper-slide{
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
}
p{
    max-width:800px;
    word-wrap:break-word;
    font-weight: bold;
    font-size: 1.5vw;
}
.welcomeMenuButton{
    background-color: rgba(225,198,153,0.5);
    border: 4px solid rgba(225,198,153);
    border-radius: 10px;
    padding: 10px;
    color: white;
    font-weight: bolder;
    text-decoration: none;
}
.welcomeMenuButton:hover{
    transform: scale(1.1);
}
.welcomeMenuButton:active{
    transform: scale(0.9);
}
</style>
