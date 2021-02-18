import Vue from 'vue'
import Vuex from 'vuex'
import count from './modules/count'
import starRate from './modules/starRate'

Vue.use(Vuex);
import createPersistedState from "vuex-persistedstate";

const store = new Vuex.Store({
    modules: {
        count,
        starRate
    },
    plugins: [createPersistedState()],
});
export default store

