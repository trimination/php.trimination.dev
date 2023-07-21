function onReady(fn) {
    if (document.readyState === "complete" || document.readyState === "interactive") {
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function buildCookieConfirm() {
    if(getCookie('cookies-accepted') !== null) return;
    let text = "This site uses cookies. By continuing to use this site, you agree to this.";
    let div = document.createElement('div');
    let span = document.createElement('span');
    let btn = document.createElement('button');
    div.setAttribute('class', 'cookie-confirm');

    span.innerText = text;
    span.setAttribute('class', 'cookie-confirm-text');
    div.append(span);

    btn.setAttribute('class', 'cookie-confirm-button');
    btn.innerText = "OK";
    div.append(btn);

    btn.addEventListener('mouseenter', () => {
        btn.style.filter = "brightness(120%)";
    });
    btn.addEventListener('mouseleave', () => {
        btn.style.filter = "unset";
    });
    btn.addEventListener('click', () => {
        acknowledge();
        document.body.removeChild(div);
    });

    document.body.append(div);
}
function acknowledge() {
    setCookie("cookies-accepted", "true", 365);
}
onReady(buildCookieConfirm);