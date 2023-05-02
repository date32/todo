<script setup>

</script>

<template>
   
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                算数・数学
            </h2>
       

        <div class="wi1200 mcenter mt30 mb30">
            <div class="f1-5"><a href="/math">TOPへ戻る</a></div>
            <div class="mcenter tcenter f2">
                <p>問題作成</p>
            </div>
        </div>
        <!-- //////////問題作成////////// -->
        <!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
        <div class="wi1200 mcenter mb30 dis">

            <div class="wi600 tcenter f1-5">
                <table>
                    <tr>
                        <td class="ttop">タイトル:</td>
                        <td>
                            <div class="mb30"><input class="wi400" v-model="title" type="text" placeholder="タイトルを入力してください">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ttop">問題:</td>
                        <td>
                            <div class="mb30"><textarea v-model="question" cols="50" rows="10"
                                    placeholder="問題を入力してください"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ttop">解答:</td>
                        <td>
                            <div class="mb30"><input class="wi400" v-model="answer" type="text" placeholder="答えを入力してください">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="mb30 btn btn-primary"><button @click="questionCreate">登録</button></div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="wi600 tcenter f1-5">
                <div v-if="title !== ''" class="b-d">
                    <p>「{{ title }}」</p>
                    <p>※わかりやすいタイトルにしましょう</p>
                </div>
                <div v-if="question !== ''" class="b-d">
                    <p>問題</p>
                    <p>{{ question }}</p>
                    <p>※画像を挿入する場合は「編集」よりアップロードしてください</p>
                </div>
                <div v-if="answer !== ''" class="b-d">
                    <p>解答</p>
                    <p>{{ answer }}</p>
                    <p>※お間違えの無いように確認してください</p>
                </div>
            </div>

        </div>
        <!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
        <!-- //////////問題作成////////// -->


        <!-- //////////問題一覧////////// -->
        <!-- ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓ -->
        <div class="wi1200 mcenter tcenter mt30 mb30 f2">
            <p>問題一覧</p>

            <div class="dis">
                <div class="wi600 tcenter">
                    <table class="f1-5">
                        <tr v-for="(math, index) in maths" :key="math.id">
                            <td>
                                <div class="mr20">「{{ math.title }}」</div>
                            </td>
                            <td>
                                <div class="mr20">
                                    <button @click="openQuetion(math)" class="btn btn-success">確認する</button>
                                </div>
                            </td>
                            <td>
                                <div class="mr20">
                                    <a :href="'/math/update/' + math.id" class="btn btn-primary">編集する</a>
                                </div>
                            </td>
                            <td>
                                <div class="mr20">
                                    <button @click="delQuestion(math.id)" class="btn btn-danger">削除</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="wi600 tcenter f1-5">
                    <div v-if="open">
                        <div class="b-d mb30" >
                            <p>「{{ math.title }}」</p>
                            <p>{{ math.question }}</p>
                            <img :src="math.img" alt="" class="mb30">
                        </div>
                        <div>
                            <p class="mb30">{{ math.answer }}</p>
                            <button @click="close" class="btn btn-primary">閉じる</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑ -->
        <!-- //////////問題作成////////// -->



</template>



<script>

export default {

    data() {
        return {
            title: '',
            question: '',
            answer: '',
            showText: {},
            open: false,
            img: '',
            math: null,
        };
    },

    props: {
        maths: Array
    },


    methods: {
        questionCreate() {
            const data = {
                title: this.title,
                question: this.question,
                answer: this.answer,
            }
            axios.post('/math/question-create', data)
                .then(response => {
                    this.maths.push(response.data)
                    this.title = '';
                    this.question = '';
                    this.answer = '';
                    console.log('データが保存されました。');
                })
                .catch(error => {
                });
        },

        delQuestion(id) {
            axios.delete(`/math/question-delete/${id}`)
                .then(response => {
                    const index = this.maths.findIndex(math => math.id === id);
                    this.maths.splice(index, 1);
                })
                .catch(error => {
                });
        },

        openQuetion(math) {
            this.open = false;
            this.math = {
                title: math.title,
                question: math.question,
                answer: math.answer,
                img: math.img,
            };
            this.open = true;
        },

        close() {
            this.open = false;
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

.wi400 {
    width: 400px;
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

.b {
    border-bottom: 1px solid;
}

.b-d {
    border-bottom: 1px dashed;
}
</style>


