!function(e){"object"==typeof exports&&"object"==typeof module?e(require("../../lib/codemirror")):"function"==typeof define&&define.amd?define(["../../lib/codemirror"],e):e(CodeMirror)}((function(e){"use strict";e.defineMode("javascript",(function(t,r){var n,a,i=t.indentUnit,o=r.statementIndent,c=r.jsonld,u=r.json||c,s=r.typescript,f=r.wordCharacters||/[\w$\xa1-\uffff]/,l=function(){function e(e){return{type:e,style:"keyword"}}var t=e("keyword a"),r=e("keyword b"),n=e("keyword c"),a=e("keyword d"),i=e("operator"),o={type:"atom",style:"atom"};return{if:e("if"),while:t,with:t,else:r,do:r,try:r,finally:r,return:a,break:a,continue:a,new:e("new"),delete:n,void:n,throw:n,debugger:e("debugger"),var:e("var"),const:e("var"),let:e("var"),function:e("function"),catch:e("catch"),for:e("for"),switch:e("switch"),case:e("case"),default:e("default"),in:i,typeof:i,instanceof:i,true:o,false:o,null:o,undefined:o,NaN:o,Infinity:o,this:e("this"),class:e("class"),super:e("atom"),yield:n,export:e("export"),import:e("import"),extends:n,await:n}}(),d=/[+\-*&%=<>!?|~^@]/,p=/^@(context|id|value|language|type|container|list|set|reverse|index|base|vocab|graph)"/;function m(e,t,r){return n=e,a=r,t}function k(e,t){var r,n=e.next();if('"'==n||"'"==n)return t.tokenize=(r=n,function(e,t){var n,a=!1;if(c&&"@"==e.peek()&&e.match(p))return t.tokenize=k,m("jsonld-keyword","meta");for(;null!=(n=e.next())&&(n!=r||a);)a=!a&&"\\"==n;return a||(t.tokenize=k),m("string","string")}),t.tokenize(e,t);if("."==n&&e.match(/^\d+(?:[eE][+\-]?\d+)?/))return m("number","number");if("."==n&&e.match(".."))return m("spread","meta");if(/[\[\]{}\(\),;\:\.]/.test(n))return m(n);if("="==n&&e.eat(">"))return m("=>","operator");if("0"==n&&e.eat(/x/i))return e.eatWhile(/[\da-f]/i),m("number","number");if("0"==n&&e.eat(/o/i))return e.eatWhile(/[0-7]/i),m("number","number");if("0"==n&&e.eat(/b/i))return e.eatWhile(/[01]/i),m("number","number");if(/\d/.test(n))return e.match(/^\d*(?:\.\d*)?(?:[eE][+\-]?\d+)?/),m("number","number");if("/"==n)return e.eat("*")?(t.tokenize=v,v(e,t)):e.eat("/")?(e.skipToEnd(),m("comment","comment")):Be(e,t,1)?(function(e){for(var t,r=!1,n=!1;null!=(t=e.next());){if(!r){if("/"==t&&!n)return;"["==t?n=!0:n&&"]"==t&&(n=!1)}r=!r&&"\\"==t}}(e),e.match(/^\b(([gimyu])(?![gimyu]*\2))+\b/),m("regexp","string-2")):(e.eat("="),m("operator","operator",e.current()));if("`"==n)return t.tokenize=y,y(e,t);if("#"==n)return e.skipToEnd(),m("error","error");if(d.test(n))return">"==n&&t.lexical&&">"==t.lexical.type||(e.eat("=")?"!"!=n&&"="!=n||e.eat("="):/[<>*+\-]/.test(n)&&(e.eat(n),">"==n&&e.eat(n))),m("operator","operator",e.current());if(f.test(n)){e.eatWhile(f);var a=e.current();if("."!=t.lastType){if(l.propertyIsEnumerable(a)){var i=l[a];return m(i.type,i.style,a)}if("async"==a&&e.match(/^(\s|\/\*.*?\*\/)*[\(\w]/,!1))return m("async","keyword",a)}return m("variable","variable",a)}}function v(e,t){for(var r,n=!1;r=e.next();){if("/"==r&&n){t.tokenize=k;break}n="*"==r}return m("comment","comment")}function y(e,t){for(var r,n=!1;null!=(r=e.next());){if(!n&&("`"==r||"$"==r&&e.eat("{"))){t.tokenize=k;break}n=!n&&"\\"==r}return m("quasi","string-2",e.current())}function b(e,t){t.fatArrowAt&&(t.fatArrowAt=null);var r=e.string.indexOf("=>",e.start);if(!(r<0)){if(s){var n=/:\s*(?:\w+(?:<[^>]*>|\[\])?|\{[^}]*\})\s*$/.exec(e.string.slice(e.start,r));n&&(r=n.index)}for(var a=0,i=!1,o=r-1;o>=0;--o){var c=e.string.charAt(o),u="([{}])".indexOf(c);if(u>=0&&u<3){if(!a){++o;break}if(0==--a){"("==c&&(i=!0);break}}else if(u>=3&&u<6)++a;else if(f.test(c))i=!0;else{if(/["'\/]/.test(c))return;if(i&&!a){++o;break}}}i&&!a&&(t.fatArrowAt=o)}}var w={atom:!0,number:!0,variable:!0,string:!0,regexp:!0,this:!0,"jsonld-keyword":!0};function x(e,t,r,n,a,i){this.indented=e,this.column=t,this.type=r,this.prev=a,this.info=i,null!=n&&(this.align=n)}function h(e,t){for(var r=e.localVars;r;r=r.next)if(r.name==t)return!0;for(var n=e.context;n;n=n.prev)for(r=n.vars;r;r=r.next)if(r.name==t)return!0}var g={state:null,column:null,marked:null,cc:null};function j(){for(var e=arguments.length-1;e>=0;e--)g.cc.push(arguments[e])}function M(){return j.apply(null,arguments),!0}function V(e){function t(t){for(var r=t;r;r=r.next)if(r.name==e)return!0;return!1}var n=g.state;if(g.marked="def",n.context){if(t(n.localVars))return;n.localVars={name:e,next:n.localVars}}else{if(t(n.globalVars))return;r.globalVars&&(n.globalVars={name:e,next:n.globalVars})}}function A(e){return"public"==e||"private"==e||"protected"==e||"abstract"==e||"readonly"==e}var E={name:"this",next:{name:"arguments"}};function z(){g.state.context={prev:g.state.context,vars:g.state.localVars},g.state.localVars=E}function I(){g.state.localVars=g.state.context.vars,g.state.context=g.state.context.prev}function T(e,t){var r=function(){var r=g.state,n=r.indented;if("stat"==r.lexical.type)n=r.lexical.indented;else for(var a=r.lexical;a&&")"==a.type&&a.align;a=a.prev)n=a.indented;r.lexical=new x(n,g.stream.column(),e,null,r.lexical,t)};return r.lex=!0,r}function $(){var e=g.state;e.lexical.prev&&(")"==e.lexical.type&&(e.indented=e.lexical.indented),e.lexical=e.lexical.prev)}function C(e){return function t(r){return r==e?M():";"==e?j():M(t)}}function q(e,t){return"var"==e?M(T("vardef",t.length),de,C(";"),$):"keyword a"==e?M(T("form"),S,q,$):"keyword b"==e?M(T("form"),q,$):"keyword d"==e?g.stream.match(/^\s*$/,!1)?M():M(T("stat"),N,C(";"),$):"debugger"==e?M(C(";")):"{"==e?M(T("}"),ee,$):";"==e?M():"if"==e?("else"==g.state.lexical.info&&g.state.cc[g.state.cc.length-1]==$&&g.state.cc.pop()(),M(T("form"),S,q,$,ye)):"function"==e?M(je):"for"==e?M(T("form"),be,q,$):"class"==e||s&&"interface"==t?(g.marked="keyword",M(T("form"),Ae,$)):"variable"==e?s&&"declare"==t?(g.marked="keyword",M(q)):s&&("module"==t||"enum"==t||"type"==t)&&g.stream.match(/^\s*\w/,!1)?(g.marked="keyword","enum"==t?M(Ne):"type"==t?M(ae,C("operator"),ae,C(";")):M(T("form"),pe,C("{"),T("}"),ee,$,$)):s&&"namespace"==t?(g.marked="keyword",M(T("form"),O,ee,$)):M(T("stat"),L):"switch"==e?M(T("form"),S,C("{"),T("}","switch"),ee,$,$):"case"==e?M(O,C(":")):"default"==e?M(C(":")):"catch"==e?M(T("form"),z,C("("),Me,C(")"),q,$,I):"export"==e?M(T("stat"),Te,$):"import"==e?M(T("stat"),Ce,$):"async"==e?M(q):"@"==t?M(O,q):j(T("stat"),O,C(";"),$)}function O(e,t){return W(e,t,!1)}function P(e,t){return W(e,t,!0)}function S(e){return"("!=e?j():M(T(")"),O,C(")"),$)}function W(e,t,r){if(g.state.fatArrowAt==g.stream.start){var n=r?G:F;if("("==e)return M(z,T(")"),Z(Me,")"),$,C("=>"),n,I);if("variable"==e)return j(z,pe,C("=>"),n,I)}var a=r?B:U;return w.hasOwnProperty(e)?M(a):"function"==e?M(je,a):"class"==e||s&&"interface"==t?(g.marked="keyword",M(T("form"),Ve,$)):"keyword c"==e||"async"==e?M(r?P:O):"("==e?M(T(")"),N,C(")"),$,a):"operator"==e||"spread"==e?M(r?P:O):"["==e?M(T("]"),We,$,a):"{"==e?_(R,"}",null,a):"quasi"==e?j(H,a):"new"==e?M(function(e){return function(t){return"."==t?M(e?K:J):"variable"==t&&s?M(se,e?B:U):j(e?P:O)}}(r)):M()}function N(e){return e.match(/[;\}\)\],]/)?j():j(O)}function U(e,t){return","==e?M(O):B(e,t,!1)}function B(e,t,r){var n=0==r?U:B,a=0==r?O:P;return"=>"==e?M(z,r?G:F,I):"operator"==e?/\+\+|--/.test(t)||s&&"!"==t?M(n):s&&"<"==t&&g.stream.match(/^([^>]|<.*?>)*>\s*\(/,!1)?M(T(">"),Z(ae,">"),$,n):"?"==t?M(O,C(":"),a):M(a):"quasi"==e?j(H,n):";"!=e?"("==e?_(P,")","call",n):"."==e?M(Q,n):"["==e?M(T("]"),N,C("]"),$,n):s&&"as"==t?(g.marked="keyword",M(ae,n)):"regexp"==e?(g.state.lastType=g.marked="operator",g.stream.backUp(g.stream.pos-g.stream.start-1),M(a)):void 0:void 0}function H(e,t){return"quasi"!=e?j():"${"!=t.slice(t.length-2)?M(H):M(O,D)}function D(e){if("}"==e)return g.marked="string-2",g.state.tokenize=y,M(H)}function F(e){return b(g.stream,g.state),j("{"==e?q:O)}function G(e){return b(g.stream,g.state),j("{"==e?q:P)}function J(e,t){if("target"==t)return g.marked="keyword",M(U)}function K(e,t){if("target"==t)return g.marked="keyword",M(B)}function L(e){return":"==e?M($,q):j(U,C(";"),$)}function Q(e){if("variable"==e)return g.marked="property",M()}function R(e,t){return"async"==e?(g.marked="property",M(R)):"variable"==e||"keyword"==g.style?(g.marked="property","get"==t||"set"==t?M(X):(s&&g.state.fatArrowAt==g.stream.start&&(r=g.stream.match(/^\s*:\s*/,!1))&&(g.state.fatArrowAt=g.stream.pos+r[0].length),M(Y))):"number"==e||"string"==e?(g.marked=c?"property":g.style+" property",M(Y)):"jsonld-keyword"==e?M(Y):s&&A(t)?(g.marked="keyword",M(R)):"["==e?M(O,te,C("]"),Y):"spread"==e?M(P,Y):"*"==t?(g.marked="keyword",M(R)):":"==e?j(Y):void 0;var r}function X(e){return"variable"!=e?j(Y):(g.marked="property",M(je))}function Y(e){return":"==e?M(P):"("==e?j(je):void 0}function Z(e,t,r){function n(a,i){if(r?r.indexOf(a)>-1:","==a){var o=g.state.lexical;return"call"==o.info&&(o.pos=(o.pos||0)+1),M((function(r,n){return r==t||n==t?j():j(e)}),n)}return a==t||i==t?M():M(C(t))}return function(r,a){return r==t||a==t?M():j(e,n)}}function _(e,t,r){for(var n=3;n<arguments.length;n++)g.cc.push(arguments[n]);return M(T(t,r),Z(e,t),$)}function ee(e){return"}"==e?M():j(q,ee)}function te(e,t){if(s){if(":"==e)return M(ae);if("?"==t)return M(te)}}function re(e){if(s&&":"==e)return g.stream.match(/^\s*\w+\s+is\b/,!1)?M(O,ne,ae):M(ae)}function ne(e,t){if("is"==t)return g.marked="keyword",M()}function ae(e,t){return"variable"==e||"void"==t?"keyof"==t?(g.marked="keyword",M(ae)):(g.marked="type",M(ue)):"string"==e||"number"==e||"atom"==e?M(ue):"["==e?M(T("]"),Z(ae,"]",","),$,ue):"{"==e?M(T("}"),Z(oe,"}",",;"),$,ue):"("==e?M(Z(ce,")"),ie):void 0}function ie(e){if("=>"==e)return M(ae)}function oe(e,t){return"variable"==e||"keyword"==g.style?(g.marked="property",M(oe)):"?"==t?M(oe):":"==e?M(ae):"["==e?M(O,te,C("]"),oe):void 0}function ce(e){return"variable"==e?M(ce):":"==e?M(ae):void 0}function ue(e,t){return"<"==t?M(T(">"),Z(ae,">"),$,ue):"|"==t||"."==e?M(ae):"["==e?M(C("]"),ue):"extends"==t||"implements"==t?(g.marked="keyword",M(ae)):void 0}function se(e,t){if("<"==t)return M(T(">"),Z(ae,">"),$,ue)}function fe(){return j(ae,le)}function le(e,t){if("="==t)return M(ae)}function de(e,t){return"enum"==t?(g.marked="keyword",M(Ne)):j(pe,te,ke,ve)}function pe(e,t){return s&&A(t)?(g.marked="keyword",M(pe)):"variable"==e?(V(t),M()):"spread"==e?M(pe):"["==e?_(pe,"]"):"{"==e?_(me,"}"):void 0}function me(e,t){return"variable"!=e||g.stream.match(/^\s*:/,!1)?("variable"==e&&(g.marked="property"),"spread"==e?M(pe):"}"==e?j():M(C(":"),pe,ke)):(V(t),M(ke))}function ke(e,t){if("="==t)return M(P)}function ve(e){if(","==e)return M(de)}function ye(e,t){if("keyword b"==e&&"else"==t)return M(T("form","else"),q,$)}function be(e){if("("==e)return M(T(")"),we,C(")"),$)}function we(e){return"var"==e?M(de,C(";"),he):";"==e?M(he):"variable"==e?M(xe):j(O,C(";"),he)}function xe(e,t){return"in"==t||"of"==t?(g.marked="keyword",M(O)):M(U,he)}function he(e,t){return";"==e?M(ge):"in"==t||"of"==t?(g.marked="keyword",M(O)):j(O,C(";"),ge)}function ge(e){")"!=e&&M(O)}function je(e,t){return"*"==t?(g.marked="keyword",M(je)):"variable"==e?(V(t),M(je)):"("==e?M(z,T(")"),Z(Me,")"),$,re,q,I):s&&"<"==t?M(T(">"),Z(fe,">"),$,je):void 0}function Me(e,t){return"@"==t&&M(O,Me),"spread"==e?M(Me):s&&A(t)?(g.marked="keyword",M(Me)):j(pe,te,ke)}function Ve(e,t){return"variable"==e?Ae(e,t):Ee(e,t)}function Ae(e,t){if("variable"==e)return V(t),M(Ee)}function Ee(e,t){return"<"==t?M(T(">"),Z(fe,">"),$,Ee):"extends"==t||"implements"==t||s&&","==e?("implements"==t&&(g.marked="keyword"),M(s?ae:O,Ee)):"{"==e?M(T("}"),ze,$):void 0}function ze(e,t){return"async"==e||"variable"==e&&("static"==t||"get"==t||"set"==t||s&&A(t))&&g.stream.match(/^\s+[\w$\xa1-\uffff]/,!1)?(g.marked="keyword",M(ze)):"variable"==e||"keyword"==g.style?(g.marked="property",M(s?Ie:je,ze)):"["==e?M(O,te,C("]"),s?Ie:je,ze):"*"==t?(g.marked="keyword",M(ze)):";"==e?M(ze):"}"==e?M():"@"==t?M(O,ze):void 0}function Ie(e,t){return"?"==t?M(Ie):":"==e?M(ae,ke):"="==t?M(P):j(je)}function Te(e,t){return"*"==t?(g.marked="keyword",M(Se,C(";"))):"default"==t?(g.marked="keyword",M(O,C(";"))):"{"==e?M(Z($e,"}"),Se,C(";")):j(q)}function $e(e,t){return"as"==t?(g.marked="keyword",M(C("variable"))):"variable"==e?j(P,$e):void 0}function Ce(e){return"string"==e?M():j(qe,Oe,Se)}function qe(e,t){return"{"==e?_(qe,"}"):("variable"==e&&V(t),"*"==t&&(g.marked="keyword"),M(Pe))}function Oe(e){if(","==e)return M(qe,Oe)}function Pe(e,t){if("as"==t)return g.marked="keyword",M(qe)}function Se(e,t){if("from"==t)return g.marked="keyword",M(O)}function We(e){return"]"==e?M():j(Z(P,"]"))}function Ne(){return j(T("form"),pe,C("{"),T("}"),Z(Ue,"}"),$,$)}function Ue(){return j(pe,ke)}function Be(e,t,r){return t.tokenize==k&&/^(?:operator|sof|keyword [bcd]|case|new|export|default|spread|[\[{}\(,;:]|=>)$/.test(t.lastType)||"quasi"==t.lastType&&/\{\s*$/.test(e.string.slice(0,e.pos-(r||0)))}return $.lex=!0,{startState:function(e){var t={tokenize:k,lastType:"sof",cc:[],lexical:new x((e||0)-i,0,"block",!1),localVars:r.localVars,context:r.localVars&&{vars:r.localVars},indented:e||0};return r.globalVars&&"object"==typeof r.globalVars&&(t.globalVars=r.globalVars),t},token:function(e,t){if(e.sol()&&(t.lexical.hasOwnProperty("align")||(t.lexical.align=!1),t.indented=e.indentation(),b(e,t)),t.tokenize!=v&&e.eatSpace())return null;var r=t.tokenize(e,t);return"comment"==n?r:(t.lastType="operator"!=n||"++"!=a&&"--"!=a?n:"incdec",function(e,t,r,n,a){var i=e.cc;for(g.state=e,g.stream=a,g.marked=null,g.cc=i,g.style=t,e.lexical.hasOwnProperty("align")||(e.lexical.align=!0);;)if((i.length?i.pop():u?O:q)(r,n)){for(;i.length&&i[i.length-1].lex;)i.pop()();return g.marked?g.marked:"variable"==r&&h(e,n)?"variable-2":t}}(t,r,n,a,e))},indent:function(t,n){if(t.tokenize==v)return e.Pass;if(t.tokenize!=k)return 0;var a,c=n&&n.charAt(0),u=t.lexical;if(!/^\s*else\b/.test(n))for(var s=t.cc.length-1;s>=0;--s){var f=t.cc[s];if(f==$)u=u.prev;else if(f!=ye)break}for(;("stat"==u.type||"form"==u.type)&&("}"==c||(a=t.cc[t.cc.length-1])&&(a==U||a==B)&&!/^[,\.=+\-*:?[\(]/.test(n));)u=u.prev;o&&")"==u.type&&"stat"==u.prev.type&&(u=u.prev);var l=u.type,p=c==l;return"vardef"==l?u.indented+("operator"==t.lastType||","==t.lastType?u.info+1:0):"form"==l&&"{"==c?u.indented:"form"==l?u.indented+i:"stat"==l?u.indented+(function(e,t){return"operator"==e.lastType||","==e.lastType||d.test(t.charAt(0))||/[,.]/.test(t.charAt(0))}(t,n)?o||i:0):"switch"!=u.info||p||0==r.doubleIndentSwitch?u.align?u.column+(p?0:1):u.indented+(p?0:i):u.indented+(/^(?:case|default)\b/.test(n)?i:2*i)},electricInput:/^\s*(?:case .*?:|default:|\{|\})$/,blockCommentStart:u?null:"/*",blockCommentEnd:u?null:"*/",blockCommentContinue:u?null:" * ",lineComment:u?null:"//",fold:"brace",closeBrackets:"()[]{}''\"\"``",helperType:u?"json":"javascript",jsonldMode:c,jsonMode:u,expressionAllowed:Be,skipExpression:function(e){var t=e.cc[e.cc.length-1];t!=O&&t!=P||e.cc.pop()}}})),e.registerHelper("wordChars","javascript",/[\w$]/),e.defineMIME("text/javascript","javascript"),e.defineMIME("text/ecmascript","javascript"),e.defineMIME("application/javascript","javascript"),e.defineMIME("application/x-javascript","javascript"),e.defineMIME("application/ecmascript","javascript"),e.defineMIME("application/json",{name:"javascript",json:!0}),e.defineMIME("application/x-json",{name:"javascript",json:!0}),e.defineMIME("application/ld+json",{name:"javascript",jsonld:!0}),e.defineMIME("text/typescript",{name:"javascript",typescript:!0}),e.defineMIME("application/typescript",{name:"javascript",typescript:!0})}));