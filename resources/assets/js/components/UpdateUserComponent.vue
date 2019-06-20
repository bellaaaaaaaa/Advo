<template>
  <div>
    <form v-on:submit.prevent="updateUser" class="col-md-12 ">

      <!-- User Details -->
      <div class='row col-md-12'><h4>User Details</h4></div>
      <div class='row'>
        <div class='col-md-4'>
          <label>Name</label>
          <input v-model="userParams.name" class="form-control"></input>
        </div>

        <div class='col-md-4'>
          <label>Email</label>
          <input v-model="userParams.email" class="form-control"></input>
        </div>

        <div class='col-md-4'>
          <label>Role</label>
          <select v-model="userParams.role" type="submit" class='form-control'>
            <option v-for='key, value in roles' :value='value'>{{ key }}</option>
          </select>
        </div>
      </div> <!-- end row -->

      <div class='row'>
        <div class='col-md-4'>
          <label>Date of Birth</label>
          <input v-model="userParams.date_of_birth" type='date' class="form-control"></input>
        </div>

        <div class='col-md-4'>
          <label>Phone Number</label>
          <input v-model="userParams.phone_number" class="form-control"></input>
        </div>

        <div class='col-md-4'>
          <label>IC/Passport Number</label>
          <input v-model="userParams.ic_passport_number" class="form-control"></input>
        </div>
      </div> <!-- end row -->

      <div class='row'>
        <div class='col-md-6'>
          <label>Bio</label>
          <input v-model="userParams.bio" class="form-control"></input>
        </div>
        <div class='col-md-6'>
          <label>Avatar</label>
          <input type="file" v-on:change="onInputChange" class="form-control">
        </div>
      </div>

      <!-- User Badges -->
      <div class='row col-md-12'><label>User Badges</label></div>
      <select @change='selectBadge()' v-model="selectedBadge" type="submit" class='form-control'>
        <option v-for='badge in badges' :value='badge'>{{ badge.title }}</option>
      </select>
      <div class="row" style="padding: 0px 15px !important;">
        <div style="padding: 5px;" v-for="(badge) in selectedBadges" v-bind:key="badge.id">
          <span :id='badge.id' :value='badge.id' class="badge badge-secondary">{{badge.title}}<i v-on:click="unselectBadge" class="fa fa-close" style="color:white"></i></span> <!-- <i v-on:click="deleteUserBadge(badge.id)" class="fa fa-close" style="color:white"></i>-->
        </div>
      </div>

      <!-- User Interests -->
      <div class='row col-md-12'><label>User Interests</label></div>
      <select @change='selectInterest()' v-model="selectedInterest" type="submit" class='form-control'>
        <option v-for='interest in interests' :value='interest'>{{ interest.title }}</option>
      </select>
      <div class="row" style="padding: 0px 15px !important;">
        <div style="padding: 5px;" v-for="(interest) in selectedInterests" v-bind:key="interest.id">
          <span :id='interest.id' :value='interest.id' class="badge badge-secondary">{{interest.title}}<i v-on:click="unselectInterest" class="fa fa-close" style="color:white"></i></span> <!-- <i v-on:click="deleteUserBadge(badge.id)" class="fa fa-close" style="color:white"></i>-->
        </div>
      </div>

      <!-- Report Cards -->
      <div>
      </div>
      <button type='submit' class='btn btn-primary'>Submit</button>

    </form>
  </div>
</template>
<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: ['userId', 'user', 'userBadges'],

    data() {
      return {
        userParams: {
          user_id: this.userId,
          name: this.user.name,
          email: this.user.email,
          role: this.user.role,
          date_of_birth: this.user.date_of_birth,
          phone_number: this.user.phone_number,
          ic_passport_number: this.user.ic_passport_number,
          bio: this.user.bio,
          avatar: this.user.avatar,
          badges: this.selectedBadges,
          interests: this.selectedInterests,
        },
        roles: {'0' : 'Admin', '1' : 'Benefactor', '2' : 'Scholar'},
        selectedBadge: '',
        selectedBadges: [],
        badges: [],
        unselectedBadge: '',

        selectedInterest: '',
        selectedInterests: [],
        interests: [],
        unselectedInterest: ''
      }
    },
    mounted() {
      this.getUser(),
      this.getAllBadges(),
      this.getUserBadges(this.userId),
      this.getAllInterests(),
      this.getUserInterests(this.userId)
    },
    methods: {
      // User Methods
      getUser(){
        axios({method: 'GET', url: `/api/get_user/${this.userId}`}).then(
          result => {
            this.userToEdit = result.data
            console.log(this.userToEdit.name)
          }
        )
      },
      updateUser(e){
        var formData = new FormData(e.target)
        formData.append('_method', 'PATCH')
        this.userParams.badges = this.selectedBadges
        this.userParams.interests = this.selectedInterests
        formData.append('userParams', JSON.stringify(this.userParams))
        axios.post(`/admin/users/${this.userId}`, formData)
        .then(res => {
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
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
        this.userParams.avatar = input.files[0];
      },
      // Badge Methods
      getAllBadges(){
        axios({method: 'GET', url: `/api/user_badges_options/${this.userId}`}).then(
          result => {
            this.badges = result.data
          }
        )
      },
      getUserBadges(){
        axios({method: 'GET', url: `/api/user_badges/${this.userId}`}).then(
          result => {
            this.selectedBadges = result.data
          },
          error => {
            console.log(error)
          }
        )
      },
      selectBadge() {
        var array = [];
        var i;
        for (i= 0; i < this.selectedBadges.length; i++) {
          array.push(this.selectedBadges[i].id)
        }

        if (array.includes(this.selectedBadge.id) == false ){
          this.selectedBadges.push(this.selectedBadge)
        }
        console.log(this.selectedBadges)
      },
      unselectBadge(event){
        console.log('unselected badge id', event.target.parentElement.id)
        var unselectedBadgeId =  event.target.parentElement.id;
        var x;
        for (x = 0; x < this.selectedBadges.length; x ++){
          if(this.selectedBadges[x].id == unselectedBadgeId){
            this.selectedBadges.splice(x, 1)
          }
        }
        console.log('selected badges', this.selectedBadges)

      },
      // Interest Methods
      getAllInterests(){
        axios({method: 'GET', url: `/api/user_interests_options/${this.userId}`}).then(
          result => {
            this.interests = result.data
          }
        )
      },
      getUserInterests(){
        axios({method: 'GET', url: `/api/user_interests/${this.userId}`}).then(
          result => {
            this.selectedInterests = result.data
          },
          error => {
            console.log(error)
          }
        )
      },
      selectInterest() {
        var array = [];
        var i;
        for (i= 0; i < this.selectedInterests.length; i++) {
          array.push(this.selectedInterests[i].id)
        }

        if (array.includes(this.selectedInterest.id) == false ){
          this.selectedInterests.push(this.selectedInterest)
        }
        console.log(this.selectedInterests)
      },
      unselectInterest(event){
        console.log('unselected interest id', event.target.parentElement.id)
        var unselectedInterestId =  event.target.parentElement.id;
        var x;
        for (x = 0; x < this.selectedInterests.length; x ++){
          if(this.selectedInterests[x].id == unselectedInterestId){
            this.selectedInterests.splice(x, 1)
          }
        }
        console.log('selected interests', this.selectedInterests)

      },
      // Report Card Methods
    }
  }
</script>
