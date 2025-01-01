var __spreadArray = (this && this.__spreadArray) || function (to, from, pack) {
    if (pack || arguments.length === 2) for (var i = 0, l = from.length, ar; i < l; i++) {
        if (ar || !(i in from)) {
            if (!ar) ar = Array.prototype.slice.call(from, 0, i);
            ar[i] = from[i];
        }
    }
    return to.concat(ar || Array.prototype.slice.call(from));
};
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (Object.prototype.hasOwnProperty.call(b, p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        if (typeof b !== "function" && b !== null)
            throw new TypeError("Class extends value " + String(b) + " is not a constructor or null");
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var heraBase = /** @class */ (function () {
    function heraBase() {
        this.is_single = false;
        this.post_id = 0;
        this.is_archive = false;
        this.darkmode = false;
        //@ts-ignore
        this.is_single = obvInit.is_single;
        //@ts-ignore
        this.post_id = obvInit.post_id;
        //@ts-ignore
        this.is_archive = obvInit.is_archive;
        //@ts-ignore
        this.darkmode = obvInit.darkmode;
        //@ts-ignore
        this.VERSION = obvInit.version;
        console.log('version', this.VERSION);
    }
    heraBase.prototype.getCookie = function (t) {
        if (0 < document.cookie.length) {
            var e = document.cookie.indexOf(t + '=');
            if (-1 != e) {
                e = e + t.length + 1;
                var n = document.cookie.indexOf(';', e);
                return -1 == n && (n = document.cookie.length), document.cookie.substring(e, n);
            }
        }
        return '';
    };
    heraBase.prototype.setCookie = function (t, e, n) {
        var o = new Date();
        o.setTime(o.getTime() + 24 * n * 60 * 60 * 1e3);
        var i = 'expires=' + o.toUTCString();
        document.cookie = t + '=' + e + ';' + i + ';path=/';
    };
    heraBase.prototype.showNotice = function (message, type) {
        if (type === void 0) { type = 'success'; }
        var html = "<div class=\"notice--wrapper\">".concat(message, "</div>");
        document.querySelector('body').insertAdjacentHTML('beforeend', html);
        document.querySelector('.notice--wrapper').classList.add('is-active');
        setTimeout(function () {
            document.querySelector('.notice--wrapper').remove();
        }, 3000);
    };
    return heraBase;
}());
window.findParent = function (t, e, n) {
    do {
        if (e(t))
            return t;
        if (n && t == n)
            return false;
    } while ((t = t.parentNode));
    return false;
};
var imgZoom = /** @class */ (function () {
    function imgZoom() {
        var _this = this;
        this.currentIndex = 0;
        this.images = [];
        // this.init();
        this.getZoomImages();
        window.addEventListener('resize', function () {
            if (document.querySelector('.overlay')) {
                _this.loadImage(_this.images[_this.currentIndex]);
            }
        });
    }
    imgZoom.prototype.getZoomImages = function () {
        var _this = this;
        var images = document.querySelectorAll('[data-action="imageZoomIn"]');
        var imageArray = Array.from(images);
        this.images = __spreadArray([], imageArray, true).map(function (image) { return image.getAttribute('href'); })
            .filter(function (href) { return href !== null; });
        images.forEach(function (image) {
            image.addEventListener('click', function (e) {
                e.preventDefault();
                var url = image.getAttribute('href');
                if (url)
                    _this.showOverlay(url);
            });
        });
    };
    imgZoom.prototype.renderNav = function () {
        var _a, _b, _c, _d;
        var nav = "".concat(this.currentIndex + 1, "/").concat(this.images.length);
        var navElement = document.querySelector('.image--nav');
        if (navElement) {
            navElement.innerHTML = nav;
        }
        if (this.currentIndex === 0) {
            (_a = document.querySelector('.mfp-arrow-left')) === null || _a === void 0 ? void 0 : _a.classList.add('disabled');
        }
        else {
            (_b = document.querySelector('.mfp-arrow-left')) === null || _b === void 0 ? void 0 : _b.classList.remove('disabled');
        }
        if (this.currentIndex === this.images.length - 1) {
            (_c = document.querySelector('.mfp-arrow-right')) === null || _c === void 0 ? void 0 : _c.classList.add('disabled');
        }
        else {
            (_d = document.querySelector('.mfp-arrow-right')) === null || _d === void 0 ? void 0 : _d.classList.remove('disabled');
        }
    };
    imgZoom.prototype.prevImage = function () {
        if (this.currentIndex === 0) {
            return;
        }
        this.currentIndex = this.currentIndex - 1;
        this.loadImage(this.images[this.currentIndex]);
        this.renderNav();
    };
    imgZoom.prototype.nextImage = function () {
        if (this.currentIndex === this.images.length - 1) {
            return;
        }
        this.currentIndex = this.currentIndex + 1;
        this.loadImage(this.images[this.currentIndex]);
        this.renderNav();
    };
    imgZoom.prototype.showOverlay = function (url) {
        var _a, _b, _c;
        var self = this;
        var currentIndex = this.images.indexOf(url);
        this.currentIndex = currentIndex;
        var nav = this.images.length > 0
            ? "<div class=\"image--nav\">".concat(currentIndex + 1, "/").concat(this.images.length, "</div><button title=\"Prev\" type=\"button\" class=\"mfp-arrow mfp-arrow-left mfp-prevent-close\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" aria-hidden=\"true\">\n            <path d=\"M14.4998 7.80903C14.4742 7.74825 14.4372 7.69292 14.3908 7.64603L8.68084 1.93803C8.58696 1.84427 8.45967 1.79165 8.32699 1.79175C8.19431 1.79184 8.0671 1.84464 7.97334 1.93853C7.87959 2.03241 7.82697 2.1597 7.82707 2.29238C7.82716 2.42506 7.87996 2.55227 7.97384 2.64603L12.8278 7.50003H1.96484C1.83224 7.50003 1.70506 7.5527 1.61129 7.64647C1.51752 7.74024 1.46484 7.86742 1.46484 8.00003C1.46484 8.13263 1.51752 8.25981 1.61129 8.35358C1.70506 8.44735 1.83224 8.50003 1.96484 8.50003H12.8278L7.97384 13.354C7.87996 13.4478 7.82716 13.575 7.82707 13.7077C7.82697 13.8404 7.87959 13.9676 7.97334 14.0615C8.0671 14.1554 8.19431 14.2082 8.32699 14.2083C8.45967 14.2084 8.58696 14.1558 8.68084 14.062L14.3878 8.35403C14.4342 8.30713 14.4712 8.2518 14.4968 8.19103C14.5478 8.069 14.5489 7.93184 14.4998 7.80903Z\"></path>\n        </svg></button><button title=\"Next (Right arrow key)\" type=\"button\" class=\"mfp-arrow mfp-arrow-right mfp-prevent-close\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" aria-hidden=\"true\">\n            <path d=\"M14.4998 7.80903C14.4742 7.74825 14.4372 7.69292 14.3908 7.64603L8.68084 1.93803C8.58696 1.84427 8.45967 1.79165 8.32699 1.79175C8.19431 1.79184 8.0671 1.84464 7.97334 1.93853C7.87959 2.03241 7.82697 2.1597 7.82707 2.29238C7.82716 2.42506 7.87996 2.55227 7.97384 2.64603L12.8278 7.50003H1.96484C1.83224 7.50003 1.70506 7.5527 1.61129 7.64647C1.51752 7.74024 1.46484 7.86742 1.46484 8.00003C1.46484 8.13263 1.51752 8.25981 1.61129 8.35358C1.70506 8.44735 1.83224 8.50003 1.96484 8.50003H12.8278L7.97384 13.354C7.87996 13.4478 7.82716 13.575 7.82707 13.7077C7.82697 13.8404 7.87959 13.9676 7.97334 14.0615C8.0671 14.1554 8.19431 14.2082 8.32699 14.2083C8.45967 14.2084 8.58696 14.1558 8.68084 14.062L14.3878 8.35403C14.4342 8.30713 14.4712 8.2518 14.4968 8.19103C14.5478 8.069 14.5489 7.93184 14.4998 7.80903Z\"></path>\n        </svg></button>")
            : '';
        var html = "<div class=\"overlay\"><button class=\"zoomImgClose\"><svg width=\"25\" height=\"25\" viewBox=\"0 0 25 25\" xmlns=\"http://www.w3.org/2000/svg\" class=\"q\"><path d=\"M18.13 6.11l-5.61 5.61-5.6-5.61-.81.8 5.61 5.61-5.61 5.61.8.8 5.61-5.6 5.61 5.6.8-.8-5.6-5.6 5.6-5.62\"/></svg></button><div class=\"overlay-img-wrap\"><img class=\"overlay-image\"><div class=\"lds-ripple\"></div></div>".concat(nav, "</div>");
        var bodyElement = document.querySelector('body');
        if (bodyElement) {
            bodyElement.insertAdjacentHTML('beforeend', html);
            bodyElement.classList.add('u-overflowYHidden');
        }
        this.loadImage(url);
        console.log(self.currentIndex);
        (_a = document.querySelector('.zoomImgClose')) === null || _a === void 0 ? void 0 : _a.addEventListener('click', function () {
            self.overlayRemove();
        });
        (_b = document.querySelector('.mfp-arrow-right')) === null || _b === void 0 ? void 0 : _b.addEventListener('click', function () {
            self.nextImage();
        });
        (_c = document.querySelector('.mfp-arrow-left')) === null || _c === void 0 ? void 0 : _c.addEventListener('click', function () {
            self.prevImage();
        });
    };
    imgZoom.prototype.loadImage = function (o) {
        var s = new Image();
        var rippleElement = document.querySelector('.lds-ripple');
        if (rippleElement) {
            rippleElement.style.display = 'inline-block';
        }
        s.onload = function () {
            var t = s.width, e = s.height, n = window.innerHeight, a = window.innerWidth - 80;
            a < t
                ? ((e *= a / t), (t = a), n < e && ((t *= n / e), (e = n)))
                : n < e && ((t *= n / e), (e = n), a < t && ((e *= a / t), (t = a)));
            var i = document.querySelector('.overlay-image');
            i.setAttribute('src', o), (i.style.width = t + 'px'), (i.style.height = e + 'px');
            var overlayImgWrap = document.querySelector('.overlay-img-wrap');
            if (overlayImgWrap) {
                overlayImgWrap.classList.add('is-finieshed');
            }
            var rippleElement = document.querySelector('.lds-ripple');
            if (rippleElement) {
                rippleElement.style.display = 'none';
            }
        };
        s.src = o;
    };
    imgZoom.prototype.overlayRemove = function () {
        var _a, _b;
        this.remove(document.querySelector('.overlay'));
        (_a = document.querySelector('body')) === null || _a === void 0 ? void 0 : _a.classList.remove('is-zoomActive');
        (_b = document.querySelector('body')) === null || _b === void 0 ? void 0 : _b.classList.remove('u-overflowYHidden');
        // window.removeEventListener('scroll', I);
        // window.removeEventListener('keyup', L);
    };
    imgZoom.prototype.remove = function (t) {
        var e = t.parentNode;
        e && e.removeChild(t);
    };
    return imgZoom;
}());
new imgZoom();
var heraComment = /** @class */ (function (_super) {
    __extends(heraComment, _super);
    function heraComment() {
        var _this = _super.call(this) || this;
        _this.loading = false;
        _this.init();
        return _this;
    }
    heraComment.prototype.init = function () {
        var _this = this;
        var _a;
        if (document.querySelector('.comment-form')) {
            (_a = document.querySelector('.comment-form')) === null || _a === void 0 ? void 0 : _a.addEventListener('submit', function (e) {
                e.preventDefault();
                if (_this.loading)
                    return;
                var form = document.querySelector('.comment-form');
                // @ts-ignore
                var formData = new FormData(form);
                // @ts-ignore
                var formDataObj = {};
                formData.forEach(function (value, key) { return (formDataObj[key] = value); });
                _this.loading = true;
                // @ts-ignore
                fetch(obvInit.restfulBase + 'hera/v1/comment', {
                    method: 'POST',
                    body: JSON.stringify(formDataObj),
                    headers: {
                        // @ts-ignore
                        'X-WP-Nonce': obvInit.nonce,
                        'Content-Type': 'application/json'
                    }
                })
                    .then(function (response) {
                    return response.json();
                })
                    .then(function (data) {
                    var _a, _b, _c, _d, _e;
                    _this.loading = false;
                    if (data.code != 200) {
                        return _this.showNotice(data.message, 'error');
                    }
                    var a = document.getElementById('cancel-comment-reply-link'), i = document.getElementById('respond'), n = document.getElementById('wp-temp-form-div');
                    var comment = data.data;
                    var html = "<li class=\"comment\" id=\"comment-".concat(comment.comment_ID, "\">\n                        <div class=\"comment-body comment-body__fresh\">\n                            <footer class=\"comment-meta\">\n                                <div class=\"comment--avatar\">\n                                    <img alt=\"\" src=\"").concat(comment.author_avatar_urls, "\" class=\"avatar\" height=\"42\" width=\"42\" />\n                                </div>\n                                <div class=\"comment--meta\">\n                                    <div class=\"comment--author\">").concat(comment.comment_author, "\n                                    <time class=\"comment--time\">\u521A\u521A</time>\n                                    </div>\n                                </div>\n                            </footer>\n                            <div class=\"comment-content\">\n                                ").concat(comment.comment_content, "\n                            </div>\n                        </div>\n                    </li>"); // @ts-ignore
                    var parent_id = (_a = document.querySelector('#comment_parent')) === null || _a === void 0 ? void 0 : _a.value;
                    // @ts-ignore
                    (a.style.display = 'none'), // @ts-ignore
                        (a.onclick = null), // @ts-ignore
                        (document.getElementById('comment_parent').value = '0'),
                        n && // @ts-ignore
                            i && // @ts-ignore
                            (n.parentNode.insertBefore(i, n), n.parentNode.removeChild(n));
                    if (document.querySelector('.comment-body__fresh'))
                        (_b = document
                            .querySelector('.comment-body__fresh')) === null || _b === void 0 ? void 0 : _b.classList.remove('comment-body__fresh');
                    // @ts-ignore
                    document.getElementById('comment').value = '';
                    // @ts-ignore
                    if (parent_id != '0') {
                        (_c = document
                            .querySelector(
                        // @ts-ignore
                        '#comment-' + parent_id)) === null || _c === void 0 ? void 0 : _c.insertAdjacentHTML('beforeend', '<ol class="children">' + html + '</ol>');
                        console.log(parent_id);
                    }
                    else {
                        if (document.querySelector('.no--comment')) {
                            (_d = document.querySelector('.no--comment')) === null || _d === void 0 ? void 0 : _d.remove();
                        }
                        (_e = document
                            .querySelector('.commentlist')) === null || _e === void 0 ? void 0 : _e.insertAdjacentHTML('beforeend', html);
                    }
                    var newComment = document.querySelector("#comment-".concat(comment.comment_ID));
                    if (newComment) {
                        newComment.scrollIntoView({ behavior: 'smooth' });
                    }
                    _this.showNotice('评论成功');
                });
            });
        }
    };
    return heraComment;
}(heraBase));
new heraComment();
var heraScroll = /** @class */ (function () {
    function heraScroll() {
        this.is_single = false;
        //@ts-ignore
        this.is_single = obvInit.is_single;
        // this.init();
        if (document.querySelector('.backToTop')) {
            var backToTop_1 = document.querySelector('.backToTop');
            window.addEventListener('scroll', function () {
                var t = window.scrollY || window.pageYOffset;
                // console.log(t);
                // const documentHeight = document.body.clientHeight;
                //const windowHeight = window.innerHeight;
                // const percent = Math.ceil((t / (documentHeight - windowHeight)) * 100);
                t > 200
                    ? backToTop_1.classList.add('is-active')
                    : backToTop_1.classList.remove('is-active');
            });
            backToTop_1.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }
    heraScroll.prototype.init = function () {
        this.scroll();
    };
    heraScroll.prototype.scroll = function () {
        var _this = this;
        var endScroll = document.querySelector('.post-navigation');
        var endScrollTop = endScroll ? endScroll.offsetTop : 0;
        var windowHeight = window.innerHeight;
        window.addEventListener('scroll', function () {
            var _a, _b, _c, _d;
            if (window.scrollY > 10) {
                (_a = document.querySelector('.site--header')) === null || _a === void 0 ? void 0 : _a.classList.add('is-active');
            }
            else {
                (_b = document.querySelector('.site--header')) === null || _b === void 0 ? void 0 : _b.classList.remove('is-active');
            }
            if (_this.is_single) {
                if (window.scrollY > endScrollTop - windowHeight) {
                    (_c = document.querySelector('.post-navigation')) === null || _c === void 0 ? void 0 : _c.classList.add('is-active');
                }
                else {
                    (_d = document.querySelector('.post-navigation')) === null || _d === void 0 ? void 0 : _d.classList.remove('is-active');
                }
            }
        });
    };
    return heraScroll;
}());
new heraScroll();
var heraDate = /** @class */ (function () {
    function heraDate(config) {
        var _this = this;
        this.timeFormat = {
            second: 'second ago',
            seconds: 'seconds ago',
            minute: 'minute ago',
            minutes: 'minutes ago',
            hour: 'hour ago',
            hours: 'hours ago',
            day: 'day ago',
            days: 'days ago',
            week: 'week ago',
            weeks: 'weeks ago',
            month: 'month ago',
            months: 'months ago',
            year: 'year ago',
            years: 'years ago'
        };
        this.doms = [];
        this.selector = config.selector;
        if (config.timeFormat) {
            this.timeFormat = config.timeFormat;
        }
        this.init();
        setTimeout(function () {
            _this.refresh();
        }, 1000 * 5);
    }
    heraDate.prototype.init = function () {
        var _this = this;
        this.doms = Array.from(document.querySelectorAll(this.selector));
        this.doms.forEach(function (dom) {
            dom.innerText = _this.humanize_time_ago(dom.attributes['datetime'].value);
        });
    };
    heraDate.prototype.humanize_time_ago = function (datetime) {
        var time = new Date(datetime);
        var between = Date.now() / 1000 - Number(time.getTime() / 1000);
        if (between < 3600) {
            return "".concat(Math.ceil(between / 60), " ").concat(Math.ceil(between / 60) == 1 ? this.timeFormat.second : this.timeFormat.seconds);
        }
        else if (between < 86400) {
            return "".concat(Math.ceil(between / 3600), " ").concat(Math.ceil(between / 3660) == 1 ? this.timeFormat.hour : this.timeFormat.hours);
        }
        else if (between < 86400 * 30) {
            return "".concat(Math.ceil(between / 86400), " ").concat(Math.ceil(between / 86400) == 1 ? this.timeFormat.day : this.timeFormat.days);
        }
        else if (between < 86400 * 30 * 12) {
            return "".concat(Math.ceil(between / (86400 * 30)), " ").concat(Math.ceil(between / (86400 * 30)) == 1
                ? this.timeFormat.month
                : this.timeFormat.months);
        }
        else {
            return time.getFullYear() + '-' + (time.getMonth() + 1) + '-' + time.getDate();
        }
    };
    heraDate.prototype.refresh = function () {
        var _this = this;
        this.doms.forEach(function (dom) {
            dom.innerText = _this.humanize_time_ago(dom.attributes['datetime'].value);
        });
    };
    return heraDate;
}());
new heraDate({
    selector: '.humane--time',
    //@ts-ignore
    timeFormat: obvInit.timeFormat
});
