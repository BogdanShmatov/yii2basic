window.addEventListener('DOMContentLoaded', function() {

    'use strict';
    let lesson = document.querySelectorAll('.lesson'),
        lessons = document.querySelector('.lessons'),
        videoContainer = document.querySelectorAll('.video-container');

        function hideVideoContent(a) {
            for(let i = a; i < videoContainer.length; i++) {
                videoContainer[i].classList.remove('show');
                videoContainer[i].classList.add('hide');

            }
        }

    hideVideoContent(1);

        function showVideoContent(b) {
            if(videoContainer[b].classList.contains('hide')) {
               videoContainer[b].classList.remove('hide');
               videoContainer[b].classList.add('show');
            }
        }

        function toggleClassActive(elem) {
            if(!elem.classList.contains('active-lesson')) {
               elem.classList.add('active-lesson');
            } else elem.classList.remove('active-lesson');
        }
  
        lessons.addEventListener('click', function(event) {

            let target = event.target;

            if (target && target.classList.contains('lesson')) {
                for(let i = 0; i < lesson.length; i++) {
                    if (target == lesson[i]) {
                        hideVideoContent(0);
                        showVideoContent(i);
                        toggleClassActive(lesson[i]);
                        break;
                    }
                }
            }
    
        });


    });