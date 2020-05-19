<template>
  <div id="edit" class="card card-profile">
    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
      <div class="d-flex justify-content-between"></div>
    </div>

    <div class="card-body pt-0">
      <h6 slot="header" class="modal-title" id="modal-title-default">Rol :{{ roles.display_name }}</h6>
      <br />
      <form :data="roles.id" header-row-class-name="thead-light">
        <div class="form-group">
          <label>name: </label>
          <input class="form-control" v-model="roles.name" />
        </div>
        <div class="form-group">
          <label>display_name</label>
          <input class="form-control" v-model="roles.display_name" />
        </div>
        <!-- roles -->
      </form>
    </div>
  </div>
</template>
<script>
export default {
  props: { roles: {} }
}
</script>
<style></style>
