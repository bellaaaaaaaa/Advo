<template>
  <div class="card col-md-10 offset-md-1 interests-container">
    <div class="row">
      <h4 class="col-md-2" style="margin: 0">Interests</h4>
      <div class="col-md-8" style="padding: 5px;" v-for="(interest) in userInterests" v-bind:key="interest.id">
        <span class="badge">{{interest.title}}</span>
        <select class='form-control select2-multi'>
          <option v-for='interest in interests' :value='interest.id'>{{ interest.title }}</option>
        </select>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  import * as select2 from '../resources/assets/js/select2.min.js'
  export default {
    props: ['userId'],

    data() {
      return {
        interests: [],
        userInterests: [],
        user_id: this.userId,
        newUserInterest: {
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
      }
    }
  }
  
</script>
