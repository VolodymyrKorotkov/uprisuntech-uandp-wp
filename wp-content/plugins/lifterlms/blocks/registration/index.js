!function(){"use strict";var e={n:function(t){var i=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(i,{a:i}),i},d:function(t,i){for(var l in i)e.o(i,l)&&!e.o(t,l)&&Object.defineProperty(t,l,{enumerable:!0,get:i[l]})},o:function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}},t=window.wp.element,i=window.wp.blocks,l=window.wp.components,r=window.wp.blockEditor,n=window.wp.i18n,s=window.wp.serverSideRender,o=e.n(s),a=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"llms/registration","title":"LifterLMS Register","category":"llms-blocks","description":"Displays the LifterLMS registration form. If a user is already logged in, nothing is displayed.","textdomain":"lifterlms","attributes":{"llms_visibility":{"type":"string"},"llms_visibility_in":{"type":"string"},"llms_visibility_posts":{"type":"string"}},"supports":{"align":["wide","full"]},"editorScript":"file:./index.js"}'),c=window.wp.primitives;(0,i.registerBlockType)(a,{icon:()=>(0,t.createElement)(c.SVG,{className:"llms-block-icon",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 640 512"},(0,t.createElement)(c.Path,{d:"M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"})),edit:e=>{let{attributes:i}=e;const s=(0,r.useBlockProps)(),c=(0,t.useMemo)((()=>(0,t.createElement)(o(),{block:a.name,attributes:i,LoadingResponsePlaceholder:()=>(0,t.createElement)(l.Spinner,null),ErrorResponsePlaceholder:()=>(0,t.createElement)("p",{className:"llms-block-error"},(0,n.__)("Error loading content. Please check block settings are valid. This block will not be displayed.","lifterlms")),EmptyResponsePlaceholder:()=>(0,t.createElement)("p",{className:"llms-block-empty"},(0,n.__)("Registration form preview not available. This block will not be displayed.","lifterlms"))})),[i]);return(0,t.createElement)(t.Fragment,null,(0,t.createElement)("div",s,(0,t.createElement)(l.Disabled,null,c)))}})}();