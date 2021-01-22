<template>
    <div>
                <img src="/logo/kosarLogo.png" style="height: 25px;">
                <span class='badge badge-warning'>{{badgeCount}} </span>
    </div>
</template>
<script>
import { mapState } from 'vuex'
export default {

    computed: mapState({
         badgeCount: state => state.count.badgeCount
    }),
}
</script>
