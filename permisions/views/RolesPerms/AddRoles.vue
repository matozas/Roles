<template>
  <div id="app" class="card card-profile">
    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
      <div class="d-flex justify-content-between"></div>
    </div>

    <div class="card-body pt-0">
      <h6 slot="header" class="modal-title" id="modal-title-default">Nuevo Rol</h6>
      <br />

      <div class="col-auto">
        <template>
          <base-input label="Nombre del Rol" v-model="roles.name" rules="required" name="name" />
          <base-input label="Display_name" v-model="roles.display_name" rules="required" name="display_name" />
        </template>
      </div>
      <!-- roles -->
    </div>
  </div>
</template>
<script>
export default {
  props: { roles: {} }
}
</script>
<style></style>
