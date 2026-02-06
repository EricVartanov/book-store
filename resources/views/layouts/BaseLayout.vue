<template>
    <div class="app">
        <header class="header">
            <nav class="header-nav">
                <Link class="header-nav-link" href="/">Домой</Link>
                <Link
                    v-if="!user"
                    class="header-nav-link"
                    href="/login"
                >
                    Войти
                </Link>
                <!-- ЗАЛОГИНЕН -->
                <template v-else>
                    <Link
                        class="header-nav-link"
                        href="/dashboard"
                    >
                        Мои книги
                    </Link>

                    <Link
                        v-if="isAdmin"
                        class="header-nav-link"
                        href="/users"
                    >
                        Пользователи
                    </Link>
                    <Link
                        class="header-nav-link"
                        :href="`/users/${user.id}/`"
                    >
                        Моя карточка
                    </Link>

                    <Link
                        class="header-nav-link"
                        href="/logout"
                        method="post"
                    >
                        Выйти
                    </Link>
                </template>
            </nav>
        </header>
        <main class="main">
            <slot/>
        </main>
        <footer>

        </footer>
    </div>
</template>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = page.props.auth?.user;

const isAdmin = computed(() => user?.role === 'admin');
</script>


<style>
* {
    box-sizing: border-box;
}

body {
    background-color: rgb(228, 226, 223);
    margin: 0 !important;
}

h1, h2, h3, h4, h5, h6 {
    margin: 0;
}

.header {
    padding: 1rem;
    border-bottom: 1px solid black;
    max-width: 1200px;

    .header-nav {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        font-family: sans-serif;
        font-size: 1.2rem;
        padding: 0 3rem;

        .header-nav-link {
            text-decoration: none;
            color: var(--s-green);

            &:hover {
                transition: 0.3s;
                color: var(--s-black);
            }
        }

        .s-button.header-nav-link {
            color: white;
        }
    }
}

.main {
    margin-top: 2rem;
    padding: 20px;
}

</style>
