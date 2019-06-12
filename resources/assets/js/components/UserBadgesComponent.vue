<template>
  <div class="card col-md-10 offset-md-1">
    <div class="row" style="padding: 15px;">
      <h4 class="col-md-2" style="margin: 0">Badges</h4>
      <form v-on:submit.prevent="addUserBadge()" class="input-group col-md-8">
        <select v-model="newUserBadge.badge_id" type="submit" class='form-control'>
          <option v-for='badge in badges' :value='badge.id'>{{ badge.title }}</option>
        </select>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-info">Add</button>
        </span>
      </form>
    </div>
    <div class="row" style="padding: 0px 15px !important;">
      <div style="padding: 5px;" v-for="(badge) in userBadges" v-bind:key="badge.id">
        <span class="badge">{{badge.title}} <i v-on:click="deleteUserBadge(badge.id)" class="fa fa-close" style="color:white"></i></span>
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
        badges: [],
        userBadges: [],
        user_id: this.userId,
        newBadge: '',
        newUserBadge: {
          user_id: this.userId,
          badge_id: ''
        },
        deleteParams: {
          user_id: this.userId,
          badge_id: ''
        }
      }
    },
    mounted() {
      this.getUserBadges(this.userId),
      this.getAllBadges(this.userId)
    },
    methods: {
      getUserBadges(){
        axios({method: 'GET', url: `/api/user_badges/${this.user_id}`}).then(
          result => {
            this.userBadges = result.data
            console.log(result.data)
          },
          error => {
            console.log(error)
          }
        )
      },
      getAllBadges(){
        axios({method: 'GET', url: `/api/user_badges_options/${this.user_id}`}).then(
          result => {
            this.badges = result.data
          }
        )
      },
      addUserBadge() {
        axios.post(`/api/user_badge/${this.user_id}`, this.newUserBadge).then(res => {
        }).catch(err => {
          console.log(err)
        })
        this.getUserBadges(this.user_id)
        this.getAllBadges(this.user_id)
      },
      deleteUserBadge(id) {
        this.deleteParams.badge_id = id
        axios.delete(`/api/user_badge/${id}`, {data: this.deleteParams})
        .then(res => {
          this.getUserBadges(this.user_id)
          this.getAllBadges(this.user_id)
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
