<script setup>
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div class="original2 wi1200 mcenter">人生劇場</div>
    <div>
        <table>
            <tr>
                <td>現在のターン</td>
                <td>{{ isPlayerTune ? 'プレイヤー' : 'CPU' }}</td>
            </tr>
            <tr>
                <td>プレイヤーの位置</td>
                <td>{{ playerPosition }}</td>
            </tr>
            <tr>
                <td>CPUの位置</td>
                <td>{{ cpuPosition }}</td>
            </tr>
            <tr>
                <td>{{ isPlayerTune ? 'プレイヤー' : 'CPU' }}の出た目</td>
                <td>{{ dice }}</td>
            </tr>
        </table>
        <button v-if="isPlayerTune && !isGameOver" @click="rollDice()" class="btn btn-primary">自分のターン</button>
        <button v-if="!isPlayerTune && !isGameOver" @click="cpuRollDice()" class="btn btn-secondary">相手のターン</button>
    </div>
    <div class="mb50">
        <div v-for="cell in cells" :class="{ 'cell': true, 'eventscell': eventCells.includes(cell) }">
            {{ cell }}

            <div v-for="character in characters">
                <img v-if="cell == character.position" class="wi50" :src="character.img" alt="">
            </div>
        </div>
    </div>
    <div>
        <p><button @click="start()">最初に戻る</button></p>
    </div>
    
</template>



<script>

const characters = [
    { name: "てつろー", img: "storage/img/1.jpg", position: 1 },
    { name: "えみ", img: "storage/img/5.jpg", position: 1 },
];
const events = [
    { name: 'ああ', move: 2, cell: 3 },
    { name: 'いい', move: 3, cell: 6 },
    { name: 'うう', move: -2, cell: 10 },
    { name: 'ええ', move: -3, cell: 15 },
    { name: 'おお', move: 1, cell: 19 },
];

export default {
    data() {
        return {
            playerPosition: 1,
            cpuPosition: 1,
            isPlayerTune: true,
            isGameOver: false,
            characters: characters,
            cells: Array(25).fill().map((_, index) => index + 1),
            dice: '',
            eventCells: events.map(event => event.cell),




        };
    },
    methods: {
        rollDice() {
            const dice = Math.floor(Math.random() * 6) + 1;
            this.dice = dice;
            this.movePlayer(dice);
            this.isPlayerTune = !this.isPlayerTune;
        },
        cpuRollDice() {
            const dice = Math.floor(Math.random() * 6) + 1;
            this.dice = dice;
            this.moveCPU(dice);
            this.isPlayerTune = !this.isPlayerTune;
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
                    this.isGameOver = true;
                    setTimeout(() => {
                        alert("プレイヤーの勝ちです");
                    }, 500);
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
                };
            }, 500)
        },
        event(position) {
            for (const event of events) {
                if (position == event.cell) {
                    alert(event.name);
                    this.isPlayerTune ? this.moveCPU(event.move) : this.movePlayer(event.move);
                };
            };
        },
        start() {
            location.reload();
        }
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
</style>