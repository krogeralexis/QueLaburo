CustomWiggle.create("wiggle", {wiggles:4, type:"easeOut"})
CustomWiggle.create("bell-circle", {wiggles:6, type:"easeOut"});


TweenLite.set(".bell", {transformOrigin:"center top"});

TweenMax.to(".bell", 3, {rotation:-20, ease:"wiggle"})
TweenMax.to(".bell-icon__circle", 4.5, {x: -20, ease: "bell-circle"})

