<template>
  <div class='row'>
    <div class='col'>
      <label for="title_input">Title</label>
      <input :id="'fttitle' + index" :class="'form-control'" v-model="fundingTarget.title" type="text" class="form-control" placeholder="Eg. College Fund"></input>
    </div>
    <div class='col'>
      <label>Amount</label>
      <input :class="'form-control amount' + index" v-model="fundingTarget.amount" type="integer"></input>
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
            key: '',
            index: this.index,
            title: '',
            amount: ''
          }
        }
      },
      mounted() {
        this.setDefaults(),
        this.ftListeners(),
        this.onFtUpdated()
      },
      methods: {
        setDefaults: function(){
          if(this.ft.id == ''){
            this.fundingTarget.id = '';
            this.fundingTarget.title = '';
            this.fundingTarget.index = this.index;
            this.fundingTarget.deleted = false;
            this.fundingTarget.amount = '';
            this.fundingTarget.amount_gained = ''
          }else{
            this.fundingTarget.id = this.ft.id;
            this.fundingTarget.title = this.ft.title;
            this.fundingTarget.index = this.index;
            this.fundingTarget.deleted = false;
            this.fundingTarget.amount = this.ft.amount;
            this.fundingTarget.amount_gained = this.ft.amount_gained;
          }
        },
        ftListeners: function() {

          let self = this;
          this.id = this.index;
          var timer;
          $("#fttitle" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();

            clearInterval(timer);
            timer = setTimeout(function() {
                self.fundingTarget.title = event.target.value
                self.fundingTarget.deleted = false
                self.onFtUpdated();
            }, 200);
          });

          $(".amount" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();

            clearInterval(timer);
            timer = setTimeout(function() {
                self.fundingTarget.amount = event.target.value
                self.fundingTarget.deleted = false
                self.onFtUpdated();
            }, 200);
          });
        },
        onFtUpdated: function() {
          let ft = {
            id: this.fundingTarget.id ? this.fundingTarget.id: '',
            index: this.index,
            title: this.fundingTarget.title ? this.fundingTarget.title: null,
            amount: this.fundingTarget.amount ? this.fundingTarget.amount : null,
            deleted: false
          }
          this.$emit('newFtComponent', ft, this.index);
        },
        removeFt(){
          this.fundingTarget.deleted = true
          this.fundingTarget.index = this.index
          this.$emit('deleteFt', this.fundingTarget, this.index);
        }
      }
    }
</script>
