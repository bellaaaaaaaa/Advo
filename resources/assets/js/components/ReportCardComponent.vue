<template>
  <div>
    <div class='card'>
      <div class='card-body'>
        <div class='row'>
          <h5 class='col'>Report Cards</h5>
          <a class='col text-right' style="color:#0645AD;" :index='index' :key='index+1' v-on:click="renderNewReportCardForm" >Add new report card</a>
        </div>
        <add-report-card-component  v-on:newReportCardComponent='pushNewReportCardComponent' v-on:existingReportCardComponent='pushExistingReportCardComponent' v-for="(nrc, index) in newReportCardComponents" :key='index+1' :index='index' :nrc='nrc'></add-report-card-component>
      </div>
    </div>
    <!--<div class='card'>
      <div class='card-body'>
        <h5>Existing Report Cards</h5>
        <add-report-card-component v-for='(rc) in reportCards' :erc='rc' v-on:updatedReportCard='pushUpdatedReportCard'></add-report-card-component>
      </div>
    </div> -->
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    props: ['userId', 'reportCards'],

    data() {
      return {
        files: [],
        images: [],
        imgSrc: '',
        newReportCard :[{
          user_id: this.userId,
          title: '',
          term_start: '',
          term_end: ''
        }],
        user_id: this.userId,
        isEdit: false,
        newReportCards: [],
        updatedReportCards: [],
        newReportCardComponents: [],
        existingReportCards: []
      }
    },
    mounted() {
      console.log(this.reportCards)
    },
    methods: {
      addNewReportCard(e) {
        // this.$emit('newReportCard', this.newReportCard);
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
      },
      deleteReportCard(id) {
        axios.delete(`/api/admin/report_cards/${id}`)
        .then(res => {
          this.getUsersReportCards()
          this.term_start = ''
        })
        .catch(err => {
          console.log(err)
        })
      },
      pushUpdatedReportCard(updatedReportCard){
        this.updatedReportCards.push(updatedReportCard)
        this.$emit('updatedReportCards', this.updatedReportCards)
      },
      removeNewReportCard(e){
        this.newReportCards.splice(e.target.id, 1)
      },
      renderNewReportCardForm(){
        this.newReportCardComponents.push({
          id: '',
          title: '',
          term_start: '',
          term_end: '',
          file: ''
        })
      },
      pushNewReportCardComponent(reportCard, index){
        this.newReportCards[index] = reportCard
        console.log('new rcs', this.newReportCards)
        let self = this;
        this.$emit('newReportCards', self.newReportCards);
      },
      pushExistingReportCardComponent(reportCard, id){
        this.existingReportCards[id] = reportCard
        console.log('existing rcs', this.existingReportCards)
        let self = this;
        this.$emit('existingReportCards', self.existingReportCards);
      }
    }
  }
</script>
