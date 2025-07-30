jQuery(function ($) {

    const DURATION = 7000; // ms – keep in sync with CSS & autoplay
    const PROGRESS_RADIUS = 23;
    const PROGRESS_CIRCUMFERENCE = 2 * Math.PI * PROGRESS_RADIUS;
    let height = $('.bb-slider-content').outerHeight();
    $('.bb-slider-images').height(height);
    let previousIndex = 0;
    let autoInterval;

    function startProgress(index) {
        const circles = $('.bb-circle-outline .progress-ring__circle');
        circles.css({
            'transition': 'none',
            'stroke-dasharray': PROGRESS_CIRCUMFERENCE,
            'stroke-dashoffset': PROGRESS_CIRCUMFERENCE
        });
        const circle = circles.eq(index);
        if(circle.length){
            circle[0].getBoundingClientRect();
            circle.css({
                'transition': `stroke-dashoffset ${DURATION/1000}s linear`,
                'stroke-dashoffset': 0
            });
        }
    }

    function startAuto() {
        if(autoInterval) return;
        startProgress(previousIndex);
        autoInterval = setInterval(function(){
            const actions = $('.bb-slider-actions');
            if(actions.length){
                let next = (previousIndex + 1) % actions.length;
                $(actions[next]).trigger('click');
            }
        }, DURATION);
    }

    function stopAuto(){
        clearInterval(autoInterval);
        autoInterval = null;
    }

    $('.bb-slider-actions').on('click', function (e) {
        e.preventDefault();
        const targetIndex = $('.bb-slider-actions').index(this);
        const items = $('.bb-slider-item');

        // Prevent multiple clicks during animation
        if (isAnimating) return;

        let clForward = {
            0: ["active", "next", "pre-pre d-none", "previous"],
            1: ["previous", "active", "next", "pre-pre d-none"],
            2: ["pre-pre d-none", "previous", "active", "next"],
            3: ["next", "pre-pre d-none", "previous", "active"]
        }

        let clReverse = {
            0: ["active", "next", "next-next d-none", "previous"],
            1: ["previous", "active", "next", "next-next d-none"],
            2: ["next-next d-none", "previous", "active", "next"],
            3: ["next", "next-next d-none", "previous", "active"]
        }

        function animateStep(currentIndex, targetIndex, isForward) {
            const classes = isForward ? clForward : clReverse;
            $('.bb-slider-item').removeClass('previous active next next-next pre-pre d-none');

            for (let i = 0; i < classes[currentIndex]?.length; i++) {
                $(items[i]).addClass(`${classes[currentIndex][i]}`)
            }

            setTimeout(() => {
                if (isForward) {
                    if (targetIndex == 4) {
                        console.log("Jimi")
                    } else {
                        $('.pre-pre').addClass('next-next')
                        $('.next-next').removeClass('pre-pre d-none')
                    }

                } else {
                    if (targetIndex == 0) {
                        console.log("Nithyaja")
                    } else {
                        $('.next-next').addClass('pre-pre')
                        $('.pre-pre').removeClass('next-next d-none')
                    }

                }
            }, 2000)
        }

        function animateToTarget(start, target) {
            isAnimating = true;
            let current = start;

            function nextStep() {
                if (current === target) {
                    previousIndex = target;
                    $('.bb-slider-description').slideUp(300);
                    $($('.bb-slider-actions')[target]).closest('div').find('.bb-slider-description').slideToggle(300);
                    isAnimating = false;
                    startProgress(target);
                    return;
                }
                const isForward = current < target;
                current = isForward ? current + 1 : current - 1;
                animateStep(current, target, isForward);
                setTimeout(nextStep, 300);
            }

            nextStep();
        }

        if (previousIndex !== targetIndex) {
            animateToTarget(previousIndex, targetIndex);
        }

    });

    $('.bb-toggle-slider').on('click', function (e) {
        e.preventDefault();
        if ($(this).closest('div').hasClass('active')) {
            $('.bb-slider-context > div').removeClass('active')
            $(this).closest('div').find('.bb-slider-description').slideUp()
        } else {
            $('.bb-slider-context > div').removeClass('active')
            $(this).closest('div').addClass('active')
            $('.bb-slider-description').slideUp()
            $(this).closest('div').find('.bb-slider-description').slideToggle()
        }
    })

    // Initialize animation state
    let isAnimating = false;


$('.bb-downarrow').on('click', function (e) {
    e.preventDefault();
    const wrapper = $(this).closest('.d-flex.justify-content-between');
    const desc = wrapper.next('.bb-faq-description');
    const icon = $(this).find('.bb-faq-icon');

    if (desc.hasClass('active')) {
        desc.stop(true, true).slideUp(200).removeClass('active');
        icon.attr('src', icon.data('add'));
    } else {
        $('.bb-faq-description.active').not(desc).stop(true, true).slideUp(200).removeClass('active');
        $('.bb-faq-icon').not(icon).attr('src', function(){ return $(this).data('add'); });
        desc.stop(true, true).slideDown(300).addClass('active');
        icon.attr('src', icon.data('subtract'));
    }
});
    const sliderSection = $('.bb-circle-slider').first();
    if(sliderSection.length){
        const observer = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if(entry.isIntersecting){
                    startAuto();
                } else {
                    stopAuto();
                }
            });
        }, {threshold:0.5});
        observer.observe(sliderSection[0]);
    }
})
