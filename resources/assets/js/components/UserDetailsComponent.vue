<template>
  <div>
    <div class='row col-md-12'><h5>Details</h5></div>
    <div class='row'>
      <div class='col-md-4'>
        <label>Name</label>
        <input id="name" v-model="userParams.name" class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>Email</label>
        <input id="email" v-model="userParams.email" class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>Role</label>
        <select id="role" v-model="userParams.role" class='form-control'>
          <option v-for='key, value in roles' :value='value'>{{ key }}</option>
        </select>
      </div>
    </div>

    <div class='row'>
      <div class='col-md-4'>
        <label>Date of Birth</label>
        <input id="date_of_birth" v-model="userParams.date_of_birth" type='date' class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>Phone Number</label>
        <input id="phone_number" v-model="userParams.phone_number" class="form-control"></input>
      </div>

      <div class='col-md-4'>
        <label>IC/Passport Number</label>
        <input id="ic_passport_number" v-model="userParams.ic_passport_number" class="form-control"></input>
      </div>
    </div>

    <div class='row'>
      <div class='col-md-6'>
        <label>Bio</label>
        <input id="bio" v-model="userParams.bio" class="form-control"></input>
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
    props: ['userPivot', 'user'],

    data() {
      return {
        userParams: {
          name: ''
        },
        roles: {'0' : 'Admin', '1' : 'Benefactor', '2' : 'Scholar'}
      }
    },
    mounted() {
      this.setDefaults(),
      this.userListeners()
    },
    methods: {
      setDefaults(){
        this.userParams.user_pivot_id = this.userPivot.id
        this.userParams.name = this.userPivot.user.name ? this.userPivot.user.name : ''
        this.userParams.email = this.userPivot.user.email ? this.userPivot.user.email : ''
        this.userParams.role = this.userPivot.user.role ? this.userPivot.user.role : ''
        this.userParams.date_of_birth = this.userPivot.user.date_of_birth ? this.userPivot.user.date_of_birth : ''
        this.userParams.phone_number = this.userPivot.user.phone_number ? this.userPivot.user.phone_number : ''
        this.userParams.ic_passport_number = this.userPivot.user.ic_passport_number ? this.userPivot.user.ic_passport_number : ''
        this.userParams.bio = this.userPivot.bio ? this.userPivot.bio : ''
        this.userParams.avatar = this.userPivot.user.avatar ? this.userPivot.user.avatar : ''
        this.onUserUpdated()
      },
      onInputChange(event) {
        var input = event.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var vm = this;
            reader.onload = function(e) {
                vm.imageSrc = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        if(event.target.id == 'avatar'){
          this.userParams.avatar = input.files[0];
          this.$emit('sendUserInfo', this.userParams);
        }
      },
      userListeners: function(e) {
        let self = this;
        this.id = this.index;
        var timer;
        $("#name").on("keyup", function(event){
          var searchid = $(this).val().trim();

          clearInterval(timer);
          timer = setTimeout(function() {
              self.userParams.name = event.target.value
              self.onUserUpdated();
          }, 200);
        });
        $("#email").on("keyup", function(event){
          var searchid = $(this).val().trim();

          clearInterval(timer);
          timer = setTimeout(function() {
              self.userParams.email = event.target.value
              self.onUserUpdated();
          }, 200);
        });
        $("#role").on('change', function(event) {
          self.userParams.role = event.target.value
          self.onUserUpdated();
        });
        $("#date_of_birth").on('change', function(event) {
          self.userParams.date_of_birth = event.target.value
          self.onUserUpdated();
        });
        $("#phone_number").on("keyup", function(event){
          var searchid = $(this).val().trim();

          clearInterval(timer);
          timer = setTimeout(function() {
              self.userParams.phone_number = event.target.value
              self.onUserUpdated();
          }, 200);
        });
        $("#ic_passport_number").on("keyup", function(event){
          var searchid = $(this).val().trim();

          clearInterval(timer);
          timer = setTimeout(function() {
              self.userParams.ic_passport_number = event.target.value
              self.onUserUpdated();
          }, 200);
        });
        $("#bio").on("keyup", function(event){
          var searchid = $(this).val().trim();

          clearInterval(timer);
          timer = setTimeout(function() {
              self.userParams.bio = event.target.value
              self.onUserUpdated();
          }, 200);
        });
      },
      onUserUpdated(){
        this.$emit('sendUserInfo', this.userParams);
      }
    }
  }
</script>
