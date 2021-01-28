const state = {
    badgeCount: 0
},
mutations = {
    cartButton(state){
        state.badgeCount++
    },
    removeButton(state,n){
        state.badgeCount -= n
    },
    sumBridgeCount(state, n){
        state.badgeCount = n
    },
    userLog(state,n){
        state.badgeCount = n
    }
}
export default {
    state,
    mutations
}

