$(document).ready(function () {

    let height = $('.slider-content').outerHeight();
    $('.slider-images').height(height);
    let previousIndex = 0;

    $('.slider-actions').on('click', function (e) {
        e.preventDefault();
        const targetIndex = $('.slider-actions').index(this);
        const items = $('.slider-item');

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
            $('.slider-item').removeClass('previous active next next-next pre-pre d-none');

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
                    $('.description').slideUp(300);
                    $($('.slider-actions')[target]).closest('div').find('.description').slideToggle(300);
                    isAnimating = false;
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

    $('.toggle-slider').on('click', function (e) {
        e.preventDefault();
        if ($(this).closest('div').hasClass('active')) {
            $('.slider-context > div').removeClass('active')
            $(this).closest('div').find('.description').slideUp()
        } else {
            $('.slider-context > div').removeClass('active')
            $(this).closest('div').addClass('active')
            $('.description').slideUp()
            $(this).closest('div').find('.description').slideToggle()
        }
    })

    // Initialize animation state
    let isAnimating = false;

    $('.downarrow').on('click', function (e) {
        e.preventDefault();
        if ($(this).closest('.d-flex.justify-content-between').next('.description').hasClass('active')) {
            $('.description').slideUp(100)
            $(this).closest('.d-flex.justify-content-between').next('.description').removeClass('active')
        } else {
            $('.faq-title').find('.description').removeClass('active')
            $('.description').slideUp(100)
            $(this).closest('.d-flex.justify-content-between').next('.description').slideToggle(300)
            $(this).closest('.d-flex.justify-content-between').next('.description').addClass('active')
        }

    })
})