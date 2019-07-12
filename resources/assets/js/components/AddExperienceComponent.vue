<link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
<template>
  <div class='card'>
    <div class='card-body'>
      <div class='row'>
        <div class='col-md-5'>
          <label for="title_input">Position</label>
          <input :id="'position' + index" :class="'form-control'" v-model="newExperience.position" type="text" class="form-control" placeholder="Eg. CEO"></input>
        </div>
        <div class='col-md-6'>
          <label>Organisation</label>
          <input :class="'form-control organisation' + index" v-model="newExperience.organisation" type="text" class="form-control"></input>
        </div>
        <div class='col-md-1 pt-4'>
          <a v-on:click="removeExperience()"><i style='padding-top: 5px; color: red' class='fa fa-close' aria-hidden='true'></i></a>
        </div>
      </div>
      <div class='row'>
        <div class='col-md-5'>
            <label>From</label>
            <vue-monthly-picker :class="'date_from' + index" @change='dateFrom' v-model="newExperience.date_from"></vue-monthly-picker>
            <label>To</label>
            <vue-monthly-picker v-model="newExperience.year_to"></vue-monthly-picker>
        </div>
        <div class='col-md-6'>
          <label>Description</label>
          <textarea :class="'form-control description' + index" v-model="newExperience.description" class="form-control"></textarea>
        </div>
        <div class='col-md-1 pt-4'>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    import moment from 'moment'
    Vue.prototype.moment = moment
    import VueMonthlyPicker from 'vue-monthly-picker'
    export default {
      props: ['index', 'exp'],

      data() {
        return {
        imageSrc: '',
        newExperience: {
          id: '',
          position: '',
          organisation: '',
          date_from: '',
          date_to: '',
          description: ''
        }
        }
    },
      mounted() {
        this.setDefaults(),
        this.experienceListeners(),
        this.onExperienceUpdated()
      },
      methods: {
        setDefaults: function(){
          if(this.exp.id == ''){
            this.newExperience.id = '';
            this.newExperience.index = this.index;
            this.newExperience.position = '';
            this.newExperience.organisation = null;
            this.newExperience.date_from = null;
            this.newExperience.date_to = null;
            this.newExperience.description = null;
            this.newExperience.deleted = false;
          }else{
            this.newExperience.id = this.exp.id;
            this.newExperience.index = this.index;
            this.newExperience.position = this.exp.position;
            this.newExperience.organisation = this.exp.organisation;
            this.newExperience.date_from = this.exp.date_from;
            this.newExperience.date_to = this.exp.date_to;
            this.newExperience.description = this.exp.description;
            this.newExperience.deleted = false;
          }
        },
        experienceListeners: function() {
          let self = this;
          this.id = this.index;
          var timer;
          $("#position" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();
            clearInterval(timer);
            timer = setTimeout(function() {
                self.newExperience.position = event.target.value
                self.onExperienceUpdated();
            }, 200);
          });
          $(".organisation" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();
            clearInterval(timer);
            timer = setTimeout(function() {
                self.newExperience.organisation = event.target.value
                self.onExperienceUpdated();
            }, 200);
          });
          $(".description" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();
            clearInterval(timer);
            timer = setTimeout(function() {
                self.newExperience.description = event.target.value
                self.onExperienceUpdated();
            }, 200);
          });
          $('.date_from' + this.index).on('change', function(event) {
            console.log('date from', event.target.value)
            self.newReportCard.date_from = event.target.value
            self.onExperienceUpdated();
          });
        },
        onExperienceUpdated: function() {
          let experience = {
            id: this.newExperience.id,
            index: this.index,
            position: this.newExperience.position ? this.newExperience.position: null,
            organisation: this.newExperience.organisation ? this.newExperience.organisation : null,
            date_from: this.newExperience.date_from ? this.newExperience.date_from : null,
            date_to: this.newExperience.date_to ? this.newExperience.date_to : null,
            description: this.newExperience.description ? this.newExperience.description : null,
            deleted: false
          }
          this.$emit('newExperienceComponent', experience, this.index);
        },
        removeExperience: function(){
          this.newExperience.deleted = true;
          this.$emit('deleteExperience', this.newExperience, this.index);
        },
        dateFrom(event){
          console.log('date from', event.target.value)
        }
      }
    }
</script>
