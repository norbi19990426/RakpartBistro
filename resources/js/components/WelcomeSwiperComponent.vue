<template>
<div class="swiper" v-swiper="swiperOption">
    <div class="swiper-wrapper">
            <div class="swiper-slide">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo aperiam numquam fugit eius quaerat quibusdam, quae tempora culpa. Adipisci quis mollitia fugit maiores ipsam rerum fuga? Corrupti temporibus aspernatur amet!</p>
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
}
p{
    max-width:800px;
    word-wrap:break-word;
    margin: 5%;
    font-weight: bold;
    color: white;
    font-size:2vw;
}
</style>
