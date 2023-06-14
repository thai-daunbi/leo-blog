<template>
    <div class="container">
      <div id="success" class="mb-3"></div>
      <a style="cursor: pointer" @click.prevent="likeBlog">
        <i v-if="liked" class="fas fa-thumbs-up"></i>
        <i v-else class="far fa-thumbs-up"></i>
        ({{ alllikes }})
      </a>
      <a style="cursor: pointer" @click.prevent="dislikeBlog">
        <i v-if="disliked" class="fas fa-thumbs-down"></i>
        <i v-else class="far fa-thumbs-down"></i>
        ({{ alldislikes }})
      </a>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    props: ['blog'],
    data() {
      return {
        alllikes: '',
        alldislikes: '',
        liked: false, // 초기값
        disliked: false, // 초기값
        postId: this.blog.id, // 현재 글의 id
        userId: 1, // 현재 로그인한 사용자의 id
        storageKey: 'wrtn.likes', // 로컬 스토리지에 저장할 키
      }
    },
    methods: {
      likeBlog() {
        axios.post(`/like/${this.blog}`, { post: this.blog })
          .then(res => {
            $('#success').html(res.data.message);
            // 좋아요와 싫어요 수를 업데이트하기 위해 fetchLikes 메서드 호출
            this.fetchLikes();
            this.liked = !this.liked; // 아이콘 변경
            this.disliked = false; // 다른 버튼은 빈 아이콘으로 표시
            // 로컬 스토리지에 좋아요 상태 저장
            this.saveLikedToLocalStorage('like');
          })
          .catch(error => {
            console.log(error);
          });
      },
      dislikeBlog() {
        axios.post(`/dislike/${this.blog}`, { post: this.blog })
          .then(res => {
            // 좋아요와 싫어요 수를 업데이트하기 위해 fetchLikes 메서드 호출
            this.fetchLikes();
            this.disliked = !this.disliked; // 아이콘 변경
            this.liked = false; // 다른 버튼은 빈 아이콘으로 표시
            // 로컬 스토리지에 싫어요 상태 저장
            this.saveLikedToLocalStorage('dislike');
          })
          .catch(error => {
            console.log(error);
          });
      },
      fetchLikes() {
        axios.post('/like', { post: this.blog })
          .then(res => {
            if (res.data.post === null) {
              console.log("post is null");
              return;
            }
            // 좋아요와 싫어요 수 업데이트
            this.alllikes = res.data.post.like;
            this.alldislikes = res.data.post.dislike;
            // 좋아요와 싫어요 여부 업데이트
            this.updateLikesFromLocalStorage();
          });
      },
      saveLikedToLocalStorage(type) {
        // 로컬 스토리지에서 기존 값을 가져옴
        const likes = JSON.parse(localStorage.getItem(this.storageKey)) || {};
        // 현재 글의 좋아요/싫어요 상태를 업데이트
        if (type === 'like') {
          likes[this.postId] = 'like';
        } else if (type === 'dislike') {
          likes[this.postId] = 'dislike';
        }
        // 업데이트된 값을 다시 로컬 스토리지에 저장
        localStorage.setItem(this.storageKey, JSON.stringify(likes));
      },
      updateLikesFromLocalStorage() {
        // 로컬 스토리지에서 현재 글의 좋아요/싫어요 상태를 가져옴
        const likes = JSON.parse(localStorage.getItem(this.storageKey)) || {};
        const type = likes[this.postId];
        // 가져온 값이 없을 경우 반환
        if (!type) {
          return;
        }
        // 가져온 값에 맞게 좋아요/싫어요 상태를 업데이트
        if (type === 'like') {
          this.liked = true;
          this.disliked = false;
        } else if (type === 'dislike') {
          this.liked = false;
          this.disliked = true;
        }
      }
    },
    mounted() {
      this.fetchLikes();
    }
  };
  </script>
  