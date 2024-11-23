if (document.querySelector('.footer--logo')) {
    const footerLogo = document.querySelector('.footer--logo');
    if (footerLogo) {
        footerLogo.addEventListener('click', function () {
            const body = document.querySelector('body');
            if (body) {
                body.classList.toggle('is-readingMode');
            }
        });
    }
}
