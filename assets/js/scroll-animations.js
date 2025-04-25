document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    // 일반적인 페이드업 애니메이션
    const fadeUpObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // 그리드 아이템용 특별 애니메이션
    const gridObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // 현재 보이는 그리드 아이템들 수집
                const visibleItems = Array.from(entry.target.parentElement.children)
                    .filter(item => item.getBoundingClientRect().top < window.innerHeight);
                
                // 각 아이템에 순차적으로 애니메이션 적용
                visibleItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('is-visible');
                    }, index * 100); // 각 아이템 사이 100ms 딜레이
                });
                
                observer.unobserve(entry.target);
            }
        });
    }, {
        root: null,
        rootMargin: '50px',
        threshold: 0.1
    });

    // 일반 애니메이션 요소들 관찰
    document.querySelectorAll('.animate-on-scroll, .hero-button').forEach(element => {
        fadeUpObserver.observe(element);
    });

    // 그리드 아이템 관찰
    document.querySelectorAll('.post-card').forEach(element => {
        gridObserver.observe(element);
    });
}); 