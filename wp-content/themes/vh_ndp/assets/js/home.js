jQuery(document).ready(function ($) {
  $("#vendors").owlCarousel({
    items: 5,
    nav: true,
    dots: true,
    navContainer: ".vendors__slider__navigation",
    dotsContainer: ".vendors__slider__navigation__dots",
    navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1957)">
      <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
      </g>
      </svg>`, `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1968)">
      <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
      </g>
      </svg>`],
    responsive: {
      0: {
        items: 2,
        slideBy: 2,
      },
      768: {
        items: 5,
        slideBy: 5,
      },
    }
  });
  $("#partners").owlCarousel({
    items: 6,
    nav: true,
    dots: true,
    navContainer: ".partners__slider__navigation",
    dotsContainer: ".partners__slider__navigation__dots",
    navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1957)">
      <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
      </g>
      </svg>`, `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1968)">
      <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
      </g>
      </svg>`],
    responsive: {
      0: {
        items: 2,
        slideBy: 2
      },
      768: {
        items: 5,
        slideBy: 5,
      },
      992: {
        items: 6,
        slideBy: 6,
      },
    }
  });
  $("#cases").owlCarousel({
    items: 3,
    nav: true,
    dots: true,
    navContainer: ".cases__slider__navigation",
    dotsContainer: ".cases__slider__navigation__dots",
    navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1957)">
      <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
      </g>
      </svg>`, `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1968)">
      <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
      </g>
      </svg>`],
    responsive: {
      0: {
        items: 1,
        slideBy: 1,
      }, 
      768: {
        items: 2,
        margin: 24,
        slideBy: 2,
      },
      992: {
        items: 3,
        slideBy: 3,
        margin: 24,
        nav: false,
        dots: false,
      },
    }
  });
  $("#last_news").owlCarousel({
    items: 3,
    nav: true,
    dots: true,
    navContainer: ".news__slider__navigation",
    dotsContainer: ".news__slider__navigation__dots",
    navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1957)">
      <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
      </g>
      </svg>`, `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
      <rect width="24" height="24" fill="#D9D9D9"/>
      </mask>
      <g mask="url(#mask0_2461_1968)">
      <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
      </g>
      </svg>`],
    responsive: {
      0: {
        items: 1,
        slideBy: 1,
      },
      768: {
        items: 2,
        slideBy: 2,
        margin: 24,
      },
      992: {
        items: 3,
        slideBy: 3,
        margin: 24,
        nav: false,
        dots: false,
      },
    }
  });

  $("#more_posts").owlCarousel({
    items: 3,
    nav: true,
    dots: true,
    navContainer: ".more_post__slider__navigation",
    dotsContainer: ".more_post__slider__navigation__dots",
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
            items:1,
            slideBy: 1,
        },
        768:{
            items: 3,
            slideBy: 3,
            margin: 24,
        },
      }
  });


  let $homeRoadmapBlock = $('.home-roadmap-block');
  if ($homeRoadmapBlock.length) {
    var $svgElement = $('#roadSvg');
    var path = $svgElement.find('path')[0];
    var pathLength = Math.floor( path.getTotalLength() );

    function movePathObj(prcnt, point) {
      if (!point.length) return;

      prcnt = (prcnt * pathLength) / 100;

      // Get x and y values at a certain point in the line
      let pt = path.getPointAtLength(prcnt);
      pt.x = Math.round(pt.x);
      pt.y = Math.round(pt.y);
      point[0].style.webkitTransform = 'translate3d('+pt.x+'px,'+pt.y+'px, 0)';
      return pt;
    }

    let $homeRoadBlockItem = $('.home-roadmap-block-item');
    $homeRoadBlockItem.each(function(index, block) {
      let $block = $(block);
      let $blockLabel = $block.find('.home-roadmap-block-item-lable');
      let blockOffsetTop = $blockLabel[0].offsetTop + ($blockLabel.height() / 2);
      let $blockPointLeft = $block.parent().find('.home-roadmap-block-item-left');
      if (!$blockPointLeft.is(':visible')) return;

      let $blockPoint = $('.pointMap'+(index+1));
      if (!$blockPoint.length) return;

      $blockPoint.addClass('active');

      for (let i=110; i > 0; i-=0.1) {
        i = i.toFixed(1);
        movePathObj(i, $blockPoint);
        let blockPointOffsetTop = $blockPoint.position().top;
        if (blockPointOffsetTop >= blockOffsetTop) {
          break;
        }
      }
    })
  }

})