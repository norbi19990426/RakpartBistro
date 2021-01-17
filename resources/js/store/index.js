import Vue from 'vue'
import Vuex from 'vuex'
import count from './modules/count'

Vue.use(Vuex);
import createPersistedState from "vuex-persistedstate";

const store = new Vuex.Store({
    modules: {
        count
    },
    plugins: [createPersistedState()],
});
export default store

