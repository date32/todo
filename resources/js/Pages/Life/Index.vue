<script setup>
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <!-- タイトル -->
    <div class="original2 wi1200 mcenter mb30">
        <p>人生劇場</p>
    </div>
    <div class="wi1200 tcenter mcenter f2 mb30">
        <p><button v-if="play" @click="start()" class="btn btn-primary wi300 f2">START</button></p>
        <p><button v-if="!play" @click="restart()" class="btn btn-primary wi300 f2">最初から</button></p>
    </div>
    <!-- タイトル -->

    <!-- キャラクター選択 -->
    <div v-for="(character, index) in characters" :key="index" class="wi1200 mcenter mb30">
        <div v-if="nameInput == index + 1">
            <p>{{ index + 1 }}人目</p>
            <table>
                <tr>
                    <th>名前を入力して下さい</th>
                    <th>キャラクターを選んでください</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td><input class="mr20" type="text" v-model="character.name"></td>
                    <td>
                        <div class="dis">

                            <div v-for="(img, index) in imgs" :key="index"><img @click="imgCheck(character, index)"
                                    :src="img.img" alt="" :class="{ 'wi100 mr20': true, 'imgcheck': img.status }"></div>
                        </div>
                    </td>
                    <td><button @click="name(index)" class="btn btn-primary mr20">これにする</button></td>
                    <td>
                        <p>{{ error1 }}</p>
                        <p>{{ error2 }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- キャラクター選択 -->

    <div v-if="nameDisplay" class="wi1200 mcenter mb30 ">
        <div class="dis">

            <!-- 全体情報 -->
            <div class="mr20 bi100 p10">
                <table>
                    <tr>
                        <th width="150"></th>
                        <th width="100"></th>
                    </tr>
                    <tr>
                        <td>現在のターン</td>
                        <td v-if="isPlayerTune !== ''">{{ isPlayerTune ? characters[0].name : characters[1].name }}</td>
                    </tr>
                    <tr>
                        <td>{{ characters[0].name }}の位置</td>
                        <td>{{ playerPosition }}</td>
                    </tr>
                    <tr>
                        <td>{{ characters[1].name }}の位置</td>
                        <td>{{ cpuPosition }}</td>
                    </tr>
                    <tr>
                        <td v-if="isPlayerTune !== ''">{{ isPlayerTune ? characters[0].name : characters[1].name }}の出た目</td>
                        <td>{{ dice }}</td>
                    </tr>
                </table>
            </div>
            <!-- 全体情報 -->

            <!-- 個人情報 -->
            <div class="dis">
                <div v-for="(character, index) in characters" :key="index" class="wi200 mr20 bi101 p10">
                    <p>{{ character.name }}</p>
                    <p>{{ character.money }}円</p>
                    <div v-if="gogo">
                        <button v-if="!isPlayerTune && index == 0 && !isGameOver1" @click="roll(index)"
                            class="btn btn-primary">サイコロを振る</button>
                        <button v-if="isPlayerTune && index == 1 && !isGameOver2" @click="roll(index)"
                            class="btn btn-secondary">サイコロを振る</button>
                        <div>
                            <button v-if="!isPlayerTune && index == 0 && isGameOver1" @click="roll2(index)"
                                class="btn btn-primary">見守る</button>
                            <button v-if="isPlayerTune && index == 1 && isGameOver2" @click="roll2(index)"
                                class="btn btn-primary">見守る</button>
                        </div>

                    </div>

                </div>
            </div>
            <!-- 個人情報 -->

        </div>
    </div>

    <!-- マップ -->
    <div class="mb50 tcenter">
        <div v-for="cell in cells" class="cell">
            <!-- <div v-for="cell in cells" :class="{ 'cell': true, 'eventscell': eventCells.includes(cell) }"> -->
            {{ cell }}

            <div v-for="character in characters">
                <img v-if="cell == character.position" class="wi50" :src="character.img" alt="">
            </div>
        </div>
    </div>
    <!-- マップ -->

    <!-- テキスト蘭 -->
    <div v-if="nameDisplay" class="original3 f1-5">
        <p>{{ text1 }}</p>
        <p>{{ text2 }}</p>
        <br>
        <p>{{ text3 }}</p>
        <p v-if="nameInput <= 3" class="tcenter"><button @click="go()" class="btn btn-primary">スタート</button></p>
    </div>
    <!-- テキスト蘭 -->
</template>



<script>

const events = [
    { name1: '小学生', name2: 'ピカピカの1年生になりました。みんなからお祝いをもらいました。', name3: '10000円もらう', name4: '', name5: '', name6: '', money: 30000, move: 0, cell: 2 },
    { name1: '小学生', name2: '4年生で突然グレ始める。みんなに大金をばらまいた。', name3: '5000円減る', name4: '', name5: '', name6: '', money: -5000, move: 0, cell: 3 },
    { name1: '小学生', name2: '6年生の楽しい修学旅行。世界1周旅行なのでお金をもらった。', name3: '30000円もらう', name4: '', name5: '', name6: '', money: 50000, move: 0, cell: 4 },
    { name1: '中学生', name2: '好きなあの人を振り向かせようと自分を磨いた。しかし無駄だった。', name3: '5000円減る', name4: '', name5: '', name6: '', money: -5000, move: 0, cell: 5 },
    { name1: '中学生', name2: '部活の試合で全国制覇をしました。テレビ局から取材殺到！出演料もガッポリ！', name3: '10万円GET', name4: '', name5: '', name6: '', money: 100000, move: 0, cell: 6 },
    { name1: '中学生', name2: 'プログラミングコンテストで優勝！未来のプログラマーは君だ！', name3: '優勝賞金10万円', name4: '', name5: '', name6: '', money: 100000, move: 0, cell: 7 },
    { name1: '高校生', name2: 'バイト！バイト！バイト！成績は下がりとても怒られた。得たものは大金だったが大学には行かなかった。', name3: 'バイト代80000円もらう。大人になる', name4: '', name5: '', name6: '', money: 80000, move: 5, cell: 8 },
    { name1: '高校生', name2: '合唱コンクールの為にボイトレに通うことにした。', name3: '受講料20000円を払う', name4: '', name5: '', name6: '', money: -20000, move: 0, cell: 9 },
    { name1: '高校生', name2: '文化祭。中学から好きな人と楽しめなかった。時間よ戻れ！', name3: '中学生に戻る途中に50000円拾う', name4: '', name5: '', name6: '', money: 50000, move: -6, cell: 10 },
    { name1: '大学生', name2: 'パチンコ・スロットに明け暮れる。なぜか勝ちまくる。', name3: '20万円稼いだ', name4: '', name5: '', name6: '', money: 200000, move: 0, cell: 11 },
    { name1: '大学生', name2: '東大生のクイズ王誕生！芸能界へ片足を踏み入れる。', name3: '30万円稼いだ', name4: '', name5: '', name6: '', money: 300000, move: 0, cell: 12 },
    { name1: '大学生', name2: 'サークルの卒業旅行では贅沢をしすぎてしまった。', name3: '50000円使った', name4: '', name5: '', name6: '', money: -50000, move: 0, cell: 13 },
    { name1: '大人', name2: '大人の階段上る。いや、上りたくない。まだ子どもでいたい。あの時に戻る', name3: '30000円払って過去へ', name4: '', name5: '', name6: '', money: -30000, move: -7, cell: 14 },
    { name1: '大人', name2: '一生懸命仕事を頑張る。働いた分だけ給料をもらえた。', name3: '50万円稼いだ', name4: '', name5: '', name6: '', money: 500000, move: 0, cell: 15 },
    { name1: '大人', name2: 'ついに結婚しました！みんなから祝福を頂いた。', name3: '50万円もらった', name4: '', name5: '', name6: '', money: 500000, move: 0, cell: 16 },
    { name1: '大人', name2: '特に何もせずに時間だけが過ぎていった。いつのまにか老人になっていた。', name3: '40年貯めた貯金箱には10万円入っていた', name4: '', name5: '', name6: '', money: 100000, move: 4, cell: 17 },
    { name1: '大人', name2: '子どもが生まれた。みんなから祝福を頂いた。', name3: '50万円もらった', name4: '', name5: '', name6: '', money: 500000, move: 0, cell: 18 },
    { name1: '大人', name2: '何もかもうまくいかない。始めた事業も倒産した。', name3: '20万円なくなった', name4: '', name5: '', name6: '', money: -200000, move: 0, cell: 19 },
    { name1: '大人', name2: '大企業の社長に就任！この国を牛耳ることになる', name3: '100万円手に入れた', name4: '', name5: '', name6: '', money: 1000000, move: 0, cell: 20 },
    { name1: '大人', name2: '孫が50人になり、有名人になった。', name3: 'テレビ出演料50万円もらった', name4: '', name5: '', name6: '', money: 500000, move: 0, cell: 21 },
    { name1: '老後', name2: '老人ホームに入ることになった。さみしい。。。', name3: '30万円払う', name4: '', name5: '', name6: '', money: -300000, move: 0, cell: 22 },
    { name1: '老後', name2: '老後は趣味にお金を使おうと思い、船を買った。', name3: '30万円払う', name4: '', name5: '', name6: '', money: -300000, move: 0, cell: 23 },
    { name1: '老後', name2: '人生最後のギャンブル！夢の大金を掴む！１０００億円手に入れるが、ほとんど寄付をした。', name3: '200万円だけ残した。', name4: '', name5: '', name6: '', money: 2000000, move: 0, cell: 24 },

];

export default {
    data() {
        return {
            gogo: false,
            playerPosition: 1,
            cpuPosition: 1,
            isPlayerTune: '',
            // isPlayerTune: false,
            isGameOver1: false,
            isGameOver2: false,
            characters: [
                { name: "", img: "", position: 1, money: 10000 },
                { name: "", img: "", position: 1, money: 10000 },
            ],
            cells: Array(25).fill().map((_, index) => index + 1),
            dice: '',
            eventCells: events.map(event => event.cell),

            play: true,
            nameInput: 0,
            nameDisplay: false,
            imgs: [
                { img: "storage/img/life/1.jpg", status: false },
                { img: "storage/img/life/2.jpg", status: false },
                { img: "storage/img/life/3.jpg", status: false },
                { img: "storage/img/life/4.jpg", status: false },
                { img: "storage/img/life/5.jpg", status: false },
                { img: "storage/img/life/6.jpg", status: false },
            ],
            error1: '',
            error2: '',
            text1: '',
            text2: '',
            text3: '',
            goal: 0,







        };
    },
    methods: {
        start() {
            this.nameInput += 1;
            this.play = false;
        },
        restart() {
            location.reload();
        },
        name(index) {
            this.error1 = '';
            this.error2 = '';
            if (this.characters[index].name == '') {
                this.error1 = '名前が入力させていません';
            }
            if (this.characters[index].img == '') {
                this.error2 = 'キャラクターを選んでいません';
            }
            if (this.error1 == '' && this.error2 == '') {
                this.nameInput += 1;
                if (this.nameInput == 3) {
                    this.nameDisplay = true;
                    this.text1 = this.characters[0].name + 'が生まれた';
                    this.text2 = this.characters[1].name + 'が生まれた';
                    this.text3 = 'みんな1万円をもらいました';
                }
            }

        },
        imgCheck(character, index) {
            this.imgs.forEach((img, i) => {
                img.status = (i === index);
            });
            character.img = this.imgs[index].img;
        },
        go() {
            this.gogo = true;
        },
        roll(index) {
            this.nameInput += 1;
            this.text1 = '';
            this.text2 = '';
            this.text3 = '';
            const dice = Math.floor(Math.random() * 6) + 1;
            this.dice = dice;
            if (index == 0) {
                this.movePlayer(dice);
                this.isPlayerTune = true;
            }
            if (index == 1) {
                this.moveCPU(dice);
                this.isPlayerTune = false;
            }
        },
        roll2(index) {
            this.text1 = '';
            this.text2 = '';
            this.text3 = '';
            if (index == 0) {
                this.isPlayerTune = true;
            }
            if (index == 1) {
                this.isPlayerTune = false;
            }
        },
        movePlayer(dice) {
            const newPosition = Math.min(this.playerPosition + dice, 25);
            const move = setInterval(() => {
                dice > 0 ? this.playerPosition += 1 : this.playerPosition -= 1;
                this.characters[0].position = this.playerPosition;
                if (this.playerPosition == newPosition) {
                    setTimeout(() => {
                        this.event(this.playerPosition);
                    }, 500);
                    clearInterval(move);
                };

                if (this.characters[0].position == 25) {
                    this.isGameOver1 = true;
                    // setTimeout(() => {
                    //     alert("神様になりました");
                    // }, 500);
                    this.text1 = this.characters[0].name + 'は神様です';
                    this.goal += 1;
                    // setTimeout(() => {
                    //     location.reload();
                    // }, 1500);

                };
                if (this.goal == 2) {
                    this.gameResult();
                }
            }, 500)
        },
        moveCPU(dice) {
            const newPosition = Math.min(this.cpuPosition + dice, 25);
            const move = setInterval(() => {
                dice > 0 ? this.cpuPosition += 1 : this.cpuPosition -= 1;
                this.characters[1].position = this.cpuPosition;
                if (this.cpuPosition == newPosition) {
                    setTimeout(() => {
                        this.event(this.cpuPosition);
                    }, 500);
                    clearInterval(move);
                };

                if (this.characters[1].position == 25) {
                    this.isGameOver2 = true;
                    // setTimeout(() => {
                    //     alert("神様になりました");
                    // }, 500);
                    this.text1 = this.characters[1].name + 'は神様です';
                    this.goal += 1;
                    // setTimeout(() => {
                    //     location.reload();
                    // }, 1500);
                    
                };
                if (this.goal == 2) {
                        this.gameResult();
                    }
            }, 500)
        },
        event(position) {
            for (const event of events) {
                if (position == event.cell) {
                    this.text1 = event.name1;
                    this.text2 = event.name2;
                    this.text3 = event.name3;
                    if (this.isPlayerTune) {
                        this.characters[0].money += event.money;
                    } else {
                        this.characters[1].money += event.money;
                    }
                    if (event.move !== 0) {
                        // this.isPlayerTune ? this.eventMoveCPU(event.move) : this.eventMovePlayer(event.move);
                        this.isPlayerTune ? this.eventMovePlayer(event.move) : this.eventMoveCPU(event.move);
                    }

                };
            };

        },
        eventMovePlayer(eventMove) {
            const newPosition = Math.min(this.playerPosition + eventMove, 25);
            const move = setInterval(() => {
                eventMove > 0 ? this.playerPosition += 1 : this.playerPosition -= 1;
                this.characters[0].position = this.playerPosition;
                if (this.playerPosition == newPosition) {
                    clearInterval(move);
                };
            }, 500)

        },
        eventMoveCPU(eventMove) {
            const newPosition = Math.min(this.cpuPosition + eventMove, 25);
            const move = setInterval(() => {
                eventMove > 0 ? this.cpuPosition += 1 : this.cpuPosition -= 1;
                this.characters[1].position = this.cpuPosition;
                if (this.cpuPosition == newPosition) {
                    clearInterval(move);
                };
            }, 500)
        },
        gameResult() {
            this.text1 = this.characters[0].name + 'は' + this.characters[0].money + '円';
            this.text2 = this.characters[1].name + 'は' + this.characters[1].money + '円';
            if (this.characters[0].money > this.characters[1].money) {
                this.text3 = '勝者は' + this.characters[0].name + 'です';
            } else {
                this.text3 = '勝者は' + this.characters[1].name + 'です';
            }

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

.wi50 {
    width: 50px;
}

.he500 {
    height: 200px;
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

.mb50 {
    margin-bottom: 50px;
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

.p10 {
    padding: 10px;
}

.dis {
    display: flex;
}

.dis-b {
    display: block;
}

.dis-i {
    display: inline;
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

.bc4 {
    background-color: #c1f8fe;
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

.original2 {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333333;
    background-color: #f0b6b6;
    font-size: 30px;
    /* width: 300px; */
    height: 100px;
    border-radius: 3px;
    box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0);
    position: relative;
}

.original2::after {
    content: "";
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    height: 8px;
    box-shadow: 0 40px 15px rgba(0, 0, 0, .5);
    background-color: transparent;
    border-radius: 80px / 4px;
}

.original3 {
    margin: 0 auto;
    width: 1200px;
    height: 250px;
    border: 5px solid;
    padding: 30px;
    background-color: #c1f8fe;
    border-radius: 10px;
}


.cell {
    border: 1px solid;
    background-color: #f0b6b6;
    width: 50px;
    height: 50px;
    display: inline-block;
    text-align: center;
    vertical-align: middle;
}

.eventscell {
    background-color: aqua;
}

.imgcheck {
    border: 5px dashed red;
}

.bi100 {
    background-image: url('storage/img/life/b100.jpg');
}

.bi101 {
    background-image: url('storage/img/life/b101.jpg');
}
</style>