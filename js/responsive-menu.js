let menuOpen = false;
/* start: https://stackoverflow.com/a/9899701/1446063 */
function onReady(fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}
/* end */

function clickHandler() {
    let btn = document.querySelector('.responsive-menu-button');
    let menu = document.querySelector('.nav-menu');
    btn.addEventListener('click', (e)=>{
        btn.classList.toggle('open');
        menu.classList.toggle('open');
        menuOpen = !menuOpen;
    });
}

function resizeHandler() {
    let btn = document.querySelector('.responsive-menu-button');
    window.addEventListener('resize', ()=>{
        if(window.innerWidth >= 850 && menuOpen){
            btn.click();
        }
    });
}

onReady(clickHandler);
onReady(resizeHandler);