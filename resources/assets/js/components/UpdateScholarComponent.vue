<template>
  <div>
    <form v-on:submit.prevent="updateScholar" class="col-md-12 ">

      <div class='card'>
        <div class='card-body'>
          <user-details-component :user-pivot='scholar' v-on:sendUserInfo='receiveUserInfo'></user-details-component>
          
          <div class='row'>
            <div class='col-md-4'>
              <label>School</label>
              <select v-model="scholarParams.school" class='form-control'>
                <option v-for='school in schools' :value='school.id'>{{ school.name }}</option>
              </select>
            </div>
            <div class='col-md-4'>
              <label>School File</label>
              <input id="school_file" type="file" v-on:change="onInputChange" class="form-control">
            </div>
            <div class='col-md-4'>
              <label>ID File</label>
              <input id="id_file" type="file" v-on:change="onInputChange" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <interest-component :scholar="scholar"  v-on:interests='receiveInterests'></interest-component>

      <report-card-component :report-cards='reportCards' :scholar='scholar' v-on:sendReportCards='receiveNewReportCards'></report-card-component>

      <post-component :posts='posts' :scholar='scholar' v-on:sendPosts='receiveNewPosts'></post-component>
      
      <funding-target-component :scholar="scholar" :scholar-funding-target='fundingTarget' v-on:sendFts='receiveFts'></funding-target-component>
      <button type='submit' class='btn btn-primary'>Submit</button>

    </form>
  </div>
</template>
<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: ['scholar', 'reportCards', 'fundingTarget', 'schools', 'school', 'posts'],

    data() {
      return {
        scholarParams: {
          scholar_id: this.scholar.id,
          school: this.scholar.school.name,
          school_file: this.scholar.school_file,
          id_file: this.scholar.user.identification_file,
          interests: [],
          reportCards: []
        },
        selectedInterests: []
      }
    },
    mounted() {
      console.log('reportCards', this.reportCards)
    },
    methods: {
      updateScholar(e){
        const config = { headers: { 'Content-Type': undefined}}

        var formData = new FormData(e.target)
        formData.append('_method', 'PATCH')
        formData.append('scholarParams', JSON.stringify(this.scholarParams))
        if (typeof this.scholarParams.newReportCards != "undefined") {
          var i;
          for (i = 0; i < this.scholarParams.newReportCards.length; i++) {
            formData.append("belongs_to_rc_" + this.scholarParams.newReportCards[i].index, this.scholarParams.newReportCards[i].file)
          }
        }
        if (typeof this.scholarParams.newPosts != "undefined") {
          var x;
          for (x = 0; x < this.scholarParams.newPosts.length; x++) {
            formData.append("belongs_to_post_" + this.scholarParams.newPosts[x].index, this.scholarParams.newPosts[x].cover_image)
          }
        }
        formData.append('avatar', this.scholarParams.avatar)
        formData.append('school_file', this.scholarParams.school_file)
        formData.append('id_file', this.scholarParams.id_file)
        axios.post(`/admin/scholars/${this.scholar.id}`, formData, config)
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
        if(event.target.id == 'avatar'){
          this.scholarParams.avatar = input.files[0];
        } else if (event.target.id == 'school_file'){
          this.scholarParams.school_file = input.files[0];
        } else if (event.target.id == 'id_file'){
          this.scholarParams.id_file = input.files[0];
        }
      },
      //Interest Methods
      receiveNewReportCards(reportCards){
        this.scholarParams.newReportCards = reportCards;

      },
      receiveNewPosts(posts){
        this.scholarParams.newPosts = posts;

      },
      receiveFts(fts){
        this.scholarParams.fundingTargets = fts;
      },
      receiveInterests(interests){
        this.scholarParams.interests = interests;
      },
      receiveUserInfo(info){
        this.scholarParams.name = info.name
        this.scholarParams.email = info.email
        this.scholarParams.phone_number = info.phone_number
        this.scholarParams.role = info.role
        this.scholarParams.date_of_birth = info.date_of_birth
        this.scholarParams.ic_passport_number = info.ic_passport_number
        this.scholarParams.bio = info.bio
        this.scholarParams.avatar = info.avatar
      }
    }
  }
</script>
