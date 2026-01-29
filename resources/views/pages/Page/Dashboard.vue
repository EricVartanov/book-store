<template>
    <BaseLayout>
        <div class="container">
            <h1>Dashboard</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisi tortor, maximus aliquet ante
                ut, finibus tempor metus. Etiam dignissim ac ipsum sit amet interdum. Sed sit amet dolor id ligula
                elementum laoreet id eget erat. Proin viverra gravida odio, quis malesuada magna cursus nec. Nulla vel
                consequat nulla. Pellentesque fringilla interdum maximus. Praesent efficitur, neque non sodales
                consequat, neque velit rhoncus ex, non ultrices lectus dolor id tortor. Nunc egestas ipsum ipsum,
                laoreet fermentum enim congue non. Suspendisse fermentum erat ut purus efficitur porta.

                Donec sollicitudin urna in augue pellentesque ultrices. Vivamus tellus nunc, posuere nec lectus non,
                ultricies dignissim ante. Ut congue faucibus finibus. In sit amet risus dictum eros suscipit maximus.
                Vestibulum mattis sem vitae aliquam facilisis. Ut convallis ornare aliquet. Duis vulputate, mi at
                sodales sodales, nisl enim commodo purus, in pulvinar odio elit vitae eros. Maecenas a ex mollis,
                efficitur velit sagittis, porttitor felis. Duis vel metus vestibulum, blandit ipsum id, viverra sapien.
                Fusce consectetur, turpis eget vestibulum pellentesque, sem nisl placerat felis, at interdum magna nibh
                eget sem. In ultricies aliquet velit eu venenatis.

                Vestibulum laoreet nibh ut semper cursus. Vestibulum ante ipsum primis in faucibus orci luctus et
                ultrices posuere cubilia curae; Pellentesque habitant morbi tristique senectus et netus et malesuada
                fames ac turpis egestas. Nam suscipit malesuada venenatis. Vivamus mi mi, egestas eu leo quis, volutpat
                cursus purus. Morbi sollicitudin tristique elit eleifend pellentesque. Interdum et malesuada fames ac
                ante ipsum primis in faucibus. Aliquam sodales volutpat nisi in tempus. Donec maximus pretium facilisis.
                Vestibulum congue erat diam, quis rutrum augue lobortis id. In accumsan eleifend maximus. Aenean ut
                tincidunt metus. In lacus libero, rhoncus vel tempus in, ullamcorper at magna. Suspendisse vitae
                convallis augue.

                Mauris in metus eu nisi blandit lacinia porta et risus. Nam mollis enim odio, a elementum eros porttitor
                maximus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed vel
                tristique sem, ac bibendum eros. Ut porttitor tempus sapien ut finibus. Nulla eleifend consectetur mi at
                vehicula. In ipsum felis, bibendum a mi ut, viverra commodo mi. Nam ut sapien pharetra, pellentesque
                sapien et, accumsan urna. Nam consequat tellus eget metus pellentesque, eu auctor felis ullamcorper. In
                et tempor tortor.

                Duis eu facilisis dui, ac scelerisque tortor. Maecenas gravida ligula a nunc tempor euismod. Quisque
                eget tellus nec ante vehicula congue. Nunc euismod auctor massa, at dapibus ex vehicula quis. Aenean sed
                tincidunt diam, in mattis turpis. Vestibulum felis augue, convallis in fermentum at, pretium ac ex.
                Nulla nec odio eget lorem scelerisque ultrices sit amet non velit. Suspendisse quis erat vulputate,
                cursus dolor in, egestas ex. Maecenas vitae nisl mi. Maecenas porta commodo risus eu vulputate. Vivamus
                elementum porta fermentum. Curabitur iaculis, sapien eget ultricies aliquet, nulla arcu hendrerit
                sapien, eget aliquam nisi erat ultrices ligula. Phasellus laoreet lacus libero, quis auctor neque
                scelerisque ut. Nulla nisi purus, dapibus nec tellus finibus, condimentum elementum massa.
            </p>

            <SButton color="green" @click="handleUpdate">
                Обновить данные
            </SButton>
        </div>
    </BaseLayout>
</template>

<script setup>
import {SButton} from "startup-ui";
import BaseLayout from "../../layouts/BaseLayout.vue";
import {router} from "@inertiajs/vue3";

const handleUpdate = () => {
    router.visit('/dashboard', {
        method: 'get',
        preserveScroll: true,
        preserveState: true,
    })
}
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}
</style>
