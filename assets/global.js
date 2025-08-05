// Shared constants for circle progress animations
const PROGRESS_RADIUS = 25.5; // was 24
const PROGRESS_CIRCUMFERENCE = 2 * Math.PI * PROGRESS_RADIUS;

// Expose constants globally for scripts outside this file
window.PROGRESS_RADIUS = PROGRESS_RADIUS;
window.PROGRESS_CIRCUMFERENCE = PROGRESS_CIRCUMFERENCE;

// Insert SVG ring dynamically into target element
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
    svg.setAttribute("viewBox", "0 0 52 52"); // <-- important!
    svg.style.position = "absolute";
    svg.style.top = "0";
    svg.style.left = "0";
    svg.style.zIndex = "1";


  const fg = document.createElementNS(svgNS, "circle");
  fg.setAttribute("class", "progress-ring__circle");
  fg.setAttribute("cx", "26");
  fg.setAttribute("cy", "26");
  fg.setAttribute("r", radius);
  fg.style.strokeDasharray = `${circumference}`;
  fg.style.strokeDashoffset = `${circumference}`;

  svg.appendChild(fg);
  targetEl.appendChild(svg);

  setTimeout(() => {
    if (!fg || isNaN(percent) || !circumference) return;

    const offset = circumference - (percent / 100) * circumference;
    fg.style.transition = "stroke-dashoffset 1s ease";
    fg.style.strokeDashoffset = offset;
  }, 100);
}

// DOM Ready block
jQuery(function ($) {

  // Inject progress rings into each .bb-circle-outline
  document.querySelectorAll('.bb-circle-outline').forEach(el => {
    insertProgressRing(el, 70); // or set dynamic %
  });

const DURATION = 7000; // animation
const INTERVAL_DELAY = DURATION + 300; // 7.3s total cycle

  let height = $('.bb-slider-content').outerHeight();
  $('.bb-slider-images').height(height);
  let previousIndex = 0;
  let autoInterval;
  let isAnimating = false;

  function startProgress(index) {
  const outlines = $('.bb-slider-actions .bb-circle-outline');
  const circleWrapper = outlines.eq(index);
  const circle = circleWrapper.find('.progress-ring__circle');

  // Reset all rings
  $('.progress-ring__circle').css({
    transition: 'none',
    strokeDasharray: PROGRESS_CIRCUMFERENCE,
    strokeDashoffset: PROGRESS_CIRCUMFERENCE
  });

  if (circle.length) {
    // Force reflow to apply initial state before animation
    circle[0].getBoundingClientRect();
    circle.css({
      transition: `stroke-dashoffset ${DURATION / 1000}s linear`,
      strokeDashoffset: 0
    });
  }
}


  function startAuto() {
    if (autoInterval) return;
    startProgress(previousIndex);
    autoInterval = setInterval(function () {
      const actions = $('.bb-slider-actions');
      if (actions.length) {
        let next = (previousIndex + 1) % actions.length;
        $(actions[next]).trigger('click');
      }
    }, INTERVAL_DELAY);
  }

  function stopAuto() {
    clearInterval(autoInterval);
    autoInterval = null;
  }

  $('.bb-slider-actions').on('click', function (e) {
    e.preventDefault();
    const targetIndex = $('.bb-slider-actions').index(this);
    const items = $('.bb-slider-item');

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
  });

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
      $('.bb-faq-icon').not(icon).attr('src', function () {
        return $(this).data('add');
      });
      desc.stop(true, true).slideDown(300).addClass('active');
      icon.attr('src', icon.data('subtract'));
    }
  });

  const sliderSection = $('.bb-circle-slider').first();
  if (sliderSection.length) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          startAuto();
        } else {
          stopAuto();
        }
      });
    }, { threshold: 0.5 });
    observer.observe(sliderSection[0]);
  }
});
