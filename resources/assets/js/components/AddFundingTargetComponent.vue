<template>
  <div class='row'>
    <div class='col'>
      <label for="title_input">Title</label>
      <input :id="'fttitle' + index" :class="'form-control'" v-model="fundingTarget.title" type="text" class="form-control" placeholder="Eg. College Fund"></input>
    </div>
    <div class='col'>
      <label for="term_end_input">Amount</label>
      <input :class="'form-control term_end' + index" v-model="fundingTarget.amount" type="integer"></input>
    </div>
    <div class='col-md-2 pt-4'>
      <a v-on:click="removeFt()"><label style="color: red">Close</label></a>
    </div>
  </div>
</template>

<script>
    import moment from 'moment'
    Vue.prototype.moment = moment
    export default {
      props: ['ft', 'index'],
      data() {
        return{
          fundingTarget: {
            id: '',
            title: '',
            amount: ''
          }
        }
      },
      mounted() {
        this.setDefaults()
      },
      methods: {
        setDefaults: function(){
          // debugger;
          if(this.ft == 0){
            this.fundingTarget.id = '';
            this.fundingTarget.title = '';
            this.fundingTarget.amount = '';
          }else{
            this.fundingTarget.id = this.ft.id;
            this.fundingTarget.title = this.ft.title;
            this.fundingTarget.amount = this.ft.amount;
          }
        },
        removeFt(){
          this.fundingTarget.deleted = true
          this.$emit('deleteFt', this.fundingTarget, this.index);
        }
      }
    }
</script>
