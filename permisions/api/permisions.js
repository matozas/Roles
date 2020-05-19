import { $api, baseModel } from '@/services/api'
/**
 * Genera los métodos comúnes para este recurso.
 *      list(params):    get(`/${resource}`, { params })
 *          find(id):    get(`/${resource}/${id}`)
 *      create(data):   post(`/${resource}/`, data)
 *  update(id, data):    put(`/${resource}/${id}`, data)
 *        delete(id): delete(`/${resource}/${id}`)
 */
export const permisions = baseModel('permisions')
export const roles = baseModel('role-permission')
export const prueba = baseModel('test')
/*export const plantillas = baseModel('plantillas')
/*export const empleadoTeams = baseModel('employees/employee-teams')
export const empleadoDocs = baseModel('employees/employee-docs')
export const empleadoDepartment = baseModel('employees/department')

/**
 * Empleados
 */
/* herramientas.me = () => {
  return $api.get('/auth/me')
}*/
roles.crear = data => {
  return $api.post('create-role', data)
}

prueba.test = () => {
  return $api.get('test')
}
/*
/**
 * Empleados Docs
 */
/*herramientasDocs.download = id => {
  // new window /employees/employee-docs/download/{id}
}

/**
 * Empleados Departamentos
 */
/*herramientasDepartment.quickStore = data => {
  return $api.post('/employees/department/quick-store', data)
} */
