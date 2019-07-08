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
    props: ['scholar'],

    data() {
      return {
        userParams: {
          scholar_id: this.scholar.id,
          name: this.scholar.user.name ? this.scholar.user.name : '' ,
          email: this.scholar.user.email ? this.scholar.user.email : '',
          role: this.scholar.user.role ? this.scholar.user.role : '',
          date_of_birth: this.scholar.user.date_of_birth ? this.scholar.user.date_of_birth : '',
          phone_number: this.scholar.user.phone_number ? this.scholar.user.phone_number : '',
          ic_passport_number: this.scholar.user.ic_passport_number ? this.scholar.user.ic_passport_number : '',
          bio: this.scholar.user.bio ? this.scholar.user.bio : '',
          avatar: this.scholar.user.avatar ? this.scholar.user.avatar : '',
        },
        roles: {'0' : 'Admin', '1' : 'Benefactor', '2' : 'Scholar'}
      }
    },
    mounted() {
      this.userListeners()
    },
    methods: {
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
