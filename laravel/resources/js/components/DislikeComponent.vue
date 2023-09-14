<!-- <template>
  <div class="container">
      <div id="success" class="mb-3"></div>
      
     <a style="cursor: pointer" @click.prevent="dislikeBlog">
         <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 
         ({{ alldislike }})
     </a>
  </div>
</template> -->
<script>
import axios from "axios";
export default {
    props:['blog'],
    data(){
        return {
            alldislike:'',
        }
    },
    methods:{
        dislikeBlog(){
            axios.post('/dislike/'+this.blog, {post: this.blog})
            .then(res =>{
              $('#success').html(res.data.message);
            // 좋아요 수를 업데이트하기 위해 fetchLikes 메서드 호출
            this.fetchDislike();
            })
            .catch(error => {
                  console.log(error.message);
              })
        },
        fetchDislike() {
      axios.post('/dislike', { post: this.blog })
        .then(res => {
          if (res.data.post === null) {
            console.log("post is null");
            return;
          }
          this.alldislike = res.data.post.dislike;
        });
    }
  },
  mounted() {
    this.fetchDislike();
  }
};
</script>