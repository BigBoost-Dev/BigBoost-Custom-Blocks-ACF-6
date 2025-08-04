// Shared constants for circle progress animations
const PROGRESS_RADIUS = 23.5; // was 24
const PROGRESS_CIRCUMFERENCE = 2 * Math.PI * PROGRESS_RADIUS;

// Expose constants globally for scripts outside this file
window.PROGRESS_RADIUS = PROGRESS_RADIUS;
window.PROGRESS_CIRCUMFERENCE = PROGRESS_CIRCUMFERENCE;

jQuery(function ($) {

    const DURATION = 7000; // ms – keep in sync with CSS & autoplay
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

function insertProgressRing(targetEl, percent) {
  if (!(targetEl instanceof Element)) {
    throw new Error('insertProgressRing: targetEl must be a DOM element');
  }

  const svgNS = "http://www.w3.org/2000/svg";
  const radius = PROGRESS_RADIUS;
  const circumference = PROGRESS_CIRCUMFERENCE;

  const svg = document.createElementNS(svgNS, "svg");
  svg.setAttribute("class", "progress-ring");
  svg.setAttribute("width", "52");
  svg.setAttribute("height", "52");

  const fg = document.createElementNS(svgNS, "circle");
  fg.setAttribute("class", "progress-ring__circle");
  fg.setAttribute("cx", "26");
  fg.setAttribute("cy", "26");
  fg.setAttribute("r", radius);
  fg.style.strokeDasharray = `${circumference}`;
  fg.style.strokeDashoffset = `${circumference}`;

  svg.appendChild(fg);
  targetEl.appendChild(svg);

  // Animate
  setTimeout(() => {
    const offset = circumference - (percent / 100) * circumference;
    fg.style.transition = "stroke-dashoffset 1s ease";
    fg.style.stroke-dashoffset = offset;
  }, 50);
}


document.querySelectorAll('.bb-circle-outline').forEach(el => {
  insertProgressRing(el, 70); // Set to your actual percentage
});
