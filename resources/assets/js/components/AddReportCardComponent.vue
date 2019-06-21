<template>
  <div class='row'>
        <div class='col'>
          <label for="title_input">Title</label>
          <input v-model="newReportCard.title" type="text" id="title_input" class="form-control" placeholder="Eg. Mid-Term Exams"></input>
        </div>

        <div class='col'>
          <label for="file">Upload</label>
          <input type="file" v-on:change="onInputChange" class="form-control">
        </div>
        <div class='col'>
          <label for="term_start_input">Term Start</label>
          <input v-model="newReportCard.term_start" type="date" id="term_start_input" class="form-control"></input>
        </div>
        <div class='col'>
          <label for="term_end_input">Term End</label>
          <input v-model="newReportCard.term_end" type="date" id="term_end_input" class="form-control"></input>
        </div>
        <div class='col'>
          <button class='btn btn-xs btn-primary align-middle'v-on:click="submitData()">Add</button>
        </div>
  </div>
</template>

<script>
    export default {

      data() {
        return {
        imageSrc: '',
        newReportCard: {
          title: '',
          term_start: '',
          term_end: '',
          file: ''
        }
        }
    },
      mounted() {
          console.log('Component mounted.')
          // this.$emit('newReportCard', formData)
      },
      methods: {
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
      },
      submitData(){
        console.log('arc', this.newReportCard);
        this.$emit('newReportCard', this.newReportCard)
        this.newReportCard = {};
      }
      }
    }
</script>
