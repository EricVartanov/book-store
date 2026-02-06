<template>
    <BaseLayout>
        <Head title="Пользователи"/>

        <div class="navigation-bar">
            <h1>Пользователи</h1>
            <!--            //в тз не было, не делаю, устал( -->
            <!--            <Link class="header-nav-link" href="/users/create/">Создать пользователя</Link>-->
        </div>

        <STable :data="users.data">
            <template #headers>
                <td class="name">Пользователь</td>
                <td class="center">Email</td>
                <td class="center">Регистрация</td>
                <td class="right"></td>
            </template>
            <template #row="{ row }">
                <td>
                    <Link :href="`/users/${row.id}/`">{{ row.name }}</Link>
                </td>
                <td class="center">{{ row.email }}</td>
                <td class="center">{{ $filters.toLocalTime(row.created_at).split(' ')[0] }}</td>
                <td class="right">
                    <a @click="deleteUser(row)" title="Удалить" class="g-actionicon">
                        <FontAwesomeIcon icon="trash"/>
                    </a>
                    <Link :href="`/users/${row.id}/edit/`" class="g-actionicon">
                        <FontAwesomeIcon icon="pen-to-square"/>
                    </Link>
                </td>
            </template>
        </STable>
        <SPagination :links="users.links" :total="users.total"/>
    </BaseLayout>
</template>

<script setup>
import {inject} from 'vue';
import {router} from '@inertiajs/vue3';
import {STable, SPagination, SConfirm} from "startup-ui";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

import BaseLayout from "../../layouts/BaseLayout.vue";

const props = defineProps({
    users: Object,
    userRoles: Object,
    initialFilter: {
        type: Object,
        default() {
            return {};
        },
    },
});

const $filters = inject('$filters');

function deleteUser(user) {
    SConfirm.open(
        `Вы действительно хотите удалить пользователя «${user.name}»?`, {
            title: 'Подтверждение удаления',
            onAccept: () => router.delete(`/users/${user.id}`)
        }
    )
}
</script>

<style scoped>
.navigation-bar {
    padding: 1rem 0;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    gap: 1rem;
    align-items: center;

    .header-nav-link {
        text-decoration: none;
        color: #1950B3;
        font-family: sans-serif;
        font-size: 1.2rem;

        &:hover {
            transition: 0.3s;
            color: var(--s-black);
        }
    }
}
</style>
