jQuery(document).ready(function ($) {
  $("#solutions").owlCarousel({
    items:3,
    margin: 24,
    nav: true,
    dots: true,
    navContainer: ".financing__slider__navigation",
    dotsContainer: ".financing__slider__navigation__dots",
    responsive:{
        0:{
            items:1,
        },
        768:{
            slideBy: 3,
            items:3,
        },
    },
    navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1957)">
      <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
      </g>
      </svg>`,`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1968)">
      <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
      </g>
      </svg>`]
  });
  $("#vendors").owlCarousel({
    items: 5,
    nav: true,
    dots: true,
    navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1957)">
      <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
      </g>
      </svg>`,`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1968)">
      <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
      </g>
      </svg>`],
      responsive:{
        0:{
            items:2,
            slideBy: 2
        },
        768:{
            items:5,
            slideBy: 5
        },
      }
  });
});