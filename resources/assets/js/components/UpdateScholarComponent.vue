<template>
  <div>
    <div class='row col-md-12'><h5>Details</h5></div>
    <div class='row'>
      <div class='col-md-4'>
        <label>Name</label>
        <input v-model="scholarParams.name" class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>Email</label>
        <input v-model="scholarParams.email" class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>Role</label>
        <select v-model="scholarParams.role" class='form-control'>
          <option v-for='key, value in roles' :value='value'>{{ key }}</option>
        </select>
      </div>
    </div> <!-- end row -->

    <div class='row'>
      <div class='col-md-4'>
        <label>Date of Birth</label>
        <input v-model="scholarParams.date_of_birth" type='date' class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>Phone Number</label>
        <input v-model="scholarParams.phone_number" class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>IC/Passport Number</label>
        <input v-model="scholarParams.ic_passport_number" class="form-control"></input>
      </div>
    </div> <!-- end row -->

    <div class='row'>
      <div class='col-md-6'>
        <label>Bio</label>
        <input v-model="scholarParams.bio" class="form-control"></input>
      </div>
      <div class='col-md-6'>
        <label>Avatar</label>
        <input id="avatar" type="file" v-on:change="onInputChange" class="form-control">
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: [],

    data() {
      return {
      }
    },
    mounted() {
    },
    methods: {
    }
  }
</script>
