const state = {
    whenUserRating: false
},
mutations = {
    putRating(state){
        state.whenUserRating = true;
    },
    sendRating(state){
        state.whenUserRating = true;
    },
    avgRating(state){
        state.whenUserRating = false;
    }
}
export default {
    state,
    mutations
}
