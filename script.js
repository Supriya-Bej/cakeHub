gsap.set("#cake", { width: "26%" });

// Make Timeline
var tl = gsap.timeline({
    scrollTrigger: {
        trigger: ".two",
        start: "0% 95%",//First value is "div" and second value is for "screen"
        end: "70% 50%",
        scrub: true, //Provide Reverse animation
        // markers: true
    }
})

tl.to("#cake", {
    width: "25%",
    top: "128%",
    left: "6%"
}, 'orange')
tl.to("#slice", {
    width: "15%",
    top: "166%",
    left: "23%"
}, 'orange')
tl.to("#cherry", {
    width: "15%",
    top: "168%",
    right: "5%"
}, 'orange')
tl.to("#leaf1", {
    top: "119%",
    rotate: "380deg",
    left: "81%"
}, 'orange')
tl.to("#gems", {
    top: "118%",
    rotate: "130deg",
    left: "0%"
}, 'orange')


// Make Timeline
var tl2 = gsap.timeline({
    scrollTrigger: {
        trigger: ".three",
        start: "0% 95%",
        end: "20% 50%",
        scrub: true,
        // markers: true
    }
})
tl2.to("#cake", {
    left: "37%",
    width: "25%",
    top: "210%"
}, 'orange')
