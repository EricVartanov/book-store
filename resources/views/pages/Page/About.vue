<template>
    <BaseLayout>
        <div class="container">
            <h1>О нас</h1>
            <p>
                <strong>Целое число:</strong> {{ number }}
            </p>
            <p>
                <strong>Строка:</strong> {{ text }}
            </p>
            <p>
                <strong>Массив:</strong>
            </p>
            <ul>
                <li v-for="(item, index) in items" :key="index">
                    {{ item }}
                </li>
            </ul>
            <p>
                <strong>Ассоциативный массив:</strong>
            </p>
            <ul>
                <li>Имя: {{ user.name }}</li>
                <li>Возраст: {{ user.age }}</li>
                <li>Роль: {{ user.role }}</li>
            </ul>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from "../../layouts/BaseLayout.vue";

const {number, text, items, user} = defineProps({
    number: Number,
    text: String,
    items: Array,
    user: Object,
})
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;

    ul {
        list-style: none;
        padding: 0;
    }
}
</style>
