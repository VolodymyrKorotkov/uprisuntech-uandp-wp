function labelsGroup() {
  var divs = document.getElementsByClassName("block-post-item-labels");
  for (let index = 0; index < divs.length; index++) {
    var div = divs[index];
    if(div){
      var children = div.children;
      const viewLabels = [];
      let hideLabels = [];
      let fullW = 0;
      const widthContainer = div.offsetWidth;
      let findLoadMore = false;

      for (var j = 0; j < children.length; j++) {
        var child = children[j];
        var width = child.offsetWidth;
        fullW += width;
        if(child.className.split(' ').indexOf('block-post-item-label-more') > -1){
          findLoadMore = true;
        }
        if(child.className.split(' ').indexOf('block-post-item-label') > -1){
          if(fullW < (widthContainer - 60)){
            viewLabels.push(child)
          } else {
            hideLabels.push(child)
          }
        }
      }

      if(findLoadMore){
        return;
      }
      div.innerHTML = '';

      if(viewLabels.length == 0 && hideLabels.length > 0){
        const first = hideLabels[0];
        first.style.maxWidth = '220px';
        first.style.overflow = 'hidden';
        div.appendChild(first)
        hideLabels = hideLabels.filter((_i, index) => index > 0)
      } else {
        viewLabels.forEach(_i => {
          div.appendChild(_i)
        });
      }

      if(hideLabels.length){
        const divMore = document.createElement("div");
        divMore.className = 'block-post-item-label-more';

        const label = document.createElement("a");
        label.textContent = hideLabels.length;
        label.className = 'block-post-item-label';
        divMore.appendChild(label);

        const block = document.createElement("div");
        block.className = 'block-post-item-label-more-block'

        const blockContainer = document.createElement("div");
        blockContainer.className = 'block-post-item-label-more-container';
        hideLabels.forEach(_i => {
          blockContainer.appendChild(_i)
        })
        block.appendChild(blockContainer)
        divMore.appendChild(block)

        div.appendChild(divMore)
      }
      div.classList.add('overflowReset');
      div.style.overflow = 'unset';
    }
  }
}


jQuery(document).ready(function ($) {
  labelsGroup()
})