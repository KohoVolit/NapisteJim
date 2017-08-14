<template>
    <div>
        <h3>{{ t['selected_mps'] }} <q-icon class="ion-android-contacts" /> : {{ number }}</h3>


        <h4><q-icon class="ion-email" /> {{ t['write_email'] }}</h4>
        <form :action="mailto">
            <q-btn type="submit" class="full-width" color="positive" big icon="ion-email" :disabled="disabled">  {{ t['write_to_them'] }}</q-btn>
        </form>

        <h4><q-icon class="ion-at" /> {{ t['emails'] }} <small>{{ t['to_copy'] }}</small></h4>
        <q-tabs>
            <q-tab slot="title" name="tab-1" icon="ion-at" :label="t['to_email']" />
            <q-tab slot="title" default name="tab-2" icon="ion-document-text" :label="t['as_table']" />

            <q-tab-pane name="tab-1">
                <p class="selectable bg-light">
                    {{ selected_emails }}
                </p>
            </q-tab-pane>
            <q-tab-pane name="tab-2">
                <table class="selectable bg-light">
                    <tbody>
                        <tr v-for="item in items">
                            <td><img class="item-avatar" :src="imageSrc(item.id)" :alt="item['name']" /></td>
                            <td>{{ item['name'] }}</td>
                            <td>{{ item['email'] }}</td>
                            <td>{{ item['region'] }}</td>
                            <td>{{ item['group'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </q-tab-pane>
        </q-tabs>
    </div>
</template>
<script>
    import { QIcon, QBtn, QTabs, QTab, QTabPane } from 'quasar'
    export default {
        props: ['items', 'settings', 't'],
        computed: {
            number: function () {
                return this.items.length
            },
            selected_emails: function () {
                var out = ''
                for (var i = 0; i < this.items.length; i++) {
                    out += "'" + this.items[i].name + "' <" + this.items[i].email + '>'
                    if (i < (this.items.length - 1)) {
                        out += ',\n'
                    }
                }
                return out
            },
            mailto: function () {
                return 'mailto:' + this.selected_emails
            },
            disabled: function () {
                if (this.number > 0) {
                    return false
                }
                else {
                    return true
                }
            }
        },
        methods: {
            imageSrc: function (id) {
                return this.settings['psp_image'] + id + '.jpg'
            }
        },
        components: {
            QIcon,
            QBtn,
            QTabs,
            QTab,
            QTabPane
        }
    }
</script>
<style scoped>
    .selectable {
        -webkit-touch-callout: all; /* iOS Safari */
        -webkit-user-select: all; /* Safari */
        -khtml-user-select: all; /* Konqueror HTML */
        -moz-user-select: all; /* Firefox */
        -ms-user-select: all; /* Internet Explorer/Edge */
        user-select: all; /* Chrome and Opera */
    }
    .item-avatar {
        width: 38px;
        height: 47px;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        text-align:center;
    }
</style>
