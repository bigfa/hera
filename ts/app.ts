interface ObvInit {
    like_success_text(like_success_text: any, arg1: string): unknown;
    copy_success_text(copy_success_text: any, arg1: string): unknown;
    now_text: any;
    comment_success_text(comment_success_text: any, arg1: string): unknown;
    archive_id: any;
    nonce: string;
    restfulBase: string;
    is_single: boolean;
    post_id: number;
    is_archive: boolean;
    darkmode: boolean;
    version: string;
}

class heraBase {
    is_single: boolean = false;
    post_id: number = 0;
    is_archive: boolean = false;
    darkmode: any = false;
    VERSION: string;
    obvInit: ObvInit;

    constructor() {
        const obvInit = (window as any).obvInit as ObvInit;
        this.is_single = obvInit.is_single;
        this.post_id = obvInit.post_id;
        this.is_archive = obvInit.is_archive;
        this.darkmode = obvInit.darkmode;
        this.VERSION = obvInit.version;
        this.obvInit = obvInit;
    }

    getCookie(t: any) {
        if (0 < document.cookie.length) {
            var e = document.cookie.indexOf(t + '=');
            if (-1 != e) {
                e = e + t.length + 1;
                var n = document.cookie.indexOf(';', e);
                return -1 == n && (n = document.cookie.length), document.cookie.substring(e, n);
            }
        }
        return '';
    }

    setCookie(t: any, e: any, n: any) {
        var o = new Date();
        o.setTime(o.getTime() + 24 * n * 60 * 60 * 1e3);
        var i = 'expires=' + o.toUTCString();
        document.cookie = t + '=' + e + ';' + i + ';path=/';
    }

    showNotice(message: any, type: any = 'success') {
        const html = `<div class="notice--wrapper">${message}</div>`;

        document.querySelector('body')!.insertAdjacentHTML('beforeend', html);
        document.querySelector('.notice--wrapper')!.classList.add('is-active');
        setTimeout(() => {
            document.querySelector('.notice--wrapper')!.remove();
        }, 3000);
    }
}

if (document.querySelector('.nav--clicker')) {
    const footerLogo = document.querySelector('.nav--clicker');
    if (footerLogo) {
        footerLogo.addEventListener('click', function () {
            const body = document.querySelector('body');
            if (body) {
                body.classList.toggle('is-readingMode');
            }
        });
    }
}

if (document.querySelector('.menu--icon')) {
    document.querySelector('.menu--icon')!.addEventListener('click', () => {
        document.querySelector('.site--nav')!.classList.add('is-active');
        document.querySelector('body')!.classList.add('menu--actived');
    });
}

if (document.querySelector('.search--icon')) {
    document.querySelector('.search--icon')!.addEventListener('click', () => {
        document.querySelector('body')!.classList.toggle('search--actived');
    });
}

if (document.querySelector('.mask')) {
    document.querySelector('.mask')!.addEventListener('touchstart', () => {
        document.querySelector('.site--nav')!.classList.remove('is-active');
        document.querySelector('body')!.classList.remove('menu--actived');
    });
}
