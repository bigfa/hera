class heraComment extends heraBase {
    loading = false;
    constructor() {
        super();
        this.init();
    }

    private init() {
        if (document.querySelector('.comment-form')) {
            document.querySelector('.comment-form')?.addEventListener('submit', (e) => {
                e.preventDefault();
                if (this.loading) return;
                const form = document.querySelector('.comment-form') as HTMLFormElement;
                const formData = new FormData(form);
                const formDataObj: { [index: string]: any } = {};
                formData.forEach((value, key: any) => (formDataObj[key] = value));
                this.loading = true;
                fetch(this.obvInit.restfulBase + 'hera/v1/comment', {
                    method: 'POST',
                    body: JSON.stringify(formDataObj),
                    headers: {
                        'X-WP-Nonce': this.obvInit.nonce,
                        'Content-Type': 'application/json',
                    },
                })
                    .then((response) => {
                        return response.json();
                    })
                    .then((data) => {
                        this.loading = false;
                        if (data.code != 200) {
                            return this.showNotice(data.message, 'error');
                        }
                        let a = document.getElementById(
                                'cancel-comment-reply-link'
                            ) as HTMLAnchorElement,
                            i = document.getElementById('respond'),
                            n = document.getElementById('wp-temp-form-div');
                        const comment = data.data;
                        const html = `<li class="comment hComment--item" id="comment-${comment.comment_ID}">
                        <div class="hComment--body hComment--body__fresh">
                            <header class="hComment--header">
                                <div class="hComment--avatar">
                                    <img alt="" src="${comment.author_avatar_urls}" class="avatar" height="42" width="42" />
                                </div>
                                <div class="hComment--meta">
                                    ${comment.comment_author}
                                    <time class="hComment--time">${this.obvInit.now_text}</time>
                                </div>
                            </header>
                            <div class="hComment--content">
                                ${comment.comment_content}
                            </div>
                        </div>
                    </li>`;
                        const parent_id = (
                            document.querySelector('#comment_parent') as HTMLInputElement
                        )?.value;
                        (a.style.display = 'none'),
                            (a.onclick = null),
                            ((document.getElementById('comment_parent') as HTMLInputElement).value =
                                '0'),
                            n &&
                                i &&
                                n.parentNode &&
                                (n.parentNode.insertBefore(i, n), n.parentNode.removeChild(n));
                        if (document.querySelector('.hComment--body__fresh'))
                            document
                                .querySelector('.hComment--body__fresh')
                                ?.classList.remove('hComment--body__fresh');

                        const commentInput = document.getElementById(
                            'comment'
                        ) as HTMLInputElement | null;
                        if (commentInput) {
                            commentInput.value = '';
                        }
                        if (parent_id != '0') {
                            document
                                .querySelector('#comment-' + parent_id)
                                ?.insertAdjacentHTML(
                                    'beforeend',
                                    '<ol class="children">' + html + '</ol>'
                                );
                            console.log(parent_id);
                        } else {
                            if (document.querySelector('.hComment--placeholder')) {
                                document.querySelector('.hComment--placeholder')?.remove();
                            }
                            document
                                .querySelector('.hComment--list')
                                ?.insertAdjacentHTML('beforeend', html);
                        }

                        const newComment = document.querySelector(
                            `#comment-${comment.comment_ID}`
                        ) as HTMLElement;

                        if (newComment) {
                            newComment.scrollIntoView({ behavior: 'smooth' });
                        }

                        this.showNotice(this.obvInit.comment_success_text, 'success');
                    });
            });
        }
    }
}

new heraComment();
