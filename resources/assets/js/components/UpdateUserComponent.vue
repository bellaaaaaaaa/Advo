<template>
  <div>
    <form v-on:submit.prevent="updateUser" class="col-md-12 ">

      <!-- User Details -->
      <div class='card'>
        <div class='card-body'>
          <div class='row col-md-12'><h5>User Details</h5></div>
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
        </div>
      </div>

      <!-- User Interests -->
      <div class='card'>
        <div class='card-body'>
          <div class='row col-md-12'><h5>Interests</h5></div>
          <select @change='selectInterest()' v-model="selectedInterest" type="submit" class='form-control'>
            <option v-for='interest in interests' :value='interest'>{{ interest.title }}</option>
          </select>
          <div class="row" style="padding: 0px 15px !important;">
            <div style="padding: 5px;" v-for="(interest) in selectedInterests" v-bind:key="interest.id">
              <span :id='interest.id' :value='interest.id' class="badge badge-secondary">{{interest.title}}<i v-on:click="unselectInterest" class="fa fa-close" style="color:white"></i></span>
            </div>
          </div>
        </div>
      </div>

      <report-card-component :report-cards='reportCards' :user-id='userId' v-on:sendReportCards='receiveNewReportCards'></report-card-component>
      
      <funding-target-component :user="user" :user-funding-target='fundingTarget' v-on:sendFts='receiveFts'></funding-target-component>
      <button type='submit' class='btn btn-primary'>Submit</button>

    </form>
  </div>
</template>
<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: ['userId', 'user', 'userBadges', 'reportCards', 'fundingTarget'],

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
          interests: this.selectedInterests,
          reportCards: []
        },
        roles: {'0' : 'Admin', '1' : 'Benefactor', '2' : 'Scholar'},

        selectedInterest: '',
        selectedInterests: [],
        interests: [],
        unselectedInterest: '',

        numNewReportCards: 0,
      }
    },
    mounted() {
      this.getAllInterests(),
      this.getUserInterests(this.userId)
    },
    methods: {
      // User Methods
      updateUser(e){
        const config = { headers: { 'Content-Type': undefined}}

        var formData = new FormData(e.target)
        formData.append('_method', 'PATCH')
        this.userParams.interests = this.selectedInterests
        formData.append('userParams', JSON.stringify(this.userParams))
        if (typeof this.userParams.newReportCards != "undefined") {
          var i;
          for (i = 0; i < this.userParams.newReportCards.length; i++) {
            formData.append("belongs_to_rc_" + this.userParams.newReportCards[i].index, this.userParams.newReportCards[i].file)
          }
        }
        formData.append('avatar', this.userParams.avatar)
        axios.post(`/admin/users/${this.userId}`, formData, config)
        .then(response => {
          	location.href = response.data;
          // window.location = res.data.redirect;
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
      // Interest Methods
      getAllInterests(){
        console.log('getAllInterests')
        axios({method: 'GET', url: `/api/user_interests_options/${this.userId}`}).then(
          result => {
            this.interests = result.data
          }
        )
      },
      getUserInterests(){
        console.log('getUserInterests')
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
        console.log('selectInterest')
        var array = [];
        var i;
        for (i= 0; i < this.selectedInterests.length; i++) {
          array.push(this.selectedInterests[i].id)
        }

        if (array.includes(this.selectedInterest.id) == false ){
          this.selectedInterests.push(this.selectedInterest)
        }
      },
      unselectInterest(event){
        console.log('unselectInterest')
        var unselectedInterestId =  event.target.parentElement.id;
        var x;
        for (x = 0; x < this.selectedInterests.length; x ++){
          if(this.selectedInterests[x].id == unselectedInterestId){
            this.selectedInterests.splice(x, 1)
          }
        }

      },
      receiveNewReportCards(reportCards){
        this.userParams.newReportCards = reportCards;
        console.log('report cards', this.userParams.newReportCards )

      },
      receiveFts(fts){
        this.userParams.fundingTargets = fts;
      }
    }
  }
</script>
