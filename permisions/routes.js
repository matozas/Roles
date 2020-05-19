import { DashboardLayout } from '@app/app-core/async-layouts'

const routes = [
  {
    path: '/permisions',
    component: DashboardLayout,
    name: 'Roles y Permisos',
    redirect: '/permisions/lista',
    children: [
      {
        path: 'lista',
        component: () => import(/* webpackChunkName: "empleados" */ './views/lista.vue'),
        name: 'Roles',
        meta: { title: 'Lista de Permisos', icon: 'list' }
      },
      {
        path: 'AddRol',
        component: () => import(/* webpackChunkName: "empleados" */ './views/AddRol'),
        name: 'RolesPermisosList',
        meta: { title: 'Nuevo Rol', noCache: true, activeMenu: './views/lista.vue' },
        hidden: true
      }
    ]
  }
]

export default routes
