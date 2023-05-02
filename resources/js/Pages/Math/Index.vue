<script setup>

</script>

<template>
    <div class="wi1200 mcenter tcenter f2 header mt30 p">
        <h2>
            算数・数学
        </h2>
        <p>勉強しよう</p>
    </div>



    <div class="wi1200 dis mcenter mt30 mb30">

        <div class="wi600">
            <div class="f2 mb30 tcenter">
                <p>生徒を登録します</p>
                <input class="mr10 " v-model="name" type="text" placeholder="名前を入力してください">
                <button class="btn btn-primary" @click="nameCreate">登録</button>
            </div>

            <div class="f1-5 mb30 ">
                <p>誰が学習しますか？</p>
                <div v-for="(student, index) in students" :key="student.id">
                    <table>
                        <tr>
                            <th width="200px"></th>
                            <th width="100px"></th>
                            <th width="250px"></th>
                        </tr>
                        <tr>
                            <td><a :href="'/math/student/' + student.id" class="mr20 ml30">{{ student.name }}</a></td>
                            <td><button @click="delStudent(student.id)" class="btn btn-danger"
                                    @mouseover="showText[index] = true" @mouseout="showText[index] = false">削除</button>
                            </td>
                            <td>
                                <p v-if="showText[index]">本当に削除しますか？</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="wi600 tcenter">
            <p v-if="name !== ''" class="mt60 f1-5">"{{ name }}"という名前で登録されます</p>
            <p v-if="name !== ''" class="f1-5">是非頑張りましょう!!</p>
            <p v-if="name !== ''" class="f1-5">算数・数学を<span class="f2 c-red">基本からしっかり</span>学べます</p>
            <p v-if="name !== ''" class="f1-5">基本が理解出来たら<span class="f2 c-red">応用問題</span>で力をつけよう！</p>
        </div>

    </div>


    <div class="wi1200 dis mcenter mt30 mb30">

        <div class="wi600">
            <div class="dis">
                <div>
                    <p>問題を作成する場合は暗証番号が必要です</p>
                    <input type="password" v-model="password" placeholder="'asd'です" class="mr20">
                    <button @click="submit" class="btn btn-primary">送信</button>
                </div>
                <div>
                    <br>

                    <p v-if="authorized" class="f2">-------------></p>
                </div>
            </div>


        </div>

        <div class="wi600">
            <div v-if="authorized">
                <div class="f1-5 tcenter">
                    <a href="/math/edit">問題作成</a>
                </div>
                <div class="f1-5 tcenter">
                    <p>素晴らしい問題を作成しましょう。</p>
                </div>
            </div>
        </div>

    </div>
</template>



<script>

export default {

    data() {
        return {
            name: '',
            id: '',
            title: '',
            showText: {},
            password: '',
            authorized: false,
        };
    },

    props: {
        students: Array,
        boards: Array,
    },


    methods: {
        nameCreate() {
            const data = {
                name: this.name,
            }
            axios.post('/math/student-create', data)
                .then(response => {
                    this.students.push(response.data)
                    this.name = '';
                })
                .catch(error => {
                });
        },

        delStudent(id) {
            axios.delete(`/math/student-delete/${id}`)
                .then(response => {
                    const index = this.students.findIndex(student => student.id === id);
                    this.students.splice(index, 1);
                    // console.log(response.data.message);
                })
                .catch(error => {
                });
        },

        submit() {
            if (this.password === 'asd') {
                this.authorized = true;
            } else {
                this.authorized = false;
            }
        },








    }
}

</script>

<style>
.t1 {
    background-color: aqua;
}

.t2 {
    background-color: blueviolet;
}

.t3 {
    background-color: brown;
}

a {
    color: blue;
    border-bottom: 1px solid;
}

.wi1200 {
    width: 1200px;
}

.wi600 {
    width: 600px;
}

.mcenter {
    margin: 0 auto;
}

.tcenter {
    text-align: center;
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
.p {
    padding: 10px;
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

.header {
    border: 5px solid;
    border-radius: 20px;
}
</style>
