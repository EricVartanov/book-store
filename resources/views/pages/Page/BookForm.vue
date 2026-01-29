<template>
  <SForm class="form" v-model="form" @submit="submit" method="post" action="/users/login">
    <SFormRow name="title">
      <SInput placeholder="Название" ref="name-input" autofocus/>
    </SFormRow>
    <SFormRow name="description">
      <SInput type="textarea" placeholder="Описание"/>
    </SFormRow>
    <multiselect
        v-model="selectedGenres"
        :options="genresList"
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
    <SFormRow name="cover">
      <SUpload v-model="form.cover" upload-button-title="Выбрать обложку"/>
    </SFormRow>
    <SFormRow name="adult">
      <SCheckbox v-model="form.adult">18+</SCheckbox>
    </SFormRow>
    <div class="actions">
      <SButton class="submit-btn" color="green">Сохранить</SButton>
      <SButton class="cancel-btn" color="red" @click="$emit('cancel')">Отмена</SButton>
    </div>
  </SForm>
</template>

<script setup>
import {computed, nextTick, onMounted, reactive, useTemplateRef, watch} from 'vue'
import Multiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.css'
import {debounce} from "lodash/function";
import {SButton, SCheckbox, SForm, SFormRow, SInput, SUpload} from "startup-ui";

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },
  genresList: {
    type: Array,
    required: true
  },
})

const emit = defineEmits([
  'update:modelValue',
  'submit',
  'cancel'
])
const form = reactive({...props.modelValue})

watch(
    () => props.modelValue,
    (value) => {
      Object.assign(form, value)
    },
    {deep: true}
)

const nameInput = useTemplateRef('name-input')

const focusNameInput = async () => {
  await nextTick()
  nameInput.value?.$el?.querySelector('input')?.focus()
}

onMounted(() => {
  focusNameInput()
})

const selectedGenres = computed({
  get() {
    return props.genresList.filter(g =>
        form.genre.includes(g.value)
    )
  },
  set(values) {
    form.genre = values.map(v => v.value)
  }
})


//знаю костыльно, но не понимаю как решить вопрос с вочерами на форму,
let firstInit = true
//задание 5 дня
watch(
    () => form.title,
    (newValue) => {
      if (firstInit) {
        firstInit = false
        return
      }
      sendTitleToServer(newValue)
    },
)

const sendTitleToServer = debounce((value) => {
  console.log(`Отправили ${value} на сервер`)
}, 500)


const submit = () => {
  emit('update:modelValue', {...form})
  emit('submit', {...form})
}
</script>

<style>
.form {
  .actions {
    display: flex;
    margin-top: 20px;
    justify-content: space-between;

    button {
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
