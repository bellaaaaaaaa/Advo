<template>
  <div class='card'>
    <div class='card-body'>
      <div class='row'>
        <h5 class='col'>Funding Targets</h5>
        <a class='col text-right' style="color:#0645AD;" v-if="enableAddFt" v-on:click="renderNewFtForm" >Add new funding target</a>
      </div>
        <add-funding-target-component v-on:newFtComponent='pushFtComponent'  v-on:deleteFt='removeFt'  v-for="(ft, index) in fundingTargetComponents" :key='index+1' :index='index' :ft='ft' v-if='!ft.deleted'>
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
        enableAddFt: null
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
            amount: '',
            deleted: false
          })
        }else{
          this.userFundingTarget[0].deleted = false;
          this.fundingTargetComponents.push(this.userFundingTarget[0])
          this.enableAddFt = false
        }
      },
      renderNewFtForm(){
        if (this.enableAddFt == true){
          this.fundingTargetComponents.push({
            user_id: this.user.id,
            title: '',
            amount: '',
            deleted: false
          })
        }
        var numRemainingFts = [];
        var i;
        for(i=0; i<this.fundingTargetComponents.length; i++){
          if (this.fundingTargetComponents[i].deleted == false){
            numRemainingFts.push(this.fundingTargetComponents[i])
          }
        }
        if (numRemainingFts.length < 1){
          this.enableAddFt = true
        }else {
          this.enableAddFt = false
        }
      },
      removeFt(deletedFt, index){
        let filterFts = _.reject(this.fundingTargetComponents, function(ft){
          return ft.id == deletedFt.id;
        })
        filterFts.splice(index, 0, deletedFt)
        this.fundingTargetComponents = filterFts;
        var numRemainingFts = [];
        var i;
        for(i=0; i<filterFts.length; i++){
          if (filterFts[i].deleted == false){
            numRemainingFts.push(filterFts[i])
          }
        }
        if (numRemainingFts.length < 1){
          this.enableAddFt = true
        }
      },
      pushFtComponent(ft, index){
        this.fundingTargetComponents[index] = ft
        let self = this;
        this.$emit('sendFts', self.fundingTargetComponents);
      }
    }
  }
</script>
