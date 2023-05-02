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
                算数・数学
            </h2>
        </template>

        <p>ファイルをアップロードします</p>
        <form @submit.prevent="uploadFile" enctype="multipart/form-data">
            <input type="file" name="file" @change="onFileChange">
            <button type="submit">アップロード</button>
        </form>








    </AppLayout>
</template>



<script>

export default {

    data() {
        return {
            file: null,
        };
    },

    props: {
        maths: Array
    },


    methods: {
        onFileChange(event) {
            this.file = event.target.files[0];
        },
        uploadFile() {
            let formData = new FormData();
            formData.append('file', this.file);

            axios.post('/math/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                // アップロード成功時の処理
                console.log(response.data);
                // リダイレクトなどの処理を追加する場合はここに記述
            })
            .catch(error => {
                // アップロード失敗時の処理
                console.log(error.response.data);
            });

        }




    }
}

</script>

<style>
a {
    color: blue;
    border-bottom: 1px solid;
}
</style>


