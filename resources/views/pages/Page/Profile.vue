<template>
    <BaseLayout>
        <div class="container">
            <h1>Profile</h1>
            <SForm v-model="form" action="/contact" method="post">
                <SFormRow title="Имя" name="name">
                    <SInput/>
                </SFormRow>
                <SFormRow title="Email" name="email">
                    <SInput type="email"/>
                </SFormRow>
                <SFormRow>
                    <SButton>Отправить</SButton>
                </SFormRow>
            </SForm>
        </div>
    </BaseLayout>
</template>

<script setup>
import BaseLayout from "../../layouts/BaseLayout.vue";
import {SForm, SFormRow, SButton, SInput} from "startup-ui";
import {useForm} from '@inertiajs/vue3'


const form = useForm({
    name: '',
    email: '',
})

//можно было еше так сделать повесив сабмит на форму, но я предпочел, как в проекте example
// const submit = () => {
//     form.post( {
//         preserveScroll: true,
//         onSuccess: () => form.reset(),
//     })
// }

</script>

<style scoped>
.container {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}
</style>
