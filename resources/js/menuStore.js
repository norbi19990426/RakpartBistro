import Vue from "vue";

export const menuStore = Vue.observable({
    isNavOpen: false
});
export const mutations = {
    toggleNav() {
        menuStore.isNavOpen = !menuStore.isNavOpen
    }
};
