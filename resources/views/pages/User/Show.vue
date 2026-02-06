<template>
    <BaseLayout>
        <Head :title="user.name"/>

        <h1>Карточка пользователя</h1>

        <div>
            <p><b>ID:</b> {{ user.id }}</p>
            <p><b>Имя:</b> {{ user.name }}</p>
            <p><b>Email:</b> {{ user.email }}</p>
            <p><b>Роль:</b> {{ user.role }}</p>
            <p><b>Создан:</b> {{ user.created_at }}</p>
        </div>

        <div class="actions">
            <Link :href="`/users/${user.id}/edit/`">Редактировать</Link>
            <Link v-if="isAdmin" href="/users/">Назад</Link>
            <Link v-else :href="`/dashboard/`">Назад</Link>

        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from "../../layouts/BaseLayout.vue";
import {Head, Link, usePage} from '@inertiajs/vue3'
import {ref} from "vue";

const props = defineProps({
    user: Object,
})

const page = usePage();
const authUser = page.props.auth?.user;

const isAdmin = ref(authUser.role === 'admin')
</script>

<style scoped>
    .actions {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 2rem;
        font-size: 1.2rem;
    }
</style>
