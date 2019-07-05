<template>
  <div>
    <form v-on:submit.prevent="updateScholar" class="col-md-12 ">

      <div class='card'>
        <div class='card-body'>
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
              <select v-model="scholarParams.role" type="submit" class='form-control'>
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
              <input type="file" v-on:change="onInputChange" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <interest-component :scholar="scholar"  v-on:interests='receiveInterests'></interest-component>

      <report-card-component :report-cards='reportCards' :scholar='scholar' v-on:sendReportCards='receiveNewReportCards'></report-card-component>
      
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
    props: ['scholar', 'reportCards', 'fundingTarget'],

    data() {
      return {
        scholarParams: {
          scholar_id: this.scholar.id,
          name: this.scholar.user.name,
          email: this.scholar.user.email,
          role: this.scholar.user.role,
          date_of_birth: this.scholar.user.date_of_birth,
          phone_number: this.scholar.user.phone_number,
          ic_passport_number: this.scholar.user.ic_passport_number,
          bio: this.scholar.user.bio,
          avatar: this.scholar.user.avatar,
          interests: [],
          reportCards: []
        },
        roles: {'0' : 'Admin', '1' : 'Benefactor', '2' : 'Scholar'},
        selectedInterests: [],
        numNewReportCards: 0,
      }
    },
    mounted() {
      console.log(this.scholar)
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
        formData.append('avatar', this.scholarParams.avatar)
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
        this.scholarParams.avatar = input.files[0];
      },
      //Interest Methods
      receiveNewReportCards(reportCards){
        this.scholarParams.newReportCards = reportCards;
        console.log('report cards', this.scholarParams.newReportCards )

      },
      receiveFts(fts){
        this.scholarParams.fundingTargets = fts;
      },
      receiveInterests(interests){
        console.log('receive interests', interests)
        this.scholarParams.interests = interests;
      }
    }
  }
</script>
