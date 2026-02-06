<template>
    <BaseLayout>
        <div class="container">
            <div class="menu">
                <h2>
                    Мои книги
                </h2>
                <div class="buttons">
                    <SButton color="green" @click="openCreate">
                        Добавить
                    </SButton>
                </div>
                <div class="statistic">
                    <span>
                    Всего книг: <span class="value"> {{ booksCount }} </span>
                    </span>
                </div>
            </div>
            <div class="catalog">
                <BookCard
                    v-for="book in books"
                    :key="book.id"
                    :book="book"
                    @edit="openEdit"
                    @delete="deleteBook"
                />
            </div>
        </div>
        <SDialog
            v-model="isModalOpen"
            :title="editingBook ? 'Редактировать книгу' : 'Добавить книгу'"
            width="500px"
        >
            <BookForm
                v-if="isModalOpen"
                :key="editingBook?.id ?? 'create'"
                :book="editingBook"
                :genres="genres"
                @close="closeModal"
            />
        </SDialog>
    </BaseLayout>
</template>

<script setup>
import {ref} from "vue";
import {SAlert, SButton, SDialog} from "startup-ui";
import BookCard from "../Page/BookCard.vue";
import BaseLayout from "../../layouts/BaseLayout.vue";
import BookForm from "../Page/BookForm.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    books: Array,
    booksCount: Number,
    averageRating: Number,
    genres: Array
})

const isModalOpen = ref(false)
const editingBook = ref(null)

const openCreate = () => {
    editingBook.value = null
    isModalOpen.value = true
}

const openEdit = (book) => {
    editingBook.value = book
    isModalOpen.value = true
}

const closeModal = () => {
    isModalOpen.value = false
    editingBook.value = null
}

const deleteBook = (bookId) => {
    router.delete(`/books/${bookId}`, {
        preserveScroll: true,
        onSuccess: () => {
            SAlert.success('Книга удалена')
        },
        onError: () => {
            SAlert.error('Не удалось удалить книгу')
        },
    })
}
</script>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;

    .menu {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;

        .buttons {
            display: flex;
            gap: 20px;
        }

        .statistic {
            border-left: 1px solid #282C34;
            padding-left: 10px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            font-size: 14px;
            color: #282C34;
            font-family: sans-serif;

            .value {
                font-weight: bold;
                color: var(--s-green);
            }
        }
    }
}

.catalog {
    margin-top: 20px;
    border-top: 1px solid rgb(228, 226, 223);
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    gap: 20px;
}

/* overlay */
.s-dialog-background {
    opacity: 0;
    animation: fadeIn 0.25s forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* dialog card */
.s-dialog-window {
    transform: translateY(20px);
    opacity: 0;
    animation: slideUp 0.3s forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>
