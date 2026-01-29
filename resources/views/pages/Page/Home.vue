<template>
  <BaseLayout>
      <div class="container">
          <div class="menu">
              <div class="buttons">
                  <SButton color="green" class="button_blue" @click="openAdd">
                      Добавить
                  </SButton>
                  <SButton color="green" outlined class="button_blue" @click="resetAllRatings">
                      Сбросить весь рейтинг
                  </SButton>
              </div>
              <div class="statistic">
          <span>
            Всего книг: <span class="value"> {{ books.length }} </span>
          </span>
                  <span>
            Средний рейтинг: <span class="value"> {{ averageRating }} </span>
          </span>
              </div>
          </div>
          <div class="catalog">
              <BookCard
                  v-for="(book) in books"
                  :key="book.id"
                  :book
                  :genreList="genresList"
                  @edit="handleEditBook"
                  @delete="handleDeleteBook"
              />
          </div>
      </div>
      <SDialog
          v-model="isModalOpen"
          :title="isAddOpen ? 'Добавить книгу' : 'Редактировать книгу'"
          width="500px"
      >
          <BookForm
              v-model="formBook"
              v-if="isModalOpen"
              :genresList="genresList"
              @submit="handleSubmit"
              @cancel="closeModal"
          />
      </SDialog>
  </BaseLayout>
</template>

<script setup>
import data from './books.json'
import {computed, ref, watch} from "vue";
import {SButton, SDialog} from "startup-ui";
import BookCard from "./BookCard.vue";
import BookForm from "./BookForm.vue";
import BaseLayout from "../../layouts/BaseLayout.vue";

const genresList = [
  {value: 'fantasy', label: 'Фэнтези'},
  {value: 'drama', label: 'Драма'},
  {value: 'romance', label: 'Роман'},
  {value: 'horror', label: 'Хоррор'},
  {value: 'thriller', label: 'Триллер'},
  {value: 'postapocalypse', label: 'Постапокалипсис'},
  {value: 'mystic', label: 'Мистика'},
]

const isAddOpen = ref(false)
const isEditOpen = ref(false)
const books = ref(data);

const resetAllRatings = () => {
  books.value = books.value.map(book => ({
    ...book,
    rating: 0
  }))
}


const averageRating = computed(
    function () {
      return (books.value.reduce((acc, book) => acc + book.rating, 0) / books.value.length).toFixed(2);
    }
)

const isModalOpen = computed({
  get() {
    return isAddOpen.value || isEditOpen.value
  },
  set(value) {
    if (!value) {
      closeModal()
    }
  }
})

// для моб версии может ломать. Проверить.
watch(isModalOpen, (isOpen) => {
  if (isOpen) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})

const modalType = computed(() =>
    isAddOpen.value ? 'add' : 'edit'
)

const formBook = ref(getEmptyBook())

function getEmptyBook() {
  return {
    title: '',
    description: '',
    genre: [],
    cover: '',
    adult: false
  }
}

const openAdd = () => {
  formBook.value = getEmptyBook()
  isAddOpen.value = true
}

const handleEditBook = (id) => {
  const book = books.value.find(book => book.id === id)
  formBook.value = {...book}
  isEditOpen.value = true
}

const closeModal = () => {
  isAddOpen.value = false
  isEditOpen.value = false
}

const handleSubmit = (data) => { //todo переделать после бэка
  if (modalType.value === 'add') {
    books.value.push({
      ...data,
      id: Date.now(), // на время
      rating: 0
    })
  } else {
    books.value = books.value.map((book) => {
      if (book.id === data.id) {
        data.rating = book.rating;
        return data;
      }
      return book;
    });
  }

  closeModal()
}

const handleDeleteBook = (id) => {
  books.value = books.value.filter(book => book.id !== id)
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
