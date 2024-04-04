/**
 * Bundled by jsDelivr using Rollup v2.79.1 and Terser v5.19.2.
 * Original file: /npm/@swup/fade-theme@2.0.0/dist/index.modern.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
import t from"@swup/theme";function s(){return s=Object.assign?Object.assign.bind():function(t){for(var s=1;s<arguments.length;s++){var a=arguments[s];for(var i in a)Object.prototype.hasOwnProperty.call(a,i)&&(t[i]=a[i])}return t},s.apply(this,arguments)}class a extends t{constructor(t={}){super(),this.name="SwupFadeTheme",this.defaults={mainElement:"#swup"},this.options=s({},this.defaults,t)}mount(){this.applyStyles("html{--swup-fade-theme-duration:.4s}html.is-changing .swup-transition-main{opacity:1;transition:opacity var(--swup-fade-theme-duration)}html.is-animating .swup-transition-main{opacity:0}"),this.addClassName(this.options.mainElement,"main")}}export{a as default};
