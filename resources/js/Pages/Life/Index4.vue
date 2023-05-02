<script setup>
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div class="original2 wi1200 mcenter mb30">
        <p>人生劇場3</p>
    </div>
    <div class="wi1200 tcenter mcenter f2 mb30">
        <p><button v-if="play" @click="start()" class="btn btn-primary wi300 f2">START</button></p>
        <p><button v-if="!play" @click="restart()" class="btn btn-primary wi300 f2">最初から</button></p>
    </div>



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

    <div v-if="nameDisplay" class="wi1200 mcenter mb30 ">
        <div class="dis">
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

            <div class="dis">
                <div v-for="(character, index) in characters" :key="index" class="wi200 mr20 bi101 p10">
                    <p>{{ character.name }}</p>
                    <p>{{ character.money }}円</p>
                    <div v-if="gogo">
                        <button v-if="!isPlayerTune && index == 0 && !isGameOver" @click="roll(index)"
                            class="btn btn-primary">サイコロを振る</button>
                        <button v-if="isPlayerTune && index == 1 && !isGameOver" @click="roll(index)"
                            class="btn btn-secondary">サイコロを振る</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mb50 tcenter">
        <div v-for="cell in cells" :class="{ 'cell': true, 'eventscell': eventCells.includes(cell) }">
            {{ cell }}

            <div v-for="character in characters">
                <img v-if="cell == character.position" class="wi50" :src="character.img" alt="">
            </div>
        </div>
    </div>

    <div v-if="nameDisplay" class="original3 f1-5">
        <p>{{ text1 }}</p>
        <p>{{ text2 }}</p>
        <br>
        <p>{{ text3 }}</p>
        <p v-if="nameInput <= 3" class="tcenter"><button @click="go()" class="btn btn-primary">スタート</button></p>
    </div>
</template>



<script>

const events = [
    { name: 'ああ', move: 0, cell: 2 },
    { name: 'ああ', move: 2, cell: 3 },
    { name: 'ああ', move: 0, cell: 4 },
    { name: 'ああ', move: 0, cell: 5 },
    { name: 'ああ', move: 0, cell: 6 },
    { name: 'いい', move: 3, cell: 7 },
    { name: 'うう', move: -2, cell: 10 },
    { name: 'ええ', move: -3, cell: 15 },
    { name: 'おお', move: 1, cell: 19 },
];

export default {
    data() {
        return {
            gogo: false,
            playerPosition: 1,
            cpuPosition: 1,
            isPlayerTune: '',
            // isPlayerTune: false,
            isGameOver: false,
            characters: [
                { name: "てつろー", img: "", position: 1, money: 10000 },
                { name: "えみ", img: "", position: 1, money: 10000 },
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
        // rollDice() {
        //     this.roll();
        //     const dice = Math.floor(Math.random() * 6) + 1;
        //     this.dice = dice;
        //     this.movePlayer(dice);
        //     this.isPlayerTune = true;
        // },
        // cpuRollDice() {
        //     this.roll();
        //     const dice = Math.floor(Math.random() * 6) + 1;
        //     this.dice = dice;
        //     this.moveCPU(dice);
        //     this.isPlayerTune = false;
        // },
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
                    this.isGameOver = true;
                    setTimeout(() => {
                        alert("プレイヤーの勝ちです");
                    }, 500);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                };
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
                    this.isGameOver = true;
                    setTimeout(() => {
                        alert("CPUの勝ちです");
                    }, 500);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                };
            }, 500)
        },
        event(position) {
            for (const event of events) {
                if (position == event.cell) {
                    this.text1 = event.name;
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