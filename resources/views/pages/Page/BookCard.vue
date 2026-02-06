<template>
    <div class="card">
        <div
            class="cover"
            :style="{ backgroundImage: `url(${coverUrl})` }"
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
            <div v-if="user && !rated" :class="['stars', { disabled: rated }]">
                <SActionIcon
                    v-for="i in 5"
                    :key="i"
                    icon="star"
                    :class="['star', { active: i <= (hoverRating || 0) }, { disabled: rated }]"
                    @mouseenter="!rated && (hoverRating = i)"
                    @mouseleave="!rated && (hoverRating = 0)"
                    @click="setRating(i)"
                />
            </div>
            <div v-if="isUsersBookOrAdmin" class="actions">
                <SActionIcon class="edit-btn" icon="pen-to-square" title="Редактировать"
                             @click="emit('edit', book)"/>
                <SActionIcon class="del-btn" icon="trash" title="Удалить" @click="deleteBook(book.id)"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, ref} from "vue";
import {SActionIcon, SConfirm, STag} from "startup-ui";
import {router, usePage} from "@inertiajs/vue3";

const page = usePage();


const emit = defineEmits(['edit', 'delete'])

const props = defineProps({
    book: {
        type: Object,
        required: true
    }
})

const user = page.props.auth?.user;
const isUsersBookOrAdmin = computed(() => {
    if (!user) return false

    return user.id === props.book.author_id || user.role === 'admin'
})
const genreLabels = computed(() => {
    return props.book.genres.map(genre => genre.name)
})

const currentRating = computed(() =>
    props.book.ratings_avg_rating ?? 0
)
const hoverRating = ref(0)

const rated = computed(() => props.book.user_rated)
const setRating = (value) => {
    if (rated.value) return

    router.post(`books/${props.book.id}/rating`,
        {rating: value},
        {preserveScroll: true}
    )
}

function deleteBook(bookId) {
    SConfirm.open('Вы действительно хотите удалить книгу?', {
        title: 'Подтверждение удаления',
        onAccept: () => {
            emit('delete', bookId)
        }
    })
}

const coverUrl = computed(() => {
    if (!props.book.cover) {
        return '/assets/img/svg/no-image.svg'
    }

    // если дали url при создании
    if (props.book.cover.startsWith('http')) {
        return props.book.cover
    }

    // storage
    return `/storage/${props.book.cover}`
})
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
