let url = new URL(document.location.href);


fetch('php/session.php'+url.search).then(response => response.json()).then((session) => {

    if (!session.session) {
        hide_element('.loader_wrap').then(() => show_element('.login'));
    } else {
        fill_user(session);
        hide_element('.loader_wrap').then(() => show_element('.user'));
    }

}).catch(() => {

    hide_element('.loader_wrap').then(() => show_element('.login')).then(() => {
        show_error('Loading server error!');
    });
});

let success_timer = false;

document.querySelector('form').addEventListener('submit', (event) => {

    event.preventDefault();

    const formData = new FormData(event.target);
    const nickname = formData.get('nickname');
    const password = formData.get('password');
    const session = formData.get('session');

    let data = new URLSearchParams();
    data.set('nickname', nickname);
    data.set('password', password);
    data.set('session', session);

    fetch('php/auth.php', {
        method: 'POST',
        body: data
    }).then(response => response.json()).then((result) => {

        if (!result.success) {

            show_error(result.error);

        } else {

            fill_user(result);
            hide_element('.login').then(() => show_element('.user'));
            hide_element('.login_error');
            show_element('.success');
            success_timer = setTimeout(hide_element, 10000, '.success');
        }
    }).catch(() => {
        show_error('Authorization server error!');
    })
});

document.querySelector('.user_logout').addEventListener('click', (event) => {

    fetch('php/logout.php'+url.search).then().then(() => {

        if (success_timer) {
            clearTimeout(success_timer);
        }

        hide_element('.success');
        hide_element('.user').then(() => show_element('.login'));

    }).catch(() => {
        console.log('Logout error!');
    })
});

function show_error(error_msg) {

    document.querySelector('.login_error').innerHTML = error_msg;
    show_element('.login_error');
}

function fill_user(session) {

    document.querySelector('.user_photo img').setAttribute('src', session.avatar_url);
    document.querySelector('.user_title').innerHTML = session.nickname;
    document.querySelector('.user_info').innerHTML = session.date_of_birth;
}

function hide_element(selector) {

    return new Promise((resolve, reject) => {
        const elem = document.querySelector(selector);

        if (!elem) reject();

        function listener() {

            if (elem.classList.contains('hide')) elem.classList.add('hidden');
            elem.removeEventListener('transitionend', listener);
            resolve();
        }

        if (elem.classList.contains('hide')) resolve();
        elem.classList.add('hide');
        elem.addEventListener('transitionend', listener);
    });
}

function show_element(selector) {

    return new Promise((resolve, reject) => {
        const elem = document.querySelector(selector);

        if (!elem) reject();

        function listener() {
            
            elem.removeEventListener('transitionend', listener);
            resolve();
        }

        elem.classList.remove('hidden');

        setTimeout(() => {

            if (!elem.classList.contains('hide')) resolve();
            elem.classList.remove('hide');
            elem.addEventListener('transitionend', listener);

        }, 10);

    });
}