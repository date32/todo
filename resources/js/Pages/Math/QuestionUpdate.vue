<script setup>

</script>

<template>
   
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                算数・数学
            </h2>
      

        <div class="wi1200 mcenter mt30 mb30">
            <div class="f1-5">
                <p><a href="/math/edit">問題作成へ戻る</a></p>
                <p><a href="/math">TOPへ戻る</a></p>
            </div>

            <div class="mcenter tcenter f2">
                <p>問題編集・画像登録</p>
            </div>
        </div>



        <div class="wi1200 mcenter tcenter mt30 mb30">
            <div class="wi600 mcenter bor pt30 pb30 bc1">
                <form @submit.prevent="uploadFile(math.id)" enctype="multipart/form-data">
                    <input type="file" id="fileInput" name="file" @change="onFileChange">
                    <button type="submit" class="btn btn-primary bc-blue">アップロード</button>
                </form>
            </div>

        </div>


        <div class="wi1200 mcenter mt30 mb30 dis">

            <div class="wi600 tcenter">
                <div class="dis mb30">
                    <div class="wi400 f1-5 mr20">
                        <p>「{{ math.title }}」</p>
                    </div>
                    <div><button @click="titleEdit" v-if="editTitle" class="btn btn-success">タイトルを変更する</button></div>
                </div>

                <div class="dis mb30">
                    <div class="wi400 f1-5 mr20">
                        <p>{{ math.question }}</p>
                    </div>
                    <div><button @click="questionEdit" v-if="editQuestion" class="btn btn-success">問題を変更する</button></div>
                </div>

                <div v-if="math.img != null" class="dis mb30">
                    <div class="wi400 mr20"><img class="wi20" :src="math.img" alt="画像"></div>
                    <div><button @click="delImg(math.id)" class="btn btn-danger">画像を削除する</button></div>
                </div>

                <div class="dis mb30">
                    <div class="wi400 f1-5 mr20">
                        <p>{{ math.answer }}</p>
                    </div>
                    <div><button @click="answerEdit" v-if="editAnswer" class="btn btn-success">解答を変更する</button></div>
                </div>
            </div>

            <div class="wi600 tcenter f1-5">
                <div class="dis mb30" v-if="!editTitle">
                    <div class="wi100">
                        タイトル:
                    </div>
                    <div class="wi400 f1-5 mr20">
                        <input v-model="title" type="text" :placeholder="math.title">
                    </div>
                    <div class="wi100">
                        <button @click="titleChange(math.id)" class="btn btn-primary">変更</button>
                    </div>
                </div>

                <div class="dis mb30" v-if="!editQuestion">
                    <div class="wi100">
                        問題:
                    </div>
                    <div class="wi400 f1-5 mr20">
                        <textarea v-model="question" :placeholder="math.question" cols="40" rows="10"></textarea>
                    </div>
                    <div>
                        <button @click="questionChange(math.id)" class="btn btn-primary">変更</button>
                    </div>
                </div>

                <div class="dis mb30" v-if="!editAnswer">
                    <div class="wi100">
                        解答:
                    </div>
                    <div class="wi400 f1-5 mr20">
                        <input v-model="answer" type="text" :placeholder="math.answer">
                    </div>
                    <div>
                        <button @click="answerChange(math.id)" class="btn btn-primary">変更</button>
                    </div>
                </div>

            </div>

        </div>

   
</template>



<script>

export default {

    data() {
        return {
            title: '',
            question: '',
            answer: '',
            id: '',
            file: null,
            math: {},
            showImage: true,
            editTitle: true,
            editQuestion: true,
            editAnswer: true,

        };
    },

    // props: ['math'],

    props: {
        math: Array
    },


    methods: {
        onFileChange(event) {
            this.file = event.target.files[0];
        },
        uploadFile(id) {
            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(`/math/upload/${id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    document.getElementById('fileInput').value = ''
                    this.math = response.data;
                    location.reload();

                    // アップロード成功時の処理
                    console.log(response.data);
                    // リダイレクトなどの処理を追加する場合はここに記述
                })
                .catch(error => {
                    // アップロード失敗時の処理
                    console.log(error.response.data);
                });
        },
        titleChange(id) {
            const data1 = {
                id: id,
                title: this.title,
            }

            axios.post(`/math/update/title/${id}`, data1)
                .then(response => {
                    this.math = response.data;
                    // this.math.push(response.data);
                    this.title = '';
                    this.titleEdit();
                    this.$inertia.reload();
                })
                .catch(error => {
                });
        },

        titleEdit() {
            this.editTitle = !this.editTitle;
        },

        questionChange(id) {
            const data2 = {
                id: id,
                question: this.question,
            }

            axios.post(`/math/update/question/${id}`, data2)
                .then(response => {
                    this.math = response.data;
                    // this.math.push(response.data);
                    this.question = '';
                    this.questionEdit();
                    this.$inertia.reload();
                })
                .catch(error => {
                });
        },

        questionEdit() {
            this.editQuestion = !this.editQuestion;
        },

        answerChange(id) {
            const data3 = {
                id: id,
                answer: this.answer,
            }

            axios.post(`/math/update/answer/${id}`, data3)
                .then(response => {
                    this.math = response.data;
                    // this.math.push(response.data);
                    this.answer = '';
                    this.answerEdit();
                    this.$inertia.reload();
                })
                .catch(error => {
                });
        },

        answerEdit() {
            this.editAnswer = !this.editAnswer;
        },

        delImg(id) {
            axios.post(`/math/delete/img/${id}`)
                .then(response => {
                    this.math = response.data;
                    this.$inertia.reload();
                })
                .catch(error => {
                });
        },

    }
}

</script>

<style>
a {
    color: blue;
    border-bottom: 1px solid;
}

.t1 {
    background-color: aqua;
}

.t2 {
    background-color: blueviolet;
}

.t3 {
    background-color: brown;
}

.wi1200 {
    width: 1200px;
}

.wi600 {
    width: 600px;
}

.wi500 {
    width: 500px;
}

.wi400 {
    width: 400px;
}

.wi200 {
    width: 200px;
}

.wi100 {
    width: 100px;
}

.mcenter {
    margin: 0 auto;
}

.tcenter {
    text-align: center;
}

.ttop {
    vertical-align: top;
}

.mt30 {
    margin-top: 30px;
}

.mt60 {
    margin-top: 60px;
}

.mb30 {
    margin-bottom: 30px;
}

.mr20 {
    margin-right: 20px;
}

.mr10 {
    margin-right: 10px;
}

.ml30 {
    margin-left: 30px;
}

.pt30 {
    padding-top: 30px;
}

.pb30 {
    padding-bottom: 30px;
}

.dis {
    display: flex;
}

.f1-5 {
    font-size: 1.5rem;
}

.f2 {
    font-size: 2rem;
}

.c-red {
    color: red;
}

.bc-blue {
    background-color: blue;
}

.bc1 {
    background-color: rgb(179, 255, 252);
}

.b {
    border-bottom: 1px solid;
}

.bor {
    border: 1px solid;
}

.b-d {
    border-bottom: 1px dashed;
}
</style>


