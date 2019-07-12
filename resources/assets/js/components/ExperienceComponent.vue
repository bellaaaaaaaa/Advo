<template>
  <div>
    <div class='card'>
      <div class='card-body'>
        <div class='row'>
          <h5 class='col'>Experiences</h5>
          <a class='col text-right' style="color:#0645AD;" v-on:click="renderExperienceForm">Add new experience</a>
        </div>
      </div>
    </div>
    <add-experience-component v-on:newExperienceComponent='pushNewExperienceComponent' v-on:deleteExperience='removeExperience' 
    v-for="(exp, index) in experienceComponents" :key='index+1' :index='index' :exp='exp' v-if='!exp.deleted'></add-experience-component>
  </div>
</template>
<script>
  import axios from 'axios'
  import VueMonthlyPicker from 'vue-monthly-picker'
  export default {
    props: ['benefactor', 'experiences'],

    data() {
      return {
        selectedMonth: '',
        newExperience :[{
          benefactor_id: this.benefactor.id,
          position: '',
          organisation: '',
          year: '',
          description: '',
          deleted: false
        }],
        experienceComponents: [],
      }
    },
    mounted() {
      this.setDefaults()
      console.log('experienceComponents', this.experienceComponents)
    },
    methods: {
      setDefaults() {
        this.experienceComponents = _.cloneDeep(this.experienceComponents.concat(this.experiences));
      },
      removeExperience(deletedExperience, index){
        let filterExperiences = _.reject(this.experienceComponents, function(exp){
          return exp.index == deletedExperience.index;
        })
        filterExperiences.splice(index, 0, deletedExperience)
        this.experienceComponents = filterExperiences;
        this.$emit('sendExperiences', filterExperiences);
        
      },
      renderExperienceForm(){
        this.experienceComponents.push({
          id: '',
          benefactor_id: this.benefactor.id,
          position: '',
          organisation: '',
          year: '',
          description: '',
          deleted: false
        })
      },
      pushNewExperienceComponent(experience, index){
        this.experienceComponents[index] = experience
        let self = this;
        this.$emit('sendExperiences', self.experienceComponents);
      }
    }
  }
</script>
