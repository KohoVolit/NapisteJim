webpackJsonp([7],{31:function(t,e,s){function a(t){s(48)}var i=s(2)(s(50),s(51),a,"data-v-1159dfbd",null);t.exports=i.exports},48:function(t,e,s){var a=s(49);"string"==typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);s(27)("2a0bd05c",a,!0)},49:function(t,e,s){e=t.exports=s(26)(void 0),e.push([t.i,".selectable[data-v-1159dfbd]{-webkit-touch-callout:all;-webkit-user-select:all;-moz-user-select:all;-ms-user-select:all;user-select:all}.item-avatar[data-v-1159dfbd]{width:38px;height:47px;-moz-border-radius:20px;-webkit-border-radius:20px;text-align:center}",""])},50:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var a=s(3);e.default={props:["items","settings","t"],computed:{number:function(){return this.items.length},selected_emails:function(){for(var t="",e=0;e<this.items.length;e++)t+="'"+this.items[e].name+"' <"+this.items[e].email+">",e<this.items.length-1&&(t+=",\n");return t},mailto:function(){return"mailto:"+this.selected_emails},disabled:function(){return!(this.number>0)}},methods:{imageSrc:function(t){return this.settings.psp_image+t+".jpg"}},components:{QIcon:a.e,QBtn:a.a,QTabs:a.o,QTab:a.m,QTabPane:a.n}}},51:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[s("h3",[t._v(t._s(t.t.selected_mps)+" "),s("q-icon",{staticClass:"ion-android-contacts"}),t._v(" : "+t._s(t.number))],1),t._v(" "),s("h4",[s("q-icon",{staticClass:"ion-email"}),t._v(" "+t._s(t.t.write_email))],1),t._v(" "),s("form",{attrs:{action:t.mailto}},[s("q-btn",{staticClass:"full-width",attrs:{type:"submit",color:"positive",big:"",icon:"ion-email",disabled:t.disabled}},[t._v("  "+t._s(t.t.write_to_them))])],1),t._v(" "),s("h4",[s("q-icon",{staticClass:"ion-at"}),t._v(" "+t._s(t.t.emails)+" "),s("small",[t._v(t._s(t.t.to_copy))])],1),t._v(" "),s("q-tabs",[s("q-tab",{attrs:{name:"tab-1",icon:"ion-at",label:t.t.to_email},slot:"title"}),t._v(" "),s("q-tab",{attrs:{default:"",name:"tab-2",icon:"ion-document-text",label:t.t.as_table},slot:"title"}),t._v(" "),s("q-tab-pane",{attrs:{name:"tab-1"}},[s("p",{staticClass:"selectable bg-light"},[t._v("\n                "+t._s(t.selected_emails)+"\n            ")])]),t._v(" "),s("q-tab-pane",{attrs:{name:"tab-2"}},[s("table",{staticClass:"selectable bg-light"},[s("tbody",t._l(t.items,function(e){return s("tr",[s("td",[s("img",{staticClass:"item-avatar",attrs:{src:t.imageSrc(e.id),alt:e.name}})]),t._v(" "),s("td",[t._v(t._s(e.name))]),t._v(" "),s("td",[t._v(t._s(e.email))]),t._v(" "),s("td",[t._v(t._s(e.region))]),t._v(" "),s("td",[t._v(t._s(e.group))])])}))])])],1)],1)},staticRenderFns:[]}}});