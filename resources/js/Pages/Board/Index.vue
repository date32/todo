<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import FormSection from '@/Components/FormSection.vue';
import { VueElement } from 'vue';
import { createApp } from 'vue'


</script>

<template>
    <AppLayout title="掲示板">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                掲示板
            </h2>
        </template>
        

        <div>
            <input v-model="title" type="text" placeholder="タイトル">
            <input v-model="content" type="text" placeholder="内容">
            <button @click="saveData">保存</button>
        </div>

        <table>
            <tr>
                <th>タイトル</th>
                <th>内容</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr v-if="editingBoard">
                <td><input v-model="editingBoard.title" /></td>
                <td><input v-model="editingBoard.content" /></td>
                <td></td>
                <td></td>
                <td><button @click="updateData(editingBoard.id)">変更する</button></td>
                <td><button @click="cancelEdit">キャンセル</button></td>
            </tr>
            <tr v-for="(board, index) in boards" :key="board.id">
                <td>{{ board.title }}</td>
                <td>
                    <div v-if="board.content.length <= 3">
                        {{ board.content }}
                    </div>
                    <div v-else @click="toggleContent(index)">
                        {{ showFullContent[index] ? board.content : board.content.substring(0, 3) + '...' }}
                    </div>
                </td>
                <td>{{ board.likes }}</td>
                <td @click="likeData(board.id)"><button>みたよ!</button></td>
                <td @click="showEditForm(board)"><button>変更</button></td>
                <td @click="deleteData(board.id)"><button>削除</button></td>
            </tr>

        </table>








    </AppLayout>
</template>



<script>

export default {

    data() {
        return {
            title: '',
            content: '',
            likes: '',
            message: 'asdafjkfjkdhsfjkdfjfakkashasfasg',
            id: '',
            editingBoard: null,
            showFullContent: [],
        };
    },

    props: {
        boards: Array,
    },


    methods: {
        saveData() {
            const data = {
                title: this.title,
                content: this.content
            };

            // Laravelのルートにデータを送信
            axios.post('/save-data', data)
                .then(response => {
                    this.boards.push(response.data)
                    this.title = '';
                    this.content = '';
                    console.log('データが保存されました。');
                })
                .catch(error => {
                    console.error('データの保存に失敗しました。', error);
                });
        },

        deleteData(id) {
            // データを削除
            axios.delete(`/delete-data/${id}`)
                .then(response => {
                    // 削除後のデータを再設定して表示を更新
                    // this.boards = response.data.boards;
                    const index = this.boards.findIndex(board => board.id === id);
                    this.boards.splice(index, 1);
                    console.log(response.data.message); // 削除成功時のメッセージを表示
                })
                .catch(error => {
                    console.error(error);
                });
        },

        showEditForm(board) {

            this.editingBoard = {
                id: board.id,
                title: board.title,
                content: board.content,
            };
        },

        updateData(id) {
            const data = {
                title: this.editingBoard.title,
                content: this.editingBoard.content
            };

            // Laravelのルートにデータを送信
            axios.put(`/board/${id}`, data) // PUTリクエストで更新用のルートを呼び出し
                .then(response => {
                    // データを更新
                    const index = this.boards.findIndex(board => board.id === id);
                    this.boards[index] = response.data;
                    console.log('データが更新されました。');
                    this.cancelEdit(); // 編集モードを終了
                })
                .catch(error => {
                    console.error('データの更新に失敗しました。', error);
                });
        },

        cancelEdit() {
            this.editingBoard = null;
        },

        likeData(id) {
            // Laravelのルートにみたよのリクエストを送信
            axios.post(`/like/${id}`)
                .then(response => {
                    // みたよ数を更新
                    const index = this.boards.findIndex(board => board.id === id);
                    this.boards[index].likes = response.data.likes;
                    console.log(response.data.message); // みたよ成功時のメッセージを表示
                })
                .catch(error => {
                    console.error(error);
                });
        },
        toggleContent(index) {
            // クリックした行のcontentの表示状態を切り替える
            this.showFullContent[index] = !this.showFullContent[index];
        },
    }
}

</script>

<style>

</style>


