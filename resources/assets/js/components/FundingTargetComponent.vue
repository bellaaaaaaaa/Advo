<template>
  <div class='card'>
    <div class='card-body'>
      <div class='row'>
        <h5 class='col'>Funding Targets</h5>
        <a class='col text-right' style="color:#0645AD;" v-if="enableAddFt" v-on:click="renderNewFtForm" >Add new funding target</a>
      </div>
        <add-funding-target-component v-on:newFtComponent='pushFtComponent'  v-on:deleteFt='removeFt'  v-for="(ft, index) in fundingTargetComponents" :key='index+1' :index='index' :ft='scholarFundingTarget' v-if='!ft.deleted'>
        </add-funding-target-component>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    props: ['scholar', 'scholarFundingTarget'],

    data() {
      return {
        fundingTarget :{
          scholar_id: this.scholar.id,
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
        this.fundingTargetComponents = _.cloneDeep(this.fundingTargetComponents.concat(this.scholarFundingTarget));
        if (this.scholarFundingTarget.length == 0){
          this.enableAddFt = true
        }
        console.log('setDefaults fts', this.fundingTargetComponents)
      },
      renderNewFtForm(){
        if (this.enableAddFt == true){
          this.fundingTargetComponents.push({
            scholar_id: this.scholar.id,
            title: '',
            amount: '',
            deleted: false,
            index: '',
            id: '',
            key: ''
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
        console.log('funding target components', this.fundingTargetComponents)
        let filterFts = _.reject(this.fundingTargetComponents, function(ft){
          return ft.index == deletedFt.index;
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
        this.pushFtComponent(deletedFt, index);
      },
      pushFtComponent(ft, index){
        this.fundingTargetComponents[index] = ft
        let self = this;
        this.$emit('sendFts', self.fundingTargetComponents);
      }
    }
  }
</script>
