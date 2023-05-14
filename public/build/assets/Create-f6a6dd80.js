import{o as r,f as o,b as s,l as _,T as y,a as l,u as e,w as h,F as v,Z as w,t as a,e as b,i as c,m,n as u,g as n}from"./app-584d3672.js";import{_ as k}from"./AuthenticatedLayout-a7f98c4a.js";import"./ApplicationLogo-839f36f3.js";import"./_plugin-vue_export-helper-c27b6911.js";function g(x,p){return r(),o("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[s("path",{"fill-rule":"evenodd",d:"M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z","clip-rule":"evenodd"})])}const S={class:"font-semibold text-xl text-gray-800 leading-tight"},V={class:"py-12"},C={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},N={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"},z=["onSubmit"],B={class:"mt-2"},D=s("label",{for:"name",class:"block text-sm font-medium leading-6 text-gray-900"},"Name",-1),T={class:"relative mt-2 rounded-md shadow-sm"},U={key:0,class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},F={key:0,class:"mt-2 text-sm text-red-600",id:"name-error"},M={class:"mt-2"},L=s("label",{for:"type",class:"block text-sm font-medium leading-6 text-gray-900"},"Type",-1),W={class:"relative mt-2 rounded-md shadow-sm"},q={key:0,class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},A={key:0,class:"mt-2 text-sm text-red-600",id:"type-error"},E={class:"mt-2"},J=s("label",{for:"type",class:"block text-sm font-medium leading-6 text-gray-900"},"Width",-1),Z={class:"relative mt-2 rounded-md shadow-sm"},$={key:0,class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},j={key:0,class:"mt-2 text-sm text-red-600",id:"width-error"},G={class:"mt-2"},H=s("label",{for:"type",class:"block text-sm font-medium leading-6 text-gray-900"},"Longitude",-1),I={class:"relative mt-2 rounded-md shadow-sm"},K={key:0,class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},O={key:0,class:"mt-2 text-sm text-red-600",id:"long-error"},P={class:"mt-2"},Q=["disabled"],se={__name:"Create",setup(x){const p=_("John Doe"),t=y({name:null,type:"Square",width:5,long:50});function f(){t.post("/products",{preserveScroll:!0,onSuccess:()=>t.reset("name","type")})}return(R,i)=>(r(),o(v,null,[l(e(w),{title:"Dashboard"}),l(k,null,{header:h(()=>[s("h2",S,"Create new product: "+a(p.value),1)]),default:h(()=>[s("div",V,[s("div",C,[s("div",N,[s("form",{onSubmit:b(f,["prevent"])},[s("div",B,[D,s("div",T,[c(s("input",{type:"text",name:"name",id:"name","onUpdate:modelValue":i[0]||(i[0]=d=>e(t).name=d),class:u([e(t).errors.name?"pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500":"text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600","block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"]),placeholder:"Name of the product"},null,2),[[m,e(t).name]]),e(t).errors.name?(r(),o("div",U,[l(e(g),{class:"h-5 w-5 text-red-500","aria-hidden":"true"})])):n("",!0)]),e(t).errors.name?(r(),o("p",F,a(e(t).errors.name),1)):n("",!0)]),s("div",M,[L,s("div",W,[c(s("input",{type:"text",name:"type",id:"type","onUpdate:modelValue":i[1]||(i[1]=d=>e(t).type=d),class:u([e(t).errors.type?"pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500":"text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600","block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"]),placeholder:"Type of the product"},null,2),[[m,e(t).type]]),e(t).errors.type?(r(),o("div",q,[l(e(g),{class:"h-5 w-5 text-red-500","aria-hidden":"true"})])):n("",!0)]),e(t).errors.type?(r(),o("p",A,a(e(t).errors.type),1)):n("",!0)]),s("div",E,[J,s("div",Z,[c(s("input",{type:"number",name:"width",id:"width","onUpdate:modelValue":i[2]||(i[2]=d=>e(t).width=d),class:u([e(t).errors.width?"pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500":"text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600","block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"]),placeholder:"Width of the product"},null,2),[[m,e(t).width]]),e(t).errors.width?(r(),o("div",$,[l(e(g),{class:"h-5 w-5 text-red-500","aria-hidden":"true"})])):n("",!0)]),e(t).errors.width?(r(),o("p",j,a(e(t).errors.width),1)):n("",!0)]),s("div",G,[H,s("div",I,[c(s("input",{type:"number",name:"long",id:"long","onUpdate:modelValue":i[3]||(i[3]=d=>e(t).long=d),class:u([e(t).errors.long?"pr-10 text-red-900 ring-red-300 placeholder:text-red-300 focus:ring-red-500":"text-gray-900 ring-gray-300 placeholder:text-gray-400 focus:ring-indigo-600","block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"]),placeholder:"Large of the product"},null,2),[[m,e(t).long]]),e(t).errors.long?(r(),o("div",K,[l(e(g),{class:"h-5 w-5 text-red-500","aria-hidden":"true"})])):n("",!0)]),e(t).errors.long?(r(),o("p",O,a(e(t).errors.long),1)):n("",!0)]),s("div",P,[s("button",{type:"submit",disabled:e(t).processing,class:"rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"},"Save",8,Q)])],40,z)])])])]),_:1})],64))}};export{se as default};