<template>
<div>
  <div class="col-md-12 row">
    <div class="col-md-6">
      <label>Benefactor (Sender)</label>
      <select name="benefactor_id" v-model="newFundingTransactionObject.benefactor_id" class='form-control'>
        <option v-for='benefactor in benefactors' :value='benefactor.id'>{{ benefactor.id }} | {{ benefactor.name }}</option>
      </select>
    </div>

    <div class="col-md-6">
      <label>Scholar (Receiver)</label>
        <select name="scholar_id" @change="onChange($event)" v-model="newFundingTransactionObject.scholar_id" class='form-control'>
          <option v-for='scholar in scholars' :value='scholar.id'>{{ scholar.id }} | {{ scholar.name }}</option>
        </select>
    </div>
  </div> <!-- end row -->

  <div class="col-md-12  row">
    <div class="col-md-6">
      <label>{{this.scholarName}}Funding Targets</label>
      <select name="funding_target_id" v-model="newFundingTransactionObject.funding_target_id" class='form-control'>
        <option v-for='ft in scholarFundingTargets' :value='ft.id'>{{ ft.id }} | {{ ft.title }}</option>
      </select>
    </div>
    <div class="col-md-6">
      <label>Amount</label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">$</div>
        </div>
        <input name="amount_cents" @keypress="isNumber($event)" v-model="newFundingTransactionObject.amount_cents" class="form-control"></input>
        <div class="input-group-addon">
          <div class="input-group-text">.00</div>
        </div>
      </div>
    </div>
  </div> <!-- end row -->

  <div class="col-md-12 row">
    <div class="col-md-6">
      <label>Funding Package</label>
      <select name="funding_package_id" v-model="newFundingTransactionObject.funding_package_id" class='form-control'>
        <option v-for='fp in fundingPackages' :value='fp.id'>{{ fp.title }}</option>
      </select>
    </div>
    <div class="col-md-6">
      <label>Payment Method</label>
      <select name="payment_method" v-model="newFundingTransactionObject.payment_method" class='form-control'>
        <option v-for='pmt in paymentMethodTypes' :value='pmt'>{{ pmt }}</option>
      </select>
    </div>
  </div> <!-- end row -->

  <div class='form-row row'>
    <div class='col-md-10 form-group required'>
      <label class='control-label'>Name on Card</label> 
      <input class='form-control' size='4' type='text'>
    </div>
  </div> <!-- end row -->

  <div class='form-row row'>
    <div class='col-md-10 form-group required'>
      <label class='control-label'>Card Number</label>
      <input autocomplete='off' class='form-control card-number' size='4' type='text'>
    </div>
  </div> <!-- end row -->

  <div class='col-xs-12 col-md-3 form-group cvc required'>
    <label class='control-label'>CVC</label> 
    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
  </div>

  <div class='form-row row'>
    <div class='col-xs-12 col-md-3 form-group expiration required'>
      <label class='control-label'>Expiration Month</label>
      <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
    </div>
    <div class='col-xs-12 col-md-3 form-group expiration required'>
      <label class='control-label'>Expiration Year</label>
      <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
    </div>
  </div>
</div>
</template>

<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {

    data() {
      return {
        benefactors: [],
        scholars: [],
        fundingTransactions: [],
        scholarFundingTargets: [],
        scholarName: '',
        fundingPackages: [],
        paymentMethodTypes: ['A', 'B', 'C'],
        newFundingTransactionObject: {
          benefactor_id: '',
          scholar_id: '',
          funding_target_id: '',
          amount_cents: ''
        }
      }
    },
    mounted() {
      this.getBenefactors(),
      this.getScholars(),
      this.getFundingPackages()
    },
    methods: {
      getBenefactors(){
        axios({method: 'GET', url: '/api/get_benefactors'}).then(
          result => {
            this.benefactors = result.data
            console.log(this.benefactors)
          },
          error => {
            console.log(error)
          }
        )
      },

      getScholars(){
        axios({method: 'GET', url: '/api/get_scholars'}).then(
          result => {
            this.scholars = result.data
          },
          error => {
            console.log(error)
          }
        )
      },

      getFundingPackages(){
        axios({method: 'GET', url: '/api/get_funding_packages'}).then(
          result => {
            this.fundingPackages = result.data
          },
          error => {
            console.log(error)
          }
        )
      },

      getScholarFundingTargets(){
        axios({method: 'GET', url: `/api/get_scholar_funding_targets/${this.scholar_id}`}).then(
          result => {
            this.scholarFundingTargets = result.data
          },
          error => {
            console.log(error)
          }
        )
      },
      
      getScholarName() {
         axios({method: 'GET', url: `/api/get_scholar_name/${this.scholar_id}`}).then(
          result => {
            var name = result.data
            name += "'s "
            this.scholarName = name
            console.log(this.scholarName);
          },
          error => {
            console.log(error)
          }
        )
      },

      onChange(event) {
        this.scholar_id = event.target.value;
        this.getScholarName()
        this.getScholarFundingTargets()
        console.log(this.scholarFundingTargets)
      },
      isNumber: function(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode < 48 || charCode > 57) {
          evt.preventDefault();
        } else {
          return true;
        }
      }
    }
  }
</script>