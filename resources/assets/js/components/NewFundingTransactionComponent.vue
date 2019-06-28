<template>
  <div class="card col-md-10 offset-1">
    <h4> New Funding Transaction</h4>
    <form v-on:submit.prevent="addFundingTransaction()">

      <div class="col-md-12 row">
        <div class="col-md-6">
          <label>Benefactor (Sender)</label>
          <select v-model="newFundingTransactionObject.benefactor_id" class='form-control'>
            <option v-for='benefactor in benefactors' :value='benefactor.id'>{{ benefactor.id }} | {{ benefactor.name }}</option>
          </select>
        </div>

        <div class="col-md-6">
          <label>Scholar (Receiver)</label>
          <select @change="onChange($event)" v-model="newFundingTransactionObject.scholar_id" class='form-control'>
            <option v-for='scholar in scholars' :value='scholar.id'>{{ scholar.id }} | {{ scholar.name }}</option>
          </select>
        </div>
      </div>
      <div class="col-md-12  row">
        <div class="col-md-6">
          <label>{{this.scholarName}}Funding Targets</label>
          <select v-model="newFundingTransactionObject.funding_target_id" class='form-control'>
            <option v-for='ft in scholarFundingTargets' :value='ft.id'>{{ ft.id }} | {{ ft.title }}</option>
          </select>
        </div>
        <div class="col-md-6">
          <label>Amount</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text">$</div>
            </div>
            <input @keypress="isNumber($event)" v-model="newFundingTransactionObject.amount_cents" class="form-control"></input>
            <div class="input-group-addon">
              <div class="input-group-text">.00</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 row">
        <div class="col-md-6">
          <label>Funding Package</label>
          <select v-model="newFundingTransactionObject.funding_package_id" class='form-control'>
            <option v-for='fp in fundingPackages' :value='fp.id'>{{ fp.title }}</option>
          </select>
        </div>
        <div class="col-md-6">
          <label>Payment Method</label>
          <select v-model="newFundingTransactionObject.payment_method" class='form-control'>
            <option v-for='pmt in paymentMethodTypes' :value='pmt'>{{ pmt }}</option>
          </select>
        </div>
      </div>
      
      <button type="submit" class="btn btn-info col-md-12">Create Transaction</button>
    </form>
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
      addFundingTransaction(){
        // admin/funding_transactions
        var userData = this.newFundingTransactionObject
        axios.post('/admin/funding_transactions', this.newFundingTransactionObject).then(response => {
          // window.location.href = response.data;
        })
      },
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