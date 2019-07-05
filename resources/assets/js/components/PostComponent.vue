<template>
  <div>
    <div class='card'>
      <div class='card-body'>
        <div class='row'>
          <h5 class='col'>Posts</h5>
          <a class='col text-right' style="color:#0645AD;" v-on:click="renderNewPostForm">Add new post</a>
        </div>
        <add-post-component v-on:newPostComponent='pushNewPostComponent' v-on:deletePost='removePost' 
        v-for="(post, index) in postComponents" :key='index+1' :index='index' :post='post' v-if='!post.deleted' 
        ref='add-rc-components'></add-post-component>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    props: ['scholar', 'posts'],

    data() {
      return {
        files: [],
        images: [],
        imgSrc: '',
        newPost :[{
          scholar_id: this.scholar.id,
          title: '',
          body: '',
          cover_image: '',
          deleted: false
        }],
        scholar_id: this.scholar.id,
        postComponents: [],
      }
    },
    mounted() {
      console.log('scholar', this.scholar)
      this.setDefaults()
    },
    methods: {
      setDefaults() {

        this.postComponents = _.cloneDeep(this.postComponents.concat(this.posts));
        console.log('setDefaults posts', this.postComponents)
      },
      removePost(deletedPost, index){
        let filterPosts = _.reject(this.postComponents, function(rc){
          return rc.index == deletedPost.index;
        })
        filterPosts.splice(index, 0, deletedPost)
        this.postComponents = filterPosts;
        this.$emit('sendPosts', filterPosts);
        
      },
      renderNewPostForm(){
        this.postComponents.push({
          id: '',
          title: '',
          body: '',
          cover_image: '',
          deleted: false
        })
      },
      pushNewPostComponent(post, index){
        this.postComponents[index] = post
        let self = this;
        this.$emit('sendPosts', self.postComponents);
      }
    }
  }
</script>
