<template>
    <q-toolbar slot="header" color="tertiary">
        <q-toolbar-title>
            <router-link to="/">
                <q-icon class="ion-chatboxes" color="warning"/>
                <span class="text-light">
                    {{ t['header_title'] }}
                </span>
            </router-link>
            <span slot="subtitle">
                <router-link to="/">
                    <span class="text-warning">{{ t['header_subtitle'] }}</span>
                </router-link>
            </span>
        </q-toolbar-title>
        <router-link to="/about">
            <q-btn flat color="light">
                <q-icon name="ion-information-circled" /> <span slot="subtitle">  {{ t['about'] }}</span>
            </q-btn>
        </router-link>
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
