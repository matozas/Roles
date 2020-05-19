import { permisions, prueba } from './api/permisions'
const state = {
  contratos: [],
  permisos: []
}

const getters = {
  errors: state => state.errors
}

//this.$store.commit('clientes/updateProspectos', {...})
const mutations = {
  updateContratos: (state, d) => {
    state.contratos = d
  },
  updatePermisos: (state, d) => {
    state.permisos = d
  },
  contraStateDelate: (state, d) => {
    state.contratos = d
  }
}

//this.$store.dispatch('clientes/list', {...})
const actions = {
  prueba({ commit }) {
    return new Promise((resolve, reject) => {
      prueba
        .list()
        .then(d => {
          console.log(d, 'prueba api')
          resolve(d)
        })
        .catch(error => {
          console.log(error)
        })
    })
  },
  create({ commit }, data) {
    permisions.create(data).then(d => {
      commit('contraStateDelate')
      commit('updateContratos', d)
    })
  },
  list({ commit }) {
    return new Promise((resolve, reject) => {
      permisions
        .list()
        .then(d => {
          commit('updateContratos', d)
          resolve(d)
        })
        .catch(error => {
          console.log(error)
        })
    })
  },
  update({ commit }, v) {
    return new Promise((resolve, reject) => {
      permisions
        .update(v, v.id)
        .then(d => {
          if (v.tipo == 0) {
            commit('updateContratos', d)
          }
          if (v.tipo == 1) {
            commit('updatePermisos', d)
          }
          resolve(d)
        })
        .catch(error => {
          console.log(error)
        })
    })
  },
  delete({ commit }, id) {
    return new Promise((resolve, reject) => {
      permisions
        .delete(id)
        .then(d => {
          commit('updateContratos', d)
          resolve(d)
        })
        .catch(error => {
          console.log(error)
        })
    })
  }
}

export default {
  moduleName: 'permisions',
  namespaced: true,
  root: true,
  state,
  getters,
  mutations,
  actions
}
