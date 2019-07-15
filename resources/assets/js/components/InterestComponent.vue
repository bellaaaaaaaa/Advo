<template>
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
</template>
<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: ['scholar'],

    data() {
      return {
        selectedInterest: '',
        selectedInterests: [],
        interests: [],
        unselectedInterest: '',
      }
    },
    mounted() {
      this.getAvailableInterests(),
      this.getScholarInterests()
    },
    methods: {
      getAvailableInterests(){
        axios({method: 'GET', url: `/api/available_interests/${this.scholar.id}`}).then(
          result => {
            this.interests = result.data
          }
        )
      },
      getScholarInterests(){
        axios({method: 'GET', url: `/api/scholar_interests/${this.scholar.id}`}).then(
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
        this.selectedInterest = null
        this.$emit('interests', this.selectedInterests);
      },
      unselectInterest(event){
        var unselectedInterestId =  event.target.parentElement.id;
        var x;
        for (x = 0; x < this.selectedInterests.length; x ++){
          if(this.selectedInterests[x].id == unselectedInterestId){
            this.selectedInterests.splice(x, 1)
          }
        }
        this.selectedInterest = null
        this.$emit('interests', this.selectedInterests);
      }
    }
  }
</script>
