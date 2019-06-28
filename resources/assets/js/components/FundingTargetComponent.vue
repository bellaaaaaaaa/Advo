<template>
  <div class='card'>
    <div class='card-body'>
      <div class='row'>
        <h5 class='col'>Funding Targets</h5>
        <a class='col text-right' style="color:#0645AD;" v-if="enableAddFt" v-on:click="renderNewFtForm" >Add new funding target</a>
      </div>
        <add-funding-target-component  v-on:deleteFt='removeFt'  v-for="(ft, index) in fundingTargetComponents" :key='index+1' :index='index' :ft='ft' v-if='!ft.deleted'>
        </add-funding-target-component>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    props: ['user', 'userFundingTarget'],

    data() {
      return {
        fundingTarget :{
          user_id: this.user.id,
          title: '',
          amount: ''
        },
        fundingTargetComponents: [],
        enableAddFt: true
      }
    },
    mounted() {
      this.setDefaults()
    },
    methods: {
      setDefaults(){
        if(this.userFundingTarget == 0){
          this.fundingTargetComponents.push({
            user_id: this.user.id,
            title: '',
            amount: ''
          })
        }else{
          this.fundingTargetComponents.push(this.userFundingTarget[0])
        }
      },
      renderNewFtForm(){
        if (this.fundingTargetComponents.length < 2){
          this.fundingTargetComponents.push({
            user_id: this.user.id,
            title: '',
            amount: ''
          })
        }
        this.enableAddFt = false
      },
      removeFt(deletedFt, index){
        let filterFts = _.reject(this.fundingTargetComponents, function(ft){
          return ft.id == deletedFt.id;
        })
        filterFts.splice(index, 0, deletedFt)
        this.fundingTargetComponents = filterFts;
        if (this.fundingTargetComponents.length < 2){
          this.enableAddFt = true
        }
      },
    }
  }
</script>
