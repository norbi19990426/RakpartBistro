const state = {
    badgeCount: 0
},
mutations = {
    cartButton(state){
        state.badgeCount++
    },
    sumButton(state){
        state.badgeCount++
        },
    subButton(state){
        state.badgeCount--
    },
    removeButton(state,n){
        state.badgeCount -= n
    }
}
export default {
    state,
    mutations
}
