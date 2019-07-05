<template>
  <div>
    <div class='card'>
      <div class='card-body'>
        <div class='row'>
          <h5 class='col'>Report Cards</h5>
          <a class='col text-right' style="color:#0645AD;" v-on:click="renderNewReportCardForm">Add new report card</a>
        </div>
        <add-report-card-component v-on:newReportCardComponent='pushNewReportCardComponent' v-on:deleteReportCard='removeReportCard' 
        v-for="(nrc, index) in reportCardComponents" :key='index+1' :index='index' :nrc='nrc' v-if='!nrc.deleted' 
        ref='add-rc-components'></add-report-card-component>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    props: ['scholar', 'reportCards'],

    data() {
      return {
        files: [],
        images: [],
        imgSrc: '',
        newReportCard :[{
          scholar_id: this.scholar.id,
          title: '',
          term_start: '',
          term_end: '',
          deleted: false
        }],
        scholar_id: this.scholar.id,
        reportCardComponents: [],
      }
    },
    mounted() {
      this.setDefaults()
    },
    methods: {
      setDefaults() {
        this.reportCardComponents = _.cloneDeep(this.reportCardComponents.concat(this.reportCards));
        console.log('setDefaults rcs', this.reportCardComponents)
      },
      removeReportCard(deletedReportCard, index){
        let filterReportCards = _.reject(this.reportCardComponents, function(rc){
          return rc.index == deletedReportCard.index;
        })
        filterReportCards.splice(index, 0, deletedReportCard)
        this.reportCardComponents = filterReportCards;
        this.$emit('sendReportCards', filterReportCards);
        
      },
      renderNewReportCardForm(){
        this.reportCardComponents.push({
          id: '',
          title: '',
          term_start: '',
          term_end: '',
          file: '',
          index: '',
          deleted: false
        })
      },
      pushNewReportCardComponent(reportCard, index){
        this.reportCardComponents[index] = reportCard
        let self = this;
        this.$emit('sendReportCards', self.reportCardComponents);
      }
    }
  }
</script>
