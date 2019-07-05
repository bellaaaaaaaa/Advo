<template>
  <div class='row'>
    <div class='col'>
      <label for="title_input">Title</label>
      <input :id="'title' + index" :class="'form-control'" v-model="newPost.title" type="text" class="form-control" placeholder="Eg. Mid-Term Exams"></input>
    </div>
    <div class='col'>
      <label for="title_input">Body</label>
      <input :id="'body' + index" :class="'form-control'" v-model="newPost.body" type="text" class="form-control" placeholder="Eg. Mid-Term Exams"></input>
    </div>
    <div class='col'>
      <div class='row'>
        <div class='col'>
          <label class='text-left' for="file">Cover Image</label>
        </div>
        <div class='col'>
          <a v-if='typeof this.post != "undefined"'class="text-right" :href="post.cover_image"><label>Current</label><i class='fa fa-external-link' aria-hidden='true'></i></a>
        </div>
      </div>
      <input type="file" v-on:change="onInputChange" class="form-control">
    </div>
    <div class='col-md-1 pt-4'>
      <a v-on:click="removePost()"><i style='padding-top: 5px; color: red' class='fa fa-close' aria-hidden='true'></i></a>
    </div>
  </div>
</template>

<script>
    import moment from 'moment'
    Vue.prototype.moment = moment
    export default {
      props: ['index', 'post'],
     
      data() {
        return {
        imageSrc: '',
        newPost: {
          id: '',
          title: '',
          cover_image: '',
          body: '',
        }
        }
    },
      mounted() {
        this.setDefaults(),
        this.postListeners()
        this.onPostUpdated()
      },
      methods: {
        setDefaults: function(){
          if(this.post.id == ''){
            this.newPost.id = '';
            this.newPost.index = this.index;
            this.newPost.title = '';
            this.newPost.cover_image = null;
            this.newPost.body = null;
            this.newPost.deleted = false;
          }else{
            this.newPost.id = this.post.id;
            this.newPost.index = this.index;
            this.newPost.title = this.post.title;
            this.newPost.cover_image = null;
            this.newPost.body = this.post.body;
            this.newPost.deleted = false;
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
          this.newPost.cover_image = input.files[0];
          let self = this;
          this.$emit('newPostComponent', self.newPost, this.index);
        },
        postListeners: function() {
          let self = this;
          this.id = this.index;
          var timer;
          $("#title" + this.index).on("keyup", function(event){
            var searchid = $(this).val().trim();

            clearInterval(timer);
            timer = setTimeout(function() {
                self.newPost.title = event.target.value
                self.onPostUpdated();
            }, 200);
          });

          $('#body' + this.index).on('change', function(event) {
            self.newPost. body = event.target.value
            self.onPostUpdated();
          });
        },
        onPostUpdated: function() {
          let post = {
            id: this.newPost.id,
            index: this.index,
            title: this.newPost.title ? this.newPost.title: null,
            body: this.newPost.body ? this.newPost.body: null,
            cover_image: this.newPost.cover_image ? this.newPost.cover_image : null,
            deleted: false
          }
          this.$emit('newPostComponent', post, this.index);
        },
        removePost: function(){
          this.newPost.deleted = true;
          this.$emit('deletePost', this.newPost, this.index);
        }
      }
    }
</script>
