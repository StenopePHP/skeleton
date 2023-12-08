/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/@swup/plugin@2.0.3/dist/index.modern.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
const r=r=>String(r).split(".").concat(["0","0"]).slice(0,3).join(".");class n{constructor(){this.isSwupPlugin=!0,this.requires={},this.swup=void 0,this.version=void 0}mount(){}unmount(){}_beforeMount(){if(!this.name)throw new Error("You must define a name of plugin when creating a class.")}_afterUnmount(){}_checkRequirements(){return"object"!=typeof this.requires||Object.entries(this.requires).forEach((([n,e])=>{if(!function(n,e,t){const i=function(r,n){var e;if("swup"===r)return null!=(e=n.version)?e:"";{var t;const e=n.findPlugin(r);return null!=(t=null==e?void 0:e.version)?t:""}}(n,t);return!!i&&((n,e)=>e.every((e=>{const[,t,i]=e.match(/^([\D]+)?(.*)$/)||[];var s,o;return((r,n)=>{const e={"":r=>0===r,">":r=>r>0,">=":r=>r>=0,"<":r=>r<0,"<=":r=>r<=0};return(e[n]||e[""])(r)})((o=i,s=r(s=n),o=r(o),s.localeCompare(o,void 0,{numeric:!0})),t||">=")})))(i,e)}(n,e=Array.isArray(e)?e:[e],this.swup)){const r=`${n} ${e.join(", ")}`;throw new Error(`Plugin version mismatch: ${this.name} requires ${r}`)}})),!0}}export{n as default};
