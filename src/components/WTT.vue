<template>
    <q-layout ref="layout" view="hHr lpr fFf">

        <q-toolbar slot="header" color="tertiary">
            <component-header v-bind:t="t" v-bind:settings="settings"></component-header>
        </q-toolbar>
        <component-selects v-bind:people="people" v-bind:t="t" v-bind:settings="settings" class="generic-margin"></component-selects>
        <component-darujme></component-darujme>
        <q-toolbar slot="footer" color="tertiary">
            <component-footer v-bind:t="t"></component-footer>
        </q-toolbar>
        <component-analytics></component-analytics>
    </q-layout>
</template>

<script>
import axios from 'axios' // external data
import textFile from '../texts.json'
import settingsFile from '../settings.json'
import Selects from './Selects.vue'
import Header from './Header.vue'
import Footer from './Footer.vue'
import Analytics from './Analytics.vue'
import Darujme from './Darujme.vue'
import { QLayout, QToolbar, QToolbarTitle, QIcon } from 'quasar'

export default {
    data: function () {
        return {
            people: [],
            t: textFile,
            settings: settingsFile
        }
    },
    methods: {
        // external data:
        getData () {
            axios.get(this.settings['api_path'] + 'data.json').then(
                response => {
                    this.people = response.data
            })
        }
    },
    // external data
    mounted () {
        this.getData()
    },
    head: {
        meta: function () {
            return [
                {name: 'description', content: this.t['meta_description']},
                {name: 'og:image', content: this.t['meta_og_image']}
            ]
        }
    },
    components: {
        'component-header': Header,
        'component-footer': Footer,
        'component-selects': Selects,
        'component-darujme': Darujme,
        'component-analytics': Analytics,
        QLayout,
        QToolbar,
        QToolbarTitle,
        QIcon
    }
}
</script>

<style>
    @media (min-width: 975px) {
        body {
            max-width: 80%;
            margin: auto;
        }
    }
</style>
