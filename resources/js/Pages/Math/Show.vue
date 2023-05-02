<script setup>

</script>

<template>
   
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                算数・数学
            </h2>
      

        <div class="wi1200 mcenter mt30 mb30">
            <div class="f1-5 mb30">
                <p><a href="/math">生徒を変更する</a></p>
            </div>
            <div class="bc1">
                <div class="p">
                    <p>ようこそ{{ student.name }}さん</p>
                    <p>現在{{ student.score }}点です</p>
                </div>

            </div>
        </div>

        <div class="wi1200 mcenter mt30 mb30">
            <div class="dis">

                <div class="wi300 bc2 mr20">
                    <div class="original1 m">
                        <div class="f1-5">問題一覧</div>
                        <div v-for="math in maths" :key="math.id" class="f1-5">
                            <button @click="openQuestion(math)" class="btn btn-link">{{ math.title }}</button>

                        </div>
                    </div>

                </div>

                <div class="wi900 tcenter p bc3">
                    <div v-if="toggle">
                        <p class="mb10">「{{ math.title }}」</p>
                        <p class="mb10">{{ math.question }}</p>
                        <img :src="math.img" class="wi20 mb10" alt="">
                        <p v-if="!answer"><button @click="openAnswer" class="btn btn-success">答えを見る</button></p>
                        <p v-if="answer"  class="mb10">{{ math.answer }}</p>
                        <p v-if="answer"><button @click="success(student)" class="btn btn-primary mb10">出来た</button></p>
                        <p v-if="answer"><button @click="openAnswer" class="btn btn-success">閉じる</button></p>
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
            img: '',
            toggle: false,
            math: null,
            answer: false,
            student: {},
        };
    },

    props: {
        student: Array,
        maths: Array,
    },


    methods: {
        openQuestion(math) {
            this.toggle = false
            this.answer = false,
            // this.toggle = !this.toggle
            this.math = {
                title: math.title,
                question: math.question,
                answer: math.answer,
                img: math.img,
            };
            this.toggle = true
        },

        openAnswer() {
            this.answer = !this.answer

        },

        success(student) {
            const data = {
                id: student.id,
            }
            axios.post("/math/student/score", data)
            .then(response => {
                this.student = response.data;
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

.wi900 {
    width: 900px;
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

.wi300 {
    width: 300px;
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
.mb10 {
    margin-bottom: 10px;
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

.m {
    margin: 20px;
}

.pt30 {
    padding-top: 30px;
}

.pb30 {
    padding-bottom: 30px;
}

.p {
    padding: 20px;
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
    background-color: rgba(216, 242, 240, 0.689);
}

.bc2 {
    background-color: #d4e1f2;
}

.bc3 {
    background-color: #f1c3d7;
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

.original1 {
    align-items: center;
    justify-content: center;
    color: #333333;
    border-radius: 3px;
    box-shadow: inset -5px -5px 10px 0px rgba(255, 255, 255, 0.5), inset 5px 5px 10px 0px rgba(0, 0, 0, 0.3);
}
</style>


