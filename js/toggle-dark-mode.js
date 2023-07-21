let SUPER_BAD_GLOBAL_DURATION = 0;

// delay adding transition duration to avoid flicker on load
function appendCSS(duration) {
    let link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = postLoadCSSUrl;
    document.head.appendChild(link);
}

/* start: https://stackoverflow.com/a/9899701/1446063 */
function onReady(fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

/* end */

function toggleDarkMode(init = false) {
    let toggleSwitch = document.querySelector(".switch input[type='checkbox']");
    let items = document.querySelectorAll('.toggleable');
    let state = JSON.parse(getCookie('dark-mode'));
    // delay adding transition duration to avoid flicker on load
    if (init) {
        new Promise((resolve) => {
            items.forEach(item => {
                item.classList.toggle('dark', state);
            });
            resolve();
        }).then(() => {
            appendCSS(SUPER_BAD_GLOBAL_DURATION);
        });
    } else {
        state = !state;
        items.forEach(item => {
            item.classList.toggle('dark', state);
        });
    }
    toggleSwitch.checked = state;
    imageSwap(state, SUPER_BAD_GLOBAL_DURATION);
    setCookie('dark-mode', state, 365);
}

function imageSwap(darkMode, duration) {
    // prevent timers from running too fast, we don't need a timer trying to execute at less than 5ms
    // most browsers clamp at 4ms so let's stay above that.
    // we also half it here to account for both fade in and out, to try and match stylesheet timing.
    duration = duration < 800 ? 400 : duration / 2;

    let darkModeOn = document.querySelector('#dark-mode-on');
    let darkModeOff = document.querySelector('#dark-mode-off');

    if (darkMode) {
        fadeOutThenHide(darkModeOn, duration).then(() => {
            displayThenFadeIn(darkModeOff, duration)
        });
    } else {
        fadeOutThenHide(darkModeOff, duration).then(() => {
            displayThenFadeIn(darkModeOn, duration)
        });
    }
}

function initDarkMode() {
    let x = getComputedStyle(document.querySelector(':root')).getPropertyValue('--themeTransitionTimer');
    x = x === "" ? "500ms" : x;
    x = x.match(/\d+/);
    SUPER_BAD_GLOBAL_DURATION = 250;
    if (x !== null)
        SUPER_BAD_GLOBAL_DURATION = x[0];

    let darkMode = getCookie('dark-mode');
    if (darkMode === null) {
        setCookie('dark-mode', 'false', 365);
    }
    toggleDarkMode(true);
}

function fadeOutThenHide(el, duration = 1000) {
    return new Promise((resolve) => {
        let opacity = 1;
        let handle = setInterval(() => {
            if (opacity <= 0) {
                el.style.opacity = "0";
                clearInterval(handle);
                resolve();
            } else {
                el.style.opacity = opacity + "";
                opacity = opacity - (1 / 100);
            }
        }, duration * 0.01);
    }).then(() => {
        el.style.display = "none";
    });
}

function displayThenFadeIn(el, duration = 1000) {
    let opacity = 0;
    el.style.display = "initial";
    let handle = setInterval(() => {
        if (opacity >= 1)
            clearInterval(handle);
        el.style.opacity = opacity + "";
        opacity = opacity + (1 / 100);
    }, duration * 0.01);
}

onReady(initDarkMode);