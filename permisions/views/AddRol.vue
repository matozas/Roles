<template>
  <div class="container-fluid mt--6">
    <form id="app" @submit="checkForm" method="POST">
      <div class="card">
        <div class="card-header border-1">
          <div class="row">
            <div class="col-6 ">
              <h3 class="mb-0">Nuevo Rol</h3>
            </div>
            <div class="col-6 text-right">
              <base-button type="primary" icon size="sm" @click="$emit('show-component', { vista: 0 })">
                <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                <span class="btn-inner--text">Regresar</span>
              </base-button>
            </div>
          </div>
        </div>
        <div class="m-5">
          <div class=" justify-content-center">
            <div class="card">
              <template>
                <div class="col-auto">
                  <base-input label="Nombre del Rol" v-model="roles.name" rules="required" name="name" />
                  <base-input label="Display_name" v-model="roles.display_name" rules="required" name="display_name" />
                </div>
              </template>
            </div>

            <!-- <h1>Permisos del Rol</h1>
          <div class="col-auto">
            <div class="card">
              <template>
                <el-table :data="permisos" header-row-class-name="thead-light" style="width: 100%">
                  <el-table-column prop="display_name" label="Nombre del Permiso" min-width="130"> </el-table-column>
                  <el-table-column prop="name" label="Activar" min-width="100">
                    <template v-slot="{ row }">
                      <a v-bind:href="row.url" target="_blank">
                        <label class="custom-toggle">
                          <input type="checkbox" checked />
                          <span
                            class="custom-toggle-slider rounded-circle"
                            data-label-off="No"
                            data-label-on="Si"
                          ></span>
                        </label>
                      </a>
                    </template>
                  </el-table-column>
                </el-table>
              </template>
            </div>
          </div> -->

            <div class="col text-right mt-4">
              <button type="submit" v-if="btn == 0" class="btn btn-success btn-sm">
                <span class="btn-inner--icon"> <i class="fas fa-save"></i> </span>
                Guardar
              </button>
              <base-button type="danger" @click="$emit('show-component', { vista: 0 })" class="btn btn-sm">
                <span class="btn-inner--icon"> <i class="fas fa-reply"></i></span> Regresar</base-button
              >
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
// import RouteBreadCrumb from '@/components/Breadcrumb/RouteBreadcrumb'
// import uploadComponent from './permisos'
import { permisions } from '../api/permisions'
import { ValidationObserver } from 'vee-validate'
import { Table, TableColumn, Upload, Button, Select, Option } from 'element-ui'
import Swal from 'sweetalert2'
import { $api } from '../../../services/api'

export default {
  name: 'permisos-list',
  components: {
    //RouteBreadCrumb,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    //uploadComponent,
    [Select.name]: Select,
    [Option.name]: Option
  },
  props: { datos: {} },
  data() {
    return {
      btn: '',
      invalid: '',
      inva: '',
      data: {},
      show: 0,
      permisos: [],
      roles: {
        name: '',
        display_name: ''
      },
      newName: '',
      newDisplay: '',
      errors: []
    }
  },
  methods: {
    checkForm: function(e) {
      $api.post('/create-role', {
        name: this.roles.name,
        display_name: this.roles.display_name
      })

      this.errors = []

      if (!this.roles.name) {
        this.errors.push('Campo obligatorio.')
      }
      if (!this.roles.display_name) {
        this.errors.push('Campo  obligatoria.')
      }
      e.preventDefault()
      Swal.fire('Exito', 'Registro creado correctamente', 'success', {
        // Swal Setting's
      }).then(result => {
        // Reload the Page
        location.reload()
      })
      //Swal.fire('Exito', 'Registro creado correctamente', 'success')
      //this.$emit('show-component', { vista: 0 }, 'created')
      //location.reload()
    }
  },
  /*crear() {
      this.$store.dispatch('permisions/create', this.roles).then(r => {
        this.roles = {}
        Swal.fire('Exito', 'Registro creado correctamente', 'success')
        this.$emit('show-component', { vista: 0 })
      })
    },*/
  /*crearRole() {
      var url = 'create-role'
      $api
        .post(url, {
          name: this.newName,
          display_name: this.newDisplay
        })
        .then(response => {
          ;(this.newName = ''), (this.newDisplay = '')
          Swal.fire('Exito', 'Registro creado correctamente', 'success')
          this.$emit('show-component', { vista: 0 })
        })
    }
  },*/
  created() {
    /*  this.$api.get('/role-permission').then(data => {
      this.roles = data.roles
      console.log(data, 'role-permission')
    })
    this.$api.get('/permission').then(data => {
      this.permisos = data
      console.log(data, 'permission')
    }) */
  }
}
</script>
