<template>
  <div>
    <!--<b-button v-b-modal.modal-1>Launch demo modal</b-button>

    <b-modal id="modal-1" title="BootstrapVue">
      <p class="my-4">Hello from modal!</p>
    </b-modal> -->
    <form v-on:submit.prevent="addNewReportCard" enctype="multipart/form-data">
      <div class='row'>
        <div class="col">
          <label for="title_input">Title</label>
          <input v-model="newReportCard.title" type="text" id="title_input" class="form-control" placeholder="Eg. Mid-Term Exams"></input>
        </div>
        <div class="col">
          <label for="file">Upload</label>
          <input type="file" v-on:change="onInputChange" class="form-control">
        </div>
      </div>

      <div class='row'>
        <div class="col">
          <label for="term_start_input">Term Start</label>
          <input v-model="newReportCard.term_start" type="date" id="term_start_input" class="form-control"></input>
        </div>

        <div class="col">
          <label for="term_end_input">Term End</label>
          <input v-model="newReportCard.term_end" type="date" id="term_end_input" class="form-control"></input>
        </div>
      </div>

      <button v-if="this.isEdit == false" type="submit" class="btn btn-success btn-block" style="background-color: rgb(101, 140, 247); border-color:  rgb(101, 140, 247); margin-top: 10px">Submit</button>
      <button v-else v-on:click="updateReportCard()" type="button" class="btn btn-primary btn-block">Update</button>
    </form>
    <table class="table">
      <tr v-for="(rc) in reportCards" v-bind:key="rc.id" v-bind:title="rc.term_start">
      
        <td class="text-left">{{rc.title}} | <span style="color: grey">{{moment(rc.term_start).format("MMM Do YY") + ' - ' + moment(rc.term_end).format("MMM Do YY")}}</span></td> 
        <td class="text-right">
          <a class="btn btn-info" v-bind:href="rc.file" style="color: white">View</a>
          <button v-on:click="editReportCard(rc.term_start, rc.term_end, rc.id, rc)" class="btn btn-info" style="background-color: rgb(101, 140, 247); border-color:  rgb(101, 140, 247)">Edit</button>
          <button v-on:click="deleteReportCard(rc.id)" class="btn btn-danger">Delete</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
  import axios from 'axios'
  import moment from 'moment'
  Vue.prototype.moment = moment
  export default {
    props: ['userId'],

    data() {
      return {
        reportCards: [],
        files: [],
        images: [],
        imgSrc: '',
        newReportCard :{
          user_id: this.userId,
          title: '',
          term_start: '',
          term_end: ''
        },
        user_id: this.userId,
        isEdit: false
      }
    },
    mounted() {
      this.getReportCards()
    },
    methods: {
      getReportCards() {
        axios({method: 'GET', url: '/api/admin/report_cards'}).then(
          result => {
            this.reportCards = result.data
          },
          error => {
            console.log('getReportCards ' + error)
          }
        )
      },
      addNewReportCard(e) {
        // debugger;
        var formData = new FormData(e.target);
        formData.append('report_file', this.newReportCard.file);
        formData.append('title', this.newReportCard.title);
        formData.append('term_start', this.newReportCard.term_start);
        formData.append('term_end', this.newReportCard.term_end);
        formData.append('user_id', this.newReportCard.user_id);
        axios.post('/api/admin/report_cards', formData).then(res => {
        this.newReportCard.term_start = ''
        this.newReportCard.term_end = ''
        this.newReportCard.file = ''
        this.newReportCard.title = ''
        this.getReportCards()
        console.log("addNewReportCard " + res)
        }).catch(err => {
          console.log(err)
        })
      },
      editReportCard(term_start, term_end, id, rc) {
        this.newReportCard.title = rc.title
        this.newReportCard.term_start = moment(rc.term_start).format('YYYY-MM-DD');
        this.newReportCard.term_end = moment(rc.term_end).format('YYYY-MM-DD');
        this.id = id
        this.term_start = term_start
        this.term_end = term_end
        this.isEdit = true
      },
      updateReportCard() {
        var form = $('form')[0];
        var formData = new FormData(form);
        formData.append('report_file', this.newReportCard.file);
        formData.append('title', this.newReportCard.title);
        formData.append('term_start', this.newReportCard.term_start);
        formData.append('term_end', this.newReportCard.term_end);
        formData.append('user_id', this.newReportCard.user_id);
        axios.post(`/api/admin/report_cards/${this.id}`, formData)
        .then(res => {
          this.newReportCard.term_start = ''
          this.newReportCard.term_end = ''
          this.newReportCard.title = ''
          this.isEdit = false
          this.getReportCards()
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
      },
      deleteReportCard(id) {
        axios.delete(`/api/admin/report_cards/${id}`)
        .then(res => {
          this.getReportCards()
          this.term_start = ''
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
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
        this.newReportCard.file = input.files[0];
      }
    }
  }
</script>
