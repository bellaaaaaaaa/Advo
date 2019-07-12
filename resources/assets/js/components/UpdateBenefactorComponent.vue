<template>
  <div>
    <form v-on:submit.prevent="updateBen" class="col-md-12 ">

      <div class='card'>
        <div class='card-body'>
          <user-details-component :user-pivot="benefactor" :user="user"  v-on:sendUserInfo='receiveUserInfo'></user-details-component>
        </div>
      </div>

      <div class='card'>
        <div class='card-body'>
        <div class='row col-md-12'><h5>Work and ID</h5></div>
          <div class='row'>
            <div class='col-md-4'>
              <label>Company</label>
              <input id="company" v-model="params.company" type="text" class="form-control">
              <!--<GmapAutocomplete class='form-control' @place_changed="onLocationAdded" ref="autocomplete"></GmapAutocomplete>-->
            </div>
            <div class='col-md-4'>
              <label>Position</label>
              <input id="position" v-model="params.position" type="text" class="form-control">
            </div>
            <div class='col-md-4'>
              <label>ID File</label>
              <input id="id_file" type="file" v-on:change="onInputChange" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <experience-component :benefactor='benefactor' :experiences='experiences' v-on:sendExperiences='receiveExperiences'></experience-component>
      <button type='submit' class='btn btn-primary'>Submit</button>

    </form>
  </div>
</template>
<script>
  import {gmapApi} from 'vue2-google-maps';
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    computed: {
      google: gmapApi
    },
    props: ['benefactor', 'user', 'experiences'],

    data() {
      return {
        params: {
          company: '',
          position: '',
          id_file: ''
        }
      }
    },
    mounted() {
      console.log('experiences', this.experiences)
    },
    methods: {
      updateBen(e){
        const config = { headers: { 'Content-Type': undefined}}
        var formData = new FormData(e.target)
        formData.append('_method', 'PATCH')
        formData.append('benParams', JSON.stringify(this.params))
        formData.append('id_file', this.params.id_file)
        formData.append('avatar', this.params.avatar)
        axios.post(`/admin/benefactors/${this.benefactor.id}`, formData, config)
        .then(response => {
          	location.href = response.data;
          // window.location = res.data.redirect;
        })
        .catch(err => {
          console.log(err)
        })
      },
      receiveUserInfo(info){
        var key;
        for (key in info ){
	        this.params[key] = info[key]
        }
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
        this.params.id_file = input.files[0]
      },
      receiveExperiences(experiences){
        this.params.experiences = experiences
      },
      onLocationAdded(company) {
        this.params.company = company;
      }
    }
  }
</script>
