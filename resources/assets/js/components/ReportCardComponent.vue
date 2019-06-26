<template>
  <div>
    <div class='card'>
      <div class='card-body'>
        <div class='row'>
          <h5 class='col'>Report Cards</h5>
          <a class='col text-right' style="color:#0645AD;" v-on:click="renderNewReportCardForm" >Add new report card</a>
        </div>
        <add-report-card-component v-on:newReportCardComponent='pushNewReportCardComponent' v-on:deleteReportCard='removeReportCard' v-for="(nrc, index) in reportCardComponents" :key='index+1' :index='index' :nrc='nrc' v-if="!nrc.deleted" ref='add-rc-components'></add-report-card-component>
      </div>
    </div>
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
        reportCardComponents: [],
      }
    },
    mounted() {
      this.setDefaults()
    },
    methods: {
      setDefaults() {
        this.reportCardComponents = this.reportCardComponents.concat(this.reportCards)
      },
      removeReportCard(deletedReportCard, index){
        let reportCards = _.reject(this.reportCardComponents, function(item){
          return item.title == deletedReportCard.title;
        })
        this.reportCardComponents = reportCards;
      },
      renderNewReportCardForm(){
        this.reportCardComponents.push({
          id: '',
          title: '',
          term_start: '',
          term_end: '',
          file: ''
        })
      },
      pushNewReportCardComponent(reportCard, index){
        this.reportCardComponents[index] = reportCard
        console.log('report card components', this.reportCardComponents)
        let self = this;
        this.$emit('report card components', self.reportCardComponents);
      }
    }
  }
</script>
