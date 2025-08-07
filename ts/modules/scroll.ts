class heraScroll {
    is_single: boolean = false;
    constructor() {
        //@ts-ignore
        this.is_single = obvInit.is_single;

        if (document.querySelector('.hBackTop')) {
            const backToTop = document.querySelector('.hBackTop') as HTMLElement;
            window.addEventListener('scroll', () => {
                const t = window.scrollY || window.pageYOffset;

                t > 200
                    ? backToTop!.classList.add('is-active')
                    : backToTop!.classList.remove('is-active');
            });

            backToTop.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }
}

new heraScroll();
