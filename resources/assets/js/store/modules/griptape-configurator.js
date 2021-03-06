export default {
    namespaced: true,
    state: {
        quantity: 0,
        size: null
    },
    getters: {
        getGriptapeQuantity: state => state.quantity,
        getGriptapeSize: state => state.size,
    },
    mutations: {
        setQuantity(state, payload) {
            state.quantity = payload;
        },
        setSize(state, payload) {
            state.size = payload;
        }
    },
    actions: {}
};