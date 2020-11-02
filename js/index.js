const hamburger = document.querySelector('.menu__btn');

if(hamburger !== null) {
    const screen = document.querySelector('.main__nav');
    const lineOne = document.querySelector('.navigation__one');
    const lineTwo = document.querySelector('.navigation__two');
    const lineThree = document.querySelector('.navigation__three');
    const items = document.querySelectorAll('.navigate__mobile li');

    console.log(items);

    const tl = gsap.timeline({paused: true, reversed: true});

    gsap.globalTimeline.timeScale(.7);


    tl
    .to(lineOne, { y: 8, yoyo: true, ease: "Power1.easeInOut", duration: .2})
    .to(lineThree, { y: -4, yoyo: true, ease: "Power1.easeInOut", duration: .2}, '-=0.2')
    .to(lineOne, {rotation:-45, duration: .3})
    .to(lineTwo, {opacity: 0,  duration: .3}, '-=.3')
    .to(lineThree, {rotation:45,  duration: .3}, '-=.3') 
    .to(screen,{ css:{height: "80vh"}, ease: "Circ.easeOut" , duration: .5}, '-=.1')
    .to(items, {  css:{visibility: "visible"}, ease: "Power1.easeOut" , duration: .5}, "-=0.1")


    hamburger.addEventListener('click', () => {
        if (tl.reversed()) {
            tl.play();
        } else {
            tl.reverse();
        }    
    }); 
}
