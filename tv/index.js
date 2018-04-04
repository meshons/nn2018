var scroller = 1;
function explode() {
  $(document).scrollTop(scroller);
  scroller = scroller + 1;
  if (scroller % 1080 == 0) scroller = 0;
}

// setInterval(explode, 10);