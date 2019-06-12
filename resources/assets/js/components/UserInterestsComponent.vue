<template>
  <div class="card col-md-10 offset-md-1">
    <div class="row" style="padding: 15px;">
      <h4 class="col-md-2" style="margin: 0">Interests</h4>
      <form v-on:submit.prevent="addUserInterest()" class="input-group col-md-8">
        <select v-model="newUserInterest.interest_id" type="submit" class='form-control'>
          <option v-for='interest in interests' :value='interest.id'>{{ interest.title }}</option>
        </select>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-info">Add</button>
        </span>
      </form>
    </div>
    <div class="row" style="padding: 0px 15px !important;">
      <div style="padding: 5px;" v-for="(interest) in userInterests" v-bind:key="interest.id">
        <span class="badge">{{interest.title}} <i v-on:click="deleteUserInterest(interest.id)" class="fa fa-close" style="color:white"></i></span>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: ['userId'],

    data() {
      return {
        interests: [],
        userInterests: [],
        user_id: this.userId,
        newInterest: '',
        newUserInterest: {
          user_id: this.userId,
          interest_id: ''
        },
        deleteParams: {
          user_id: this.userId,
          interest_id: ''
        }
      }
    },
    mounted() {
      this.getUserInterests(this.userId),
      this.getAllInterests(this.userId)
    },
    methods: {
      getUserInterests(){
        axios({method: 'GET', url: `/api/user_interests/${this.user_id}`}).then(
          result => {
            this.userInterests = result.data
            console.log(result.data)
          },
          error => {
            console.log(error)
          }
        )
      },
      getAllInterests(){
        axios({method: 'GET', url: `/api/user_interests_options/${this.user_id}`}).then(
          result => {
            this.interests = result.data
            // console.log('interests ' + this.interests)
          }
        )
      },
      addUserInterest() {
        axios.post(`/api/user_interest/${this.user_id}`, this.newUserInterest).then(res => {
        }).catch(err => {
          console.log(err)
        })
        this.getUserInterests(this.user_id)
        this.getAllInterests(this.user_id)
      },
      deleteUserInterest(id) {
        this.deleteParams.interest_id = id
        axios.delete(`/api/user_interest/${id}`, {data: this.deleteParams})
        .then(res => {
          this.getUserInterests(this.user_id)
          this.getAllInterests(this.user_id)
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
      },
    }
  }
  $('.select2-multi').select2();
</script>
