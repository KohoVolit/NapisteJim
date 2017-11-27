<template>
    <div>
        <q-chip color="primary" class="big">
            # 1
        </q-chip>
        <div class="margin-left">
            <h3>{{ t['selection'] }}:</h3>
            <q-list class="row">
                <q-item class="col-sm-6 items-start">
                    <q-item-main>
                        <q-item-tile>
                            <h4><q-icon name="ion-earth" /> {{ t['regions'] }}</h4>
                        </q-item-tile>
                        </q-item-tile>
                            <component-select v-bind:items="regs" :t="t" v-on:setUp="(...args)=>this.setAr('regions',...args)" v-on:desetUp="(...args)=>this.desetAr('regions',...args)"></component-select>
                        </q-item-tile>
                    </q-item-main>
                </q-item>
                <q-item-separator />
                <q-item class="col-sm-6 items-start">
                    <q-item-main>
                        <q-item-tile>
                            <h4><q-icon name="ion-flag" /> {{ t['groups'] }}</h4>
                        </q-item-tile>
                        </q-item-tile>
                            <component-select v-bind:items="grps" :t="t" v-on:setUp="(...args)=>this.setAr('groups',...args)" v-on:desetUp="(...args)=>this.desetAr('groups',...args)"></component-select>
                        </q-item-tile>
                    </q-item-main>
                </q-item>
            </q-list>
            <q-collapsible icon="ion-wand" :label="t['detailed_select']" class="bg-light">
                <q-list class="row">
                    <q-item class="col-md-4 items-start">
                        <q-item-main>
                            <q-item-tile>
                                <h5><q-checkbox v-model="includes['committees']" @change="filterPeople"/> {{ t['committees'] }}</h5>
                            </q-item-tile>
                            </q-item-tile>
                                <component-select v-bind:items="commits" :t="t" v-on:setUp="(...args)=>this.setAr('committees',...args)" v-on:desetUp="(...args)=>this.desetAr('committees',...args)" v-on:checkCommitties ></component-select>
                            </q-item-tile>
                        </q-item-main>
                    </q-item>
                    <q-item class="col-md-4 items-start">
                        <q-item-main>
                            <q-item-tile>
                                <h5><q-checkbox v-model="includes['commissions']" @change="filterPeople"/> {{ t['commissions'] }}</h5>
                            </q-item-tile>
                            </q-item-tile>
                                <component-select v-bind:items="commiss" :t="t" v-on:setUp="(...args)=>this.setAr('commissions',...args)" v-on:desetUp="(...args)=>this.desetAr('commissions',...args)"></component-select>
                            </q-item-tile>
                        </q-item-main>
                    </q-item>
                    <q-item class="col-md-4 items-start">
                        <q-item-main>
                            <q-item-tile>
                                <h5><q-checkbox v-model="includes['delegations']" @change="filterPeople"/> {{ t['delegations'] }}</h5>
                            </q-item-tile>
                            </q-item-tile>
                                <component-select v-bind:items="delegs" :t="t" v-on:setUp="(...args)=>this.setAr('delegations',...args)" v-on:desetUp="(...args)=>this.desetAr('delegations',...args)"></component-select>
                            </q-item-tile>
                        </q-item-main>
                    </q-item>
                </q-list>
            </q-collapsible>
        </div>
        <hr>
        <q-chip color="primary" class="big">
            # 2
        </q-chip>
        <div class="margin-left">
            <component-area v-bind:items="filtered_people" v-bind:t="t" v-bind:settings="settings"></component-area>
        </div>
    </div>
</template>

<script>
    import { QList, QItem, QItemSeparator, QItemTile, QItemMain, QIcon, QCheckbox, QCollapsible, QChip } from 'quasar'
    var Select = require('./Select.vue')
    var Area = require('./Area.vue')

    export default {
        props: ['people', 'settings', 't'],
        data: function () {
            return {
                trial: false,
                regions: [],
                groups: [],
                committees: [],
                delegations: [],
                commissions: [],
                filtered_people: [],
                includes: {
                    'delegations': false,
                    'commissions': false,
                    'committees': false
                }
            }
        },
        computed: {
            regs: function () {
                // console.log('computed:')
                // console.log(this.uniques(this.people, 'region'))
                return this.uniques(this.people, 'region')
            },
            grps: function () {
                return this.uniques(this.people, 'group')
            },
            commits: function () {
                return this.uniques(this.people, 'committees')
            },
            delegs: function () {
                return this.uniques(this.people, 'delegations')
            },
            commiss: function () {
                return this.uniques(this.people, 'commissions')
            }
        },
        methods: {
            containsSome: function (arr, vs) {
                // console.log(arr)
                // console.log(vs)
                for (var i = 0; i < arr.length; i++) {
                    for (var j = 0; j < vs.length; j++) {
                        if (arr[i] === vs[j]) return true
                    }
                }
                return false
            },
            contains: function (arr, v) {
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] === v) return true
                }
                return false
            },
            uniques: function (arr, property) {
                var out = []
                for (var i = 0; i < arr.length; i++) {
                    if (Array.isArray(arr[i][property])) {
                        for (var j = 0; j < arr[i][property].length; j++) {
                            if (!this.contains(out, arr[i][property][j])) {
                                out.push(arr[i][property][j])
                            }
                        }
                    }
                    else {
                        if (!this.contains(out, arr[i][property])) {
                            out.push(arr[i][property])
                        }
                    }
                }
                out.sort(Intl.Collator('cs').compare)
                return out
            },
            setAr: function (what, args) {
                this[what] = args
                this[what].sort(Intl.Collator('cs').compare)
                if (this[what].length > 0) {
                    this['includes'][what] = true
                }
                else {
                    this['includes'][what] = false
                }
                this.filterPeople()
            },
            desetAr: function (what, args) {
                this[what] = []
                this.filterPeople()
            },
            filterPeople: function () {
                // console.log('zzz')
                // console.log(this.t)
                // console.log(this.regions)
                // console.log(this.groups)
                this.filtered_people = []
                for (var i = 0; i < this.people.length; i++) {
                    if (
                        this.contains(this.regions, this.people[i]['region']) &&
                        this.contains(this.groups, this.people[i]['group']) &&
                        ((this.includes['delegations'] && this.containsSome(this.delegations, this.people[i]['delegations'])) || (!this.includes['delegations'])) &&
                        ((this.includes['committees'] && this.containsSome(this.committees, this.people[i]['committees'])) || (!this.includes['committees'])) &&
                        ((this.includes['commissions'] && this.containsSome(this.commissions, this.people[i]['commissions'])) || (!this.includes['commissions']))
                    ) {
                        this.filtered_people.push(this.people[i])
                    }
                }
            }
        },
        mounted () {
            this.regions = this.regs
            this.groups = this.grps
            this.committees = this.commits
            this.commissions = this.commiss
            this.delegations = this.delegs
            this.filtered_people = this.people
            // console.log('mounted regs')
            // this.regs = ['Plzeňský']
            // console.log(this.regs)
        },
        components: {
            'component-select': Select,
            'component-area': Area,
            QList,
            QItem,
            QItemSeparator,
            QItemTile,
            QItemMain,
            QIcon,
            QCheckbox,
            QCollapsible,
            QChip
        }
    }
</script>

<style scoped>
    .big {
        font-size: 2em;
    }
    .margin-left {
        margin-left: 2em;
    }
    .q-chip {
        height: 2em;
    }
</style>
