import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        apiURL: 'http://localhost:8000/api',
        serverPath: 'http://localhost:8000',

        isCategory: false
    },
    mutations: {
        isCategory(state,payload){
			state.isCategory=payload;
		},
    },
    actions: {
        isCategory(context, payload) {
			context.commit('isCategory', payload);
		},
    },
})