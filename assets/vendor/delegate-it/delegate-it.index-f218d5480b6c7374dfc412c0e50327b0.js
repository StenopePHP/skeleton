/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/delegate-it@6.0.1/index.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
const e=new WeakMap;function t(t,n,o,a){if(!t&&!e.has(n))return!1;const s=e.get(n)??new WeakMap;e.set(n,s);const r=s.get(o)??new Set;s.set(o,r);const c=r.has(a);return t?r.add(a):r.delete(a),c&&t}function n(e,n,o,a={}){const{signal:s,base:r=document}=a;if(s?.aborted)return;const{once:c,...i}=a,d=r instanceof Document?r.documentElement:r,u=Boolean("object"==typeof a?a.capture:a),f=a=>{const s=function(e,t){let n=e.target;if(n instanceof Text&&(n=n.parentElement),n instanceof Element&&e.currentTarget instanceof Element){const o=n.closest(t);if(o&&e.currentTarget.contains(o))return o}}(a,e);if(s){const e=Object.assign(a,{delegateTarget:s});o.call(d,e),c&&(d.removeEventListener(n,f,i),t(!1,d,o,l))}},l=JSON.stringify({selector:e,type:n,capture:u});t(!0,d,o,l)||d.addEventListener(n,f,i),s?.addEventListener("abort",(()=>{t(!1,d,o,l)}))}async function o(e,t,o={}){return new Promise((a=>{o.once=!0,o.signal?.aborted&&a(void 0),o.signal?.addEventListener("abort",(()=>{a(void 0)})),n(e,t,a,o)}))}export{n as default,o as oneEvent};
