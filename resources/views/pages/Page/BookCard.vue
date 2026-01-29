<template>
  <div class="card">
    <div
        class="cover"
        :style="{ backgroundImage: `url(./assets/img/webp/${book.cover}.webp)` }"
    >
      <img class="adult" v-show="book.adult" src="/assets/img/png/adult18.png" alt="adult"/>
      <div class="rating-wrapper">
        <SActionIcon
            class="rating-star"
            icon="star"
        />
        <span class="rating"> {{ currentRating }} </span>
      </div>
    </div>
    <div class="content">
      <h3 class="title">
        {{ book.title }}
      </h3>
      <div class="genre-list">
        <STag v-for="genre in genreLabels" :key="genre" class="genre" color="gray">{{ genre }}</STag>
      </div>
      <p class="description">
        {{ book.description }}
      </p>
      <div :class="['stars', { disabled: rated }]">
        <SActionIcon
            icon="star"
            v-for="i in 5"
            :key="i"
            :class="['star', { active: i <= (userRating || hoverRating) }, {disabled: rated}]"
            :icon="['fas', 'star']"
            @mouseenter="!userRating && (hoverRating = i)"
            @mouseleave="!userRating && (hoverRating = 0)"
            @click="setRating(i)"
        />
      </div>
      <div class="actions">
        <SActionIcon class="edit-btn" icon="pen-to-square" title="Редактировать" @click="emit('edit', book.id)"/>
        <SActionIcon class="del-btn" icon="trash" title="Удалить" @click="deleteBook(book.id)"/>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, ref} from "vue";
import {SActionIcon, SAlert, SConfirm, STag} from "startup-ui";

const emit = defineEmits(['edit', 'delete'])

const props = defineProps({
  book: Object,
  genreList: Array,
})

const genreLabels = computed(() => {
  const map = {}
  for (const genre of props.genreList) {
    map[genre.value] = genre.label
  }

  return props.book.genre.map(v => map[v])
})

const currentRating = computed(() => props.book.rating ?? 0)
const userRating = ref(0)
const hoverRating = ref(0)

const rated = computed(() => userRating.value >= 1)
const setRating = (value) => {
  if (rated.value) return
  userRating.value = value
}

function deleteBook(bookId) {
  SConfirm.open('Вы действительно хотите удалить пользователя?', {
    title: 'Подтверждение удаления',
    onAccept: () => {
      emit('delete', bookId)
      SAlert.success('Пользователь удален')
    }
  });
}


</script>

<style>
.card {
  width: 250px;
  min-height: 330px;
  padding: 16px;
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
  cursor: pointer;

  .cover {
    width: 100%;
    height: 250px;
    border-radius: 12px;
    background-size: cover;
    background-position: top center;
    margin-bottom: 12px;
    background-repeat: no-repeat;
    position: relative;

    .adult {
      width: 30px;
      height: 30px;
      position: absolute;
      top: -10px;
      right: -10px;
    }

    .rating-wrapper {
      position: absolute;
      top: -15px;
      left: -18px;
    }

    .rating-star {
      font-size: 28px;
      width: 37px;
      color: var(--s-yellow-primary);
    }

    .rating {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      font-family: sans-serif;
      font-size: 11px;
      font-weight: bold;
      color: var(--s-white);
    }
  }

  &:hover {
    transition: all 0.3s;
    box-shadow: 0 3px 30px rgba(118, 234, 155, 0.34);
  }

  .content {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: flex-start;
    position: relative;

    .title {
      font-family: sans-serif;
      font-size: 18px;
      color: var(--s-black);
      margin: 0;
    }

    .description {
      margin: 0;
      margin-top: 10px;
      font-size: 14px;
      color: var(--s-black);
      font-family: sans-serif;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .genre-list {
      margin-top: 10px;
      display: flex;
      gap: 4px;
    }

    .stars {
      display: flex;
      gap: 6px;
      margin-top: 10px;

      .star {
        margin: 0;
        font-size: 18px;
        color: var(--s-gray);
        width: 20px;
        cursor: pointer;
        transition: color 0.2s ease;

        &.active {
          color: var(--s-yellow-primary);
        }

        &.disabled {
          cursor: not-allowed;
        }
      }

      &.disabled {
        cursor: not-allowed;
      }
    }

    .actions {
      position: absolute;
      bottom: 0;
      right: 0;
      display: flex;
      gap: 3px;
      justify-content: center;
      border-left: 1px solid rgba(78, 78, 78, 0.51);
      padding-left: 3px;

      .edit-btn {
        color: var(--s-green-lightest);
        width: 20px;

        &:hover {
          transition: color 0.2s ease;
          color: var(--s-green);
        }
      }

      .del-btn {
        width: 20px;
        margin: 0;
        color: var(--s-red-light);

        &:hover {
          transition: color 0.2s ease;
          color: var(--s-red);
        }
      }
    }
  }
}
</style>