<template>
    <SForm v-model="form" class="form" @submit="submit">
        <SFormRow>
            <SInput v-model="form.title" placeholder="Название" />
        </SFormRow>

        <SFormRow>
            <SInput
                v-model="form.description"
                type="textarea"
                placeholder="Описание"
            />
        </SFormRow>

        <SFormRow>
            <SCheckbox v-model="form.adult">18+</SCheckbox>
        </SFormRow>

        <multiselect
            v-model="selectedGenres"
            :options="genres"
            @update:modelValue="form.genres = $event.map(v => v.value)"
            track-by="value"
            label="label"
            :multiple="true"
            :close-on-select="false"
            placeholder="Выберите жанры"
            select-label=""
            deselect-label=""
            selected-label=""
            class="genre-multiselect"
            open-direction="bottom"
        />

        <SUpload v-model="form.cover" />

        <div class="actions">
            <SButton color="green" type="submit" :loading="form.processing">
                Сохранить
            </SButton>

            <SButton color="red" type="button" @click="emit('close')">
                Отмена
            </SButton>
        </div>
    </SForm>
</template>

<script setup>
import {computed, ref, watch} from 'vue'
import { useForm } from '@inertiajs/vue3'
import {SForm, SFormRow, SInput, SCheckbox, SButton, SUpload} from 'startup-ui'
import Multiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css'

const props = defineProps({
    book: {
        type: Object,
        default: null,
    },
    genres: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['close'])

const form = useForm({
    title: '',
    description: '',
    adult: false,
    genres: [],
    cover: null,
})

const selectedGenres = ref([])


watch(
    () => props.book,
    (book) => {
        if (!book) {
            form.reset()
            selectedGenres.value = []
            return
        }

        form.title = book.title ?? ''
        form.description = book.description ?? ''
        form.adult = !!book.adult
        form.cover = book.cover ?? null

        selectedGenres.value = book.genres.map(g => ({
            label: g.name,
            value: g.slug,
        }))

        form.genres = book.genres.map(g => g.slug)
    },
    { immediate: true }
)

const genres = computed(() =>
    props.genres.map(g => ({
        label: g.name,
        value: g.slug,
    }))
)

function submit() {
    form.transform((data) => {
        const payload = { ...data }

        // отправляем cover ТОЛЬКО если это новый файл
        if (!(payload.cover instanceof File)) {
            delete payload.cover
        }

        return payload
    })

    if (props.book) {
        form.patch(`/books/${props.book.id}`, {
            onSuccess: () => emit('close'),
        })
    } else {
        form.post('/books', {
            onSuccess: () => emit('close'),
        })
    }
}
</script>

<style>
.form {
    .actions {
        display: flex;
        margin-top: 20px;
        justify-content: space-between;

        .button {
            &:hover {
                transition: 0.3s;
                opacity: 0.5;
            }
        }
    }
}

</style>

<style scoped>
.genre-multiselect :deep(.multiselect__tag) {
    background: var(--s-green);
    color: var(--s-white);
}

.genre-multiselect :deep(.multiselect__option--highlight) {
    background: var(--s-green);
    color: var(--s-white);
}

.genre-multiselect :deep(.multiselect__option--selected) {
    background: rgba(0, 128, 0, 0.15);
    color: var(--s-black);
}

.genre-multiselect :deep(.multiselect__tag-icon:hover) {
    background: #0f8f3a;
}
</style>
