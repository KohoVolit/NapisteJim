<template>
    <q-layout ref="layout" view="hHr lpr fFf">
        <q-toolbar slot="header" color="tertiary">
            <component-header v-bind:t="t"></component-header>
        </q-toolbar>
        <img src="/statics/logo_cz.png" alt="None" />
        <div v-html="a">
        </div>
        <q-toolbar slot="footer" color="tertiary">
            <component-footer v-bind:t="t"></component-footer>
        </q-toolbar>
    </q-layout>
</template>

<script>
import textFile from '../texts.json'
import aboutFile from '../statics/about.html'
var Header = require('./Header.vue')
import Footer from './Footer.vue'
import { QLayout, QToolbar } from 'quasar'

export default {
    data: function () {
        return {
            t: textFile,
            a: aboutFile
        }
    },
    components: {
        'component-header': Header,
        'component-footer': Footer,
        QLayout,
        QToolbar
    },
    head: {
        title: function () {
            return {
                inner: this.t['about']
            }
        },
        meta: function () {
            return [
                {name: 'description', content: this.t['meta_description']},
                {name: 'og:image', content: this.t['meta_og_image']}
            ]
        }
    },
    mounted: function () {
        // console.log(this.$route)
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
