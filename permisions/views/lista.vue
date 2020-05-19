<template>
  <div>
    <base-header class="pb-6">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Ajustes</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <route-bread-crumb></route-bread-crumb>
          </nav>
        </div>
      </div>
    </base-header>

    <div class="container-fluid mt--6">
      <div v-if="show == 1" class="col-auto">
        <upload-component :datos="this.data" @show-component="showComponent"></upload-component>
      </div>
      <div class="card" v-if="show == 0">
        <div class="card-header border-0">
          <div class="row">
            <div class="col-6">
              <h3 class="mb-0">Lista de Roles</h3>
            </div>
            <div class="col-6 text-right">
              <base-button @click="showComponent({ vista: 1, tipo: 0 })" outline type="default">
                <span class="btn-inner--icon">
                  <i class="fas fa-user-plus"></i>
                </span>
                Nuevo Rol
              </base-button>
              <!-- <a
                href="http://localhost:8080/#/permisions/lista"
                @click="showComponent({ vista: 1, tipo: 0 })"
                class="btn btn-outline btn-success btn-sm pull-right"
                >Añadir Rol <i class="fas fa-user-plus" aria-hidden="true"> </i
              ></a> -->
              <!-- Agregar Rol desde Ventana modal -->
              <!--  <base-button class="btn btn-icon btn-primary" @click="modal3 = true">
                <span class="btn-inner--icon">
                  <i class="fas fa-user-plus"></i>
                </span>
                Add Modal
              </base-button> -->
              <!-- fin -->
            </div>
          </div>
          <!-- Busqueda de Roles Por Nombre -->
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <svg class="svg-icon">
                    <use href="#icon-search"></use>
                  </svg>
                </span>
              </div>
              <input placeholder="Buscar" type="text" class="form-control" v-model="textSearch" />
            </div>
          </div>
          <!-- Fin de Busqueda -->
          <div class="card">
            <!-- TABLA LISTA DE ROLES -->
            <template>
              <el-table
                id="my-table"
                :data="RolesFilter.slice(page - 1, page + perPage)"
                header-row-class-name="thead-light"
                style="width: 100%"
              >
                <!-- COLUMNAS DE TABLA  -->
                <el-table-column prop="display_name" label="Nombre del Rol" min-width="130"></el-table-column>
                <el-table-column label=" Permisos" prop="name" min-width="130">
                  <div slot-scope="{ row }" class="table-actions">
                    <a v-bind:href="row.url" target="_blank">
                      <!-- VER ROL (BOTON VIEW) -->
                      <div class="col-md-6">
                        <!--  <base-button block type="primary" class=" mb-3" @click.prevent="ViewPerms(row)">
                          Ver
                        </base-button> -->
                      </div>
                      <!-- VER PERMISOS DEL ROL -->
                      <div class="col-md-6">
                        <a href="" @click.prevent="ViewPerms(row)"><i class="fas fa-eye"></i></a>
                      </div>
                    </a>
                  </div>
                </el-table-column>
                <!-- ACCION (BOTONES EDITAR Y ELIMINAR -->
                <el-table-column prop="name" label="Accion" min-width="100">
                  <template v-slot="{ row }">
                    <a v-bind:href="row.url" target="_blank">
                      <!--------------------- EDITAR ROL  ------------------->
                      <!--  <div class="col-md-8">
                        <base-button block type="primary" class=" mb-3" @click.prevent="onView(row)">
                          Editar
                        </base-button>
                      </div> -->
                      <div class="col-md-8">
                        <a href="" @click.prevent="onView(row)"><i class="fas fa-edit"></i></a>
                      </div>
                      <!--------------------- ELIMINAR ROL  ------------------->
                      <!-- <div class="col-md-8">
                        <base-button block type="primary" class=" mb-3" @click.prevent="onDelete(row)">
                          ELIMINAR
                        </base-button>
                      </div> -->

                      <div class="col-md-8">
                        <a href="" @click.prevent="onDelete(row)"><i class="fas fa-user-times"></i></a>
                      </div>
                      <!-- Añadir Permisos -->
                      <div class="col-md-6">
                        <a href="" @click.prevent="addPermRol(row)"><i class="fas fa-user-tag"></i></a>
                      </div>
                    </a>
                  </template>
                </el-table-column>
              </el-table>
              <!-- VENTANA MODAL PERMISOS ROL -->
              <!--  <form method="POST" v-on:submit.prevent="statusForm(data)"> -->
              <modal :show.sync="modal1" body-classes="p-0" modal-classes="modal-dialog-centered modal-sm">
                <RolPermiso :roles="this.data"> </RolPermiso>

                <template slot="footer">
                  <button class="btn btn-primary" type="submit">
                    <span class="btn-inner--icon"> <i class="fas fa-save"></i> </span> Guardar
                  </button>
                  <base-button type="link" class="ml-auto" @click="modal1 = false"
                    ><i class="fas fa-times"></i> Close
                  </base-button>
                </template>
              </modal>
              <!--   </form>  -->
              <!-- VENTANA MODAL EDITAR ROL   -->
              <form method="POST" v-on:submit.prevent="updateForm(data)">
                <modal :show.sync="modal" body-classes="p-0" modal-classes="modal-dialog-centered modal-sm" id="editar">
                  <VerPermiso :roles="this.data"> </VerPermiso>

                  <template slot="footer">
                    <button type="submit" class="btn btn-primary" @click="modal = false">
                      Actualizar <span class="btn-inner--icon"> <i class="fas fa-retweet"></i> </span>
                    </button>
                    <base-button type="link" class="ml-auto" @click="modal = false"
                      ><i class="fas fa-times"></i> Close
                    </base-button>
                  </template>
                </modal>
              </form>
              <!--ADD Rol Desde Ventana Modal -->
              <form method="POST" @submit.prevent="checkForm()">
                <modal :show.sync="modal3" body-classes="p-0" modal-classes="modal-dialog-centered modal-sm" id="add">
                  <AddRole :roles="this.data"> </AddRole>

                  <template slot="footer">
                    <button type="submit" class="btn btn-primary" @click="modal3 = false">
                      Guardar <span class="btn-inner--icon"> <i class="fas fa-save"></i> </span>
                    </button>
                    <base-button type="link" class="ml-auto" @click="modal3 = false"
                      ><i class="fas fa-times"></i> Close
                    </base-button>
                  </template>
                </modal>
              </form>
              <!-- AÑADIR PERMISOS AL ROL -->
              <modal :show.sync="modal4" body-classes="p-0" modal-classes="modal-dialog-centered modal-sm">
                <AddPermiso :roles="this.data"> </AddPermiso>

                <template slot="footer">
                  <button class="btn btn-primary" type="submit">
                    <span class="btn-inner--icon"> <i class="fas fa-save"></i> </span> Guardar
                  </button>
                  <base-button type="link" class="ml-auto" @click="modal4 = false"
                    ><i class="fas fa-times"></i> Close
                  </base-button>
                </template>
              </modal>
              <!--PAGINACION  -->
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <!-- Boton Adelante -->
                  <li class="page-item">
                    <button type="button" class="page-link" v-if="page != 1" @click="page--">
                      <i class="fas fa-chevron-circle-left"></i>
                    </button>
                  </li>
                  <li class="page-item">
                    <button type="button" class="btn btn-primary btn-circle">
                      {{ page }}
                    </button>
                  </li>
                  <!-- Boton Atras -->
                  <li class="page-item">
                    <button type="button" @click="page++" v-if="page < roles.length" class="page-link">
                      <i class="fas fa-chevron-circle-right"></i>
                    </button>
                  </li>
                </ul>
              </nav>
              <!--  <div>
                <base-pagination :page-count="10" v-model="page"></base-pagination>
              </div> -->
              <!-- Fin ADD ROL MODAL-->
            </template>
            <!-- FIN DE TABLA -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import RouteBreadCrumb from '@/components/Breadcrumb/RouteBreadcrumb'
import uploadComponent from './AddRol'
import { Table, TableColumn, Upload, Button, Pagination } from 'element-ui'
import Swal from 'sweetalert2'
import Modal from '@/components/Modal.vue'
import VerPermiso from './RolesPerms/VerPermisos'
import RolPermiso from './RolesPerms/RolPermisos'
import AddRole from './RolesPerms/AddRoles'
import AddPermiso from './RolesPerms/AddPermisos'
import { $api } from '../../../services/api'
import { BasePagination } from '@/components'

export default {
  name: 'roles-lista',
  components: {
    RouteBreadCrumb,
    [Pagination.name]: Pagination,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    uploadComponent,
    Modal,
    VerPermiso,
    RolPermiso,
    AddRole,
    AddPermiso
  },
  data() {
    return {
      posts: [''],
      page: 1,
      perPage: 2,
      //perPage: 3,
      //currentPage: 1,
      //currentPage: 1,
      data: {},
      roles: [],
      permisos: [],
      show: false,
      modal: false,
      modal1: false,
      modal2: false,
      modal3: false,
      modal4: false,
      textSearch: ''
    }
  },
  computed: {
    displayedPosts() {
      return this.paginate(this.posts)
    },
    //Filtrar Roles de Busqueda Por Nombre
    RolesFilter: function() {
      var textSearch = this.textSearch
      return this.roles.filter(function(el) {
        return el.display_name.toLowerCase().indexOf(textSearch.toLowerCase()) !== -1
      })
    },
    groupRoles() {
      var agrupados = []
      this.roles.forEach(rol => {
        var permisosRol = {
          rol_id: rol.id,
          name: rol.display_name,
          perms: []
        }
        rol.permissions.forEach(permiso => {
          let permisoDb = this.permisos.find(p => p.id == permiso.permission_id)
          if (permisoDb) {
            let permisoName = permisoDb.display_name

            permiso.display_name = permisoName
            permisosRol.perms.push(permiso)
          }
          //console.log(rol.display_name, ' -> ', permiso.permission_id)
        })
        agrupados.push(permisosRol)
      })

      console.log('agrupados', agrupados)

      return agrupados
    }
  },
  methods: {
    setPages() {
      let numberOfPages = Math.ceil(this.posts.length / this.perPage)
      for (let index = 1; index <= numberOfPages; index++) {
        this.roles.push(index)
      }
    },
    paginate(posts) {
      let page = this.page
      let perPage = this.perPage
      let from = page * perPage - perPage
      let to = page * perPage
      return posts.slice(from, to)
    },
    showComponent(value) {
      this.show = value.vista
      this.data = { row: null, btn: 0, tipo: 1 }
      if (this.show == 0) {
        this.contratos = ''
      }
    },
    onView(value) {
      this.data = value
      this.modal = true
    },
    ViewPerms(value) {
      this.data = value
      this.modal1 = true
    },
    addPerms(value) {
      this.data = value
      this.modal3 = value
    },
    addPermRol(value) {
      this.data = value
      this.modal4 = value
    },
    prueba() {
      this.$store.dispatch('permisions/prueba')
    },
    //view Permisos POST STATUS
    formSubmit(e) {
      e.preventDefault()
      let currentObj = this
      $api
        .post('/role-permission', {
          roles: this.roles
        })
        .then(function(response) {
          currentObj.output = response.data
        })
        .catch(function(error) {
          currentObj.output = error
        })
    },
    //ADD ROLE Desde Ventana Modal//
    checkForm() {
      //console.log(roles)
      $api.post('/create-role', {
        name: this.data.name,
        display_name: this.data.display_name
      })

      this.errors = []

      if (!this.data.name) {
        this.errors.push('Campo obligatorio.')
      }
      if (!this.data.display_name) {
        this.errors.push('Campo  obligatoria.')
      }
      Swal.fire('Exito', 'Registro creado correctamente', 'success', {
        // Swal Setting's
      }).then(result => {
        // Reload the Page
        location.reload()
      })
      //Swal.fire('Exito', 'Registro creado correctamente', 'success')
      //window.setTimeout('RecargarPag()', 3000)
      //this.$emit('show-component', { vista: 0 })
      // window.setTimeout(location.reload(), 5000)
    },
    //--DELETE ROL--//
    onDelete(row) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons
        .fire({
          title: 'Estas segura de eliminar el Rol?',
          text: '¡Una Ves que continues ya no Habra Cambios!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Si, Borrar!',
          cancelButtonText: 'No, cancelar!',
          reverseButtons: true
        })
        .then(result => {
          if (result.value) {
            this.$api.delete('/role-permission/' + row.id).then(r => {
              this.roles = this.$store.state.permisions.lista
              swalWithBootstrapButtons
                .fire('Borrado!', 'Su Rol ha sido eliminado.', 'success', {
                  //Swal.fire('Exito', 'Registro creado correctamente', 'success', {
                  // Swal Setting's
                })
                .then(result => {
                  // Reload the Page
                  location.reload()
                })
            })
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire('Cancelado', 'Eliminacion Cancelada')
          }
        })
    },
    //GUARDAR ESTATUS DEL ROL MODEL VIEW
    statusForm(data) {
      $api.put('role-permission/' + data.id, {
        permissions: this.data.permissions
      })
      this.errors = []
      if (!this.data.permissions) {
        this.errors.push('Campo obligatorio.')
      }
      console.log(data)
      Swal.fire('Exito', 'Permiso Actaulizado Correctamente', 'success')
      this.$emit('show-component', { vista: 0 })
    },

    //---EDITAR ROL--///
    updateForm(data) {
      $api.put('role-permission/' + data.id, {
        name: this.data.name,
        display_name: this.data.display_name
      })
      this.errors = []
      if (!this.data.name) {
        this.errors.push('Campo obligatorio.')
      }
      if (!this.data.display_name) {
        this.errors.push('Campo  obligatoria.')
      }
      Swal.fire('Exito', 'Registro Actualizado correctamente', 'success')
      this.$emit('show-component', { vista: 0 })
    }
  },
  /* watch: {
    posts() {
      this.setPages()
    }
  },
  filters: {
    trimWords(value) {
      return (
        value
          .split(' ')
          .splice(0, 20)
          .join(' ') + '...'
      )
    }
  },*/
  created() {
    this.$api.get('/role-permission').then(data => {
      this.roles = data.roles
      console.log(data, 'role-permission')
    }) /*peticiones a la base de datos* */
    this.$api.get('/permission').then(data => {
      this.permisos = data
      console.log(data, 'permission')
    })
  },
  mounted() {
    console.log(this.roles)
  }
}
</script>
<style>
.btn-circle {
  width: 36px;
  height: 36px;
  padding: 7px 0px;
  border-radius: 18px;
  text-align: center;
  font-size: 15px;
  line-height: 1.44857;
}
</style>
