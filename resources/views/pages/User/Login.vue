<template>
    <BaseLayout>
        <div class="container">
            <h1>Вход</h1>

            <SForm v-model="form" method="post" action="/login">
                <SFormRow title="Логин" name="email">
                    <SInput type="email" />
                </SFormRow>
                <SFormRow title="Пароль" name="password">
                    <SInput type="password" />
                </SFormRow>
                <SButton>Войти</SButton>
            </SForm>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from "../../layouts/BaseLayout.vue";
import {SForm, SFormRow, SButton, SInput} from "startup-ui";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    console.log('111');
    form.post(route('login'));
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}

.error {
    color: red;
    margin-top: 10px;
}
</style>
