webpackJsonp([2,3,8],{31:function(t,e,s){function i(t){s(49)}var n=s(2)(s(51),s(52),i,"data-v-1159dfbd",null);t.exports=n.exports},32:function(t,e,s){function i(t){s(53)}var n=s(2)(s(55),s(56),i,null,null);t.exports=n.exports},34:function(t,e,s){function i(t){s(62)}var n=s(2)(s(64),s(65),i,"data-v-50f33012",null);t.exports=n.exports},49:function(t,e,s){var i=s(50);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);s(27)("2a0bd05c",i,!0)},50:function(t,e,s){e=t.exports=s(26)(void 0),e.push([t.i,".selectable[data-v-1159dfbd]{-webkit-touch-callout:all;-webkit-user-select:all;-moz-user-select:all;-ms-user-select:all;user-select:all}.item-avatar[data-v-1159dfbd]{width:38px;height:47px;-moz-border-radius:20px;-webkit-border-radius:20px;text-align:center}",""])},51:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(3);e.default={props:["items","settings","t"],computed:{number:function(){return this.items.length},selected_emails:function(){for(var t="",e=0;e<this.items.length;e++)t+="'"+this.items[e].name+"' <"+this.items[e].email+">",e<this.items.length-1&&(t+=",\n");return t},mailto:function(){return"mailto:"+this.selected_emails},disabled:function(){return!(this.number>0)}},methods:{imageSrc:function(t){return this.settings.psp_image+t+".jpg"}},components:{QIcon:i.e,QBtn:i.a,QTabs:i.o,QTab:i.m,QTabPane:i.n}}},52:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h3",[t._v(t._s(t.t.selected_mps)+" "),s("q-icon",{staticClass:"ion-android-contacts"}),t._v(" : "+t._s(t.number))],1),t._v(" "),s("h4",[s("q-icon",{staticClass:"ion-email"}),t._v(" "+t._s(t.t.write_email))],1),t._v(" "),s("form",{attrs:{action:t.mailto}},[s("q-btn",{staticClass:"full-width",attrs:{type:"submit",color:"positive",big:"",icon:"ion-email",disabled:t.disabled}},[t._v("  "+t._s(t.t.write_to_them))])],1),t._v(" "),s("h4",[s("q-icon",{staticClass:"ion-at"}),t._v(" "+t._s(t.t.emails)+" "),s("small",[t._v(t._s(t.t.to_copy))])],1),t._v(" "),s("q-tabs",[s("q-tab",{attrs:{name:"tab-1",icon:"ion-at",label:t.t.to_email},slot:"title"}),t._v(" "),s("q-tab",{attrs:{default:"",name:"tab-2",icon:"ion-document-text",label:t.t.as_table},slot:"title"}),t._v(" "),s("q-tab-pane",{attrs:{name:"tab-1"}},[s("p",{staticClass:"selectable bg-light"},[t._v("\n                "+t._s(t.selected_emails)+"\n            ")])]),t._v(" "),s("q-tab-pane",{attrs:{name:"tab-2"}},[s("table",{staticClass:"selectable bg-light"},[s("tbody",t._l(t.items,function(e){return s("tr",[s("td",[s("img",{staticClass:"item-avatar",attrs:{src:t.imageSrc(e.id),alt:e.name}})]),t._v(" "),s("td",[t._v(t._s(e.name))]),t._v(" "),s("td",[t._v(t._s(e.email))]),t._v(" "),s("td",[t._v(t._s(e.region))]),t._v(" "),s("td",[t._v(t._s(e.group))])])}))])])],1)],1)},staticRenderFns:[]}},53:function(t,e,s){var i=s(54);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);s(27)("6b83fc94",i,!0)},54:function(t,e,s){e=t.exports=s(26)(void 0),e.push([t.i,"",""])},55:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(3);e.default={props:["items","t"],data:function(){return{selected:this.items}},computed:{originals:function(){return this.items},originalOptions:function(){for(var t=[],e=0;e<this.items.length;e++)t.push({label:this.items[e],value:this.items[e]});return t}},methods:{setValues:function(){this.$emit("setUp",this.selected)},setAll:function(){this.selected=this.originals,this.setValues()},desetAll:function(){this.selected=[],this.setValues()}},components:{QBtn:i.a,QCheckbox:i.b,QSelect:i.l}}},56:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("div",[s("div",[s("q-select",{attrs:{toggle:"",multiple:"",inverted:"",options:t.originalOptions},on:{change:t.setValues},model:{value:t.selected,callback:function(e){t.selected=e},expression:"selected"}})],1),t._v(" "),s("div",[s("q-btn",{attrs:{color:"positive",big:""},on:{click:t.setAll}},[t._v(t._s(t.t.select_all))]),t._v(" "),s("q-btn",{attrs:{color:"warning",big:""},on:{click:t.desetAll}},[t._v(t._s(t.t.deselect_all))])],1)])])},staticRenderFns:[]}},62:function(t,e,s){var i=s(63);"string"==typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);s(27)("1ee43576",i,!0)},63:function(t,e,s){e=t.exports=s(26)(void 0),e.push([t.i,".big[data-v-50f33012]{font-size:2em}.margin-left[data-v-50f33012]{margin-left:2em}.q-chip[data-v-50f33012]{height:2em}",""])},64:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=s(3),n=s(32),o=s(31);e.default={props:["people","settings","t"],data:function(){return{trial:!1,regions:[],groups:[],committees:[],delegations:[],commissions:[],filtered_people:[],includes:{delegations:!1,commissions:!1,committees:!1}}},computed:{regs:function(){return this.uniques(this.people,"region")},grps:function(){return this.uniques(this.people,"group")},commits:function(){return this.uniques(this.people,"committees")},delegs:function(){return this.uniques(this.people,"delegations")},commiss:function(){return this.uniques(this.people,"commissions")}},methods:{containsSome:function(t,e){for(var s=0;s<t.length;s++)for(var i=0;i<e.length;i++)if(t[s]===e[i])return!0;return!1},contains:function(t,e){for(var s=0;s<t.length;s++)if(t[s]===e)return!0;return!1},uniques:function(t,e){for(var s=[],i=0;i<t.length;i++)if(Array.isArray(t[i][e]))for(var n=0;n<t[i][e].length;n++)this.contains(s,t[i][e][n])||s.push(t[i][e][n]);else this.contains(s,t[i][e])||s.push(t[i][e]);return s.sort(Intl.Collator("cs").compare),s},setAr:function(t,e){this[t]=e,this[t].sort(Intl.Collator("cs").compare),this[t].length>0?this.includes[t]=!0:this.includes[t]=!1,this.filterPeople()},desetAr:function(t,e){this[t]=[],this.filterPeople()},filterPeople:function(){this.filtered_people=[];for(var t=0;t<this.people.length;t++)this.contains(this.regions,this.people[t].region)&&this.contains(this.groups,this.people[t].group)&&(this.includes.delegations&&this.containsSome(this.delegations,this.people[t].delegations)||!this.includes.delegations)&&(this.includes.committees&&this.containsSome(this.committees,this.people[t].committees)||!this.includes.committees)&&(this.includes.commissions&&this.containsSome(this.commissions,this.people[t].commissions)||!this.includes.commissions)&&this.filtered_people.push(this.people[t])}},mounted:function(){this.regions=this.regs,this.groups=this.grps,this.committees=this.commits,this.commissions=this.commiss,this.delegations=this.delegs,this.filtered_people=this.people},components:{"component-select":n,"component-area":o,QList:i.k,QItem:i.f,QItemSeparator:i.h,QItemTile:i.i,QItemMain:i.g,QIcon:i.e,QCheckbox:i.b,QCollapsible:i.d,QChip:i.c}}},65:function(t,e){t.exports={render:function(){var t=this,e=this,s=e.$createElement,i=e._self._c||s;return i("div",[i("q-chip",{staticClass:"big",attrs:{color:"primary"}},[e._v("\n        # 1\n    ")]),e._v(" "),i("div",{staticClass:"margin-left"},[i("h3",[e._v(e._s(e.t.selection)+":")]),e._v(" "),i("q-list",{staticClass:"row"},[i("q-item",{staticClass:"col-sm-6 items-start"},[i("q-item-main",[i("q-item-tile",[i("h4",[i("q-icon",{attrs:{name:"ion-earth"}}),e._v(" "+e._s(e.t.regions))],1)]),e._v(" "),i("component-select",{attrs:{items:e.regs,t:e.t},on:{setUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).setAr.apply(i,["regions"].concat(e));var i},desetUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).desetAr.apply(i,["regions"].concat(e));var i}}})],1)],1),e._v(" "),i("q-item-separator"),e._v(" "),i("q-item",{staticClass:"col-sm-6 items-start"},[i("q-item-main",[i("q-item-tile",[i("h4",[i("q-icon",{attrs:{name:"ion-flag"}}),e._v(" "+e._s(e.t.groups))],1)]),e._v(" "),i("component-select",{attrs:{items:e.grps,t:e.t},on:{setUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).setAr.apply(i,["groups"].concat(e));var i},desetUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).desetAr.apply(i,["groups"].concat(e));var i}}})],1)],1)],1),e._v(" "),i("q-collapsible",{staticClass:"bg-light",attrs:{icon:"ion-wand",label:e.t.detailed_select}},[i("q-list",{staticClass:"row"},[i("q-item",{staticClass:"col-md-4 items-start"},[i("q-item-main",[i("q-item-tile",[i("h5",[i("q-checkbox",{on:{change:e.filterPeople},model:{value:e.includes.committees,callback:function(t){var s=e.includes;Array.isArray(s)?s.splice("committees",1,t):e.includes.committees=t},expression:"includes['committees']"}}),e._v(" "+e._s(e.t.committees))],1)]),e._v(" "),i("component-select",{attrs:{items:e.commits,t:e.t},on:{setUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).setAr.apply(i,["committees"].concat(e));var i},desetUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).desetAr.apply(i,["committees"].concat(e));var i},checkCommitties:function(t){}}})],1)],1),e._v(" "),i("q-item",{staticClass:"col-md-4 items-start"},[i("q-item-main",[i("q-item-tile",[i("h5",[i("q-checkbox",{on:{change:e.filterPeople},model:{value:e.includes.commissions,callback:function(t){var s=e.includes;Array.isArray(s)?s.splice("commissions",1,t):e.includes.commissions=t},expression:"includes['commissions']"}}),e._v(" "+e._s(e.t.commissions))],1)]),e._v(" "),i("component-select",{attrs:{items:e.commiss,t:e.t},on:{setUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).setAr.apply(i,["commissions"].concat(e));var i},desetUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).desetAr.apply(i,["commissions"].concat(e));var i}}})],1)],1),e._v(" "),i("q-item",{staticClass:"col-md-4 items-start"},[i("q-item-main",[i("q-item-tile",[i("h5",[i("q-checkbox",{on:{change:e.filterPeople},model:{value:e.includes.delegations,callback:function(t){var s=e.includes;Array.isArray(s)?s.splice("delegations",1,t):e.includes.delegations=t},expression:"includes['delegations']"}}),e._v(" "+e._s(e.t.delegations))],1)]),e._v(" "),i("component-select",{attrs:{items:e.delegs,t:e.t},on:{setUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).setAr.apply(i,["delegations"].concat(e));var i},desetUp:function(){for(var e=[],s=arguments.length;s--;)e[s]=arguments[s];return(i=t).desetAr.apply(i,["delegations"].concat(e));var i}}})],1)],1)],1)],1)],1),e._v(" "),i("hr"),e._v(" "),i("q-chip",{staticClass:"big",attrs:{color:"primary"}},[e._v("\n        # 2\n    ")]),e._v(" "),i("div",{staticClass:"margin-left"},[i("component-area",{attrs:{items:e.filtered_people,t:e.t,settings:e.settings}})],1)],1)},staticRenderFns:[]}}});