function getCoords(elem) {
  let box = elem.getBoundingClientRect();
  return box.top + pageYOffset;
}

const anchor = document.getElementById('anchor');
const form = document.getElementById('submitForm');

let anchorCoords = getCoords(anchor);

let resizeMark = 0;

if(document.documentElement.clientWidth < 1050 && resizeMark === 0) {
  resizeMark = 1;
} else if (document.documentElement.clientWidth >= 1050 && resizeMark === 1) {
  resizeMark = 0;
}

window.addEventListener('scroll', function() {
  if ((getCoords(form) >= anchorCoords || (pageYOffset + 62) >= anchorCoords) && resizeMark === 0) {
    form.className = "header-form submit-form noscroll";
    form.style.top = anchorCoords;
    switcher = 0;
  } else {
    form.className = "header-form submit-form scroll";
    form.style.top = '62px';
    switcher = 1; 
  }
});

window.addEventListener('resize', () => {
  anchorCoords = getCoords(anchor);
  if(document.documentElement.clientWidth < 1050 && resizeMark === 0) {
    resizeMark = 1;
  } else if (document.documentElement.clientWidth >= 1050 && resizeMark === 1) {
    resizeMark = 0;
  }
})