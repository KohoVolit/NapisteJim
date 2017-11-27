<template>
    <div>
        <div>
            <div>
                <!-- <q-collapsible>
                    <span v-for="(item, index) in originals">
                        <q-checkbox @change="setValues" v-model="selected" :val="item" :label="item" />
                    </span>
                </q-collapsible> -->
                <q-select
                    toggle
                    multiple
                    inverted
                    v-model="selected"
                    :options="originalOptions"
                    @change="setValues"
                />
            </div>
            <div>
                <q-btn @click="setAll" color="positive" big>{{ t['select_all'] }}</q-btn>
                <q-btn @click="desetAll" color="warning" big>{{ t['deselect_all'] }}</q-btn>
            </div>
        </div>
    </div>
</template>

<script>
    import { QBtn, QCheckbox, QSelect } from 'quasar'

    export default {
        props: ['items', 't'],
        data: function () {
            // console.log('select data:')
            // console.log(this.items)
            return {
                selected: this.items
            }
        },
        computed: {
            originals: function () {
               return this.items
           },
            originalOptions: function () {
                var out = []
                for (var i = 0; i < this.items.length; i++) {
                    out.push({label: this.items[i], value: this.items[i]})
                }
                return out
            }
        },
        methods: {
            setValues: function () {
                // console.log(this.selected)
                this.$emit('setUp', this.selected)
            },
            setAll: function () {
                this.selected = this.originals
                this.setValues()
            },
            desetAll: function () {
                this.selected = []
                this.setValues()
            }
        },
        components: {
            QBtn,
            QCheckbox,
            QSelect
        }
    }
</script>

<style></style>
