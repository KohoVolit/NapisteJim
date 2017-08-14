<template>
    <q-toolbar slot="footer" color="tertiary">
        <a href='https://volebnikalkulacka.cz'><span class="text-light">{{ t['footer_motto'] }}</span></a>
        <q-toolbar-title>

        </q-toolbar-title>
            <q-btn flat color="light">

            </q-btn>
    </q-toolbar>
</template>

<script>
import { QToolbar, QToolbarTitle, QIcon, QBtn } from 'quasar'

export default {
    props: ['t'],
    components: {
        QToolbar,
        QToolbarTitle,
        QIcon,
        QBtn
    }
}
</script>

<style>
</style>
