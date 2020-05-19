<template>
  <div id="card" class="card card-profile">
    <div class="card-header text-center border-0 pt-8 pt-md-2 pb-0 pb-md-2">
      <div class="d-flex justify-content-between"></div>
    </div>

    <div class="card-body pt-0">
      <h6 slot="header" class="modal-title" id="modal-title-default">
        Rol : {{ roles.display_name }}
        <!-- <button type="button" data-dismiss="modal1" aria-label="Close" class="close"><span>×</span></button> -->
      </h6>
      <br />
      <h1 class="text-center">Permisos</h1>
      <div class="col-auto">
        <div>
          <button @click="selectAll"></button>
          <button @click="DeselectAll"></button>
          <!--<input type="checkbox" @click="selectAll" /> -->
          Marcar Todos
        </div>
        <div>
          <template>
            <el-table :data="roles.permissions" style="width:100%">
              <el-table-column prop="permission_id" label="Nombre" width="180"> </el-table-column>
              <el-table-column prop="status" label="Activo">
                <template v-slot="{ row }">
                  <a v-bind:href="row.url" target="_blank">
                    <label class="custom-toggle">
                      <input type="checkbox" v-on:change="toggle(row)" v-bind:checked="row.status" />
                      <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Si"></span>
                    </label>
                    {{ row.status }}
                  </a>
                </template>
              </el-table-column>
            </el-table>
          </template>
          <!--  <template>
            <el-table :data="permisos" style="width:100%">
              <el-table-column prop="display_name" label="Nombre" width="180"> </el-table-column>
              <el-table-column prop="status" label="Activo">
                <template v-slot="{ row }">
                  <a v-bind:href="row.url" target="_blank">
                    <label class="custom-toggle">
                      <input type="checkbox" v-on:change="toggle(row)" v-bind:checked="row.status" />
                      <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Si"></span>
                    </label>
                    {{ row.status }}
                  </a>
                </template>
              </el-table-column>
            </el-table>
          </template> -->
        </div>

        <!-- <h2>prueba {{ selectedPermisos }}</h2> -->
        <!-- <div class="card">
          <template>
            <el-table :data="roles.permissions" style="width:100%">
              <el-table-column prop="permission_id" label="Nombre" width="180"> </el-table-column>
              <el-table-column prop="status" label="Activo">
                <template v-slot="{ row }">
                  <a v-bind:href="row.url" target="_blank">
                    <label class="custom-toggle">
                      <input type="checkbox" v-on:change="toggle(row)" v-bind:checked="row.status" />
                      <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Si"></span>
                    </label>
                    {{ row.status }}
                  </a>
                </template>
              </el-table-column>
            </el-table>
          </template>
        </div> -->
      </div>
    </div>
  </div>
</template>
<script>
import { Table, TableColumn, Upload, Button } from 'element-ui'
export default {
  props: {
    roles: {}
  },
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn
  },
  data() {
    return {
      permisos: [],
      data: {},
      //permisos: [],
      checked: []
    }
  },
  computed: {
    selectedPermisos() {
      return this.roles.permissions.filter(event => event.status)
    }
  },
  methods: {
    toggle(row) {
      row.status = !row.status
      console.log(row.status)
    },
    selectAll() {
      this.roles.permissions.forEach(event => (event.status = true))
    },
    DeselectAll() {
      this.roles.permissions.forEach(event => (event.status = false))
    }
  },
  created() {
    this.$api.get('/permission').then(data => {
      this.permisos = data
      console.log(data, 'permission')
    })
  }
}
</script>
<style></style>
