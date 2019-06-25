<template>
  <div class='row'>
    <div class='col'>
      <label for="title_input">Title</label>
      <input :id="'title' + index" :class="'form-control existing_title'" v-model="newReportCard.title" type="text" class="form-control" placeholder="Eg. Mid-Term Exams"></input>
    </div>
    <div class='col'>
      <div class='row'>
        <div class='col'>
          <label class='text-left' for="file">File</label>
        </div>
        <div class='col'>
          <a v-if='typeof this.rc != "undefined"'class="text-right" :href="rc.file"><label>Current</label><i class='fa fa-external-link' aria-hidden='true'></i></a>
        </div>
      </div>
      <input type="file" v-on:change="onInputChange" class="form-control">
    </div>
    <div class='col'>
      <label for="term_start_input">Term Start</label>
      <input :class="'form-control existing_term_start term_start' + index" v-model="newReportCard.term_start" type="date" id="term_start_input" class="form-control"></input>
    </div>
    <div class='col'>
      <label for="term_end_input">Term End</label>
      <input :class="'form-control existing_term_end term_end' + index" v-model="newReportCard.term_end" type="date" id="term_end_input"></input>
    </div>
    <div class='col-md-1 pt-4'>
      <a href='#'><i style='padding-top: 5px' class='fa fa-close' aria-hidden='true'></i></a>
    </div>
  </div>
</template>

<script>
    import moment from 'moment'
    Vue.prototype.moment = moment
    export default {
      props: ['rc', 'index', 'nrc', 'erc'],
     
      data() {
        return {
        imageSrc: '',
        newReportCard: {
          id: '',
          title: '',
          term_start: '',
          term_end: '',
          file: ''
        }
        }
    },
      mounted() {
        this.setDefaults(),
        this.reportCardListeners(),
        this.editReportCardListeners()
      },
      methods: {
        setDefaults: function(){
          if(typeof this.erc != 'undefined'){
            this.edit = true;
            this.newReportCard.id = this.erc.id;
            this.newReportCard.title = this.erc.title;
            this.newReportCard.term_start = moment(this.erc.term_start).format('YYYY-MM-DD');
            this.newReportCard.term_end = moment(this.erc.term_end).format('YYYY-MM-DD');
            this.newReportCard.file = this.erc.file;
          }
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
          let self = this;
          this.$emit('newReportCardComponent', self.newReportCard, this.index);
        },
        reportCardListeners: function() {
          let self = this;
          this.id = this.index;
          var timer;
          $("#title" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();

            clearInterval(timer);
            timer = setTimeout(function() {
                self.newReportCard.title = event.target.value
                self.onReportCardUpdated();
            }, 200);
          });

          $('.term_start' + this.index).on('change', function(event) {
            self.newReportCard.term_start = event.target.value
            self.onReportCardUpdated();
          });
          $('.term_end' + this.index).on('change', function(event) {
            self.newReportCard.term_end = event.target.value
            self.onReportCardUpdated();
          });
        },
        // editReportCardListeners: function() {
        //   let self = this;
        //   // this.id = this.index;
        //   var timer;
        //   if (typeof this.erc != 'undefined') {
        //     $(".existing_title").on("keyup", function(event){
        //       var searchid = $(this).val().trim();

        //       clearInterval(timer);
        //       timer = setTimeout(function() {
        //           self.newReportCard.title = event.target.value
        //           self.onReportCardUpdated();
        //       }, 200);
        //     });

        //     $('.existing_term_start').on('change', function(event) {
        //       self.newReportCard.term_start = event.target.value
        //       self.onReportCardUpdated();
        //     });
        //     $('.existing_term_end').on('change', function(event) {
        //       self.newReportCard.term_end = event.target.value
        //       self.onReportCardUpdated();
        //     });
        //   }
        // },
        onReportCardUpdated: function() {
          let reportCard = {
            id: this.newReportCard.id,
            title: this.newReportCard.title ? this.newReportCard.title: null,
            term_start: this.newReportCard.term_start ? this.newReportCard.term_start : null,
            term_end: this.newReportCard.term_end ? this.newReportCard.term_end : null,
            file: this.newReportCard.file ? this.newReportCard.file : null,
          }
          if (typeof this.erc != 'undefined') {
            this.$emit('existingReportCardComponent', reportCard, this.newReportCard.id);
          }else {
            this.$emit('newReportCardComponent', reportCard, this.index);
          }
        },
      // updateReportCard(){
      //   this.$emit('updatedReportCard', this.newReportCard)
      // },
      }
    }
</script>
