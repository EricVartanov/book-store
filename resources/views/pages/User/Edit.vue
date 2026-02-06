<template>
    <BaseLayout>
        <Head title="Редактирование пользователя"/>



        <SForm v-model="form" method="post" @submit="submit">
            <SFormRow title="Логин" name="email">
                <SInput v-model="user.email" type="email" />
            </SFormRow>
            <SFormRow title="Имя" name="name">
                <SInput v-model="user.name" type="text" />
            </SFormRow>
            <SFormRow v-if="isAdmin" title="Роль" name="role">
            <SSelect v-model="form.role" :options="roles" placeholder="Выберите роль" />
            </SFormRow>
            <SButton>Сохранить</SButton>
            <Link v-if="isAdmin" class="link-btn" :href="`/users/`">Назад</Link>
            <Link v-else class="link-btn" :href="`/users/${user.id}/`">Назад</Link>
        </SForm>

    </BaseLayout>
</template>

<script setup>
import BaseLayout from "../../layouts/BaseLayout.vue";
import {Head, useForm, usePage} from '@inertiajs/vue3'
import {SButton, SForm, SFormRow, SInput, SSelect} from "startup-ui";
import {ref} from "vue";

const props = defineProps({
    user: Object,
    roles: Array
})

const form = useForm({
    email: props.user.email,
    name: props.user.name,
    role: props.user.role ?? null,
});

function submit() {
    form.put(`/users/${props.user.id}`);
}

const page = usePage();
const authUser = page.props.auth?.user;

const isAdmin = ref(authUser.role === 'admin')
</script>

<style scoped>

.link-btn {
   text-align: center;
}
</style>
