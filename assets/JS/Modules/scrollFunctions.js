function scrollFunctions(){
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section');
    const content = document.querySelector('.dashboard_content');

    function handleScroll(){
        if(window.innerWidth >= 992) {
            content.addEventListener('scroll', function(){
                const scrollTop = content.scrollTop;
                let currentID = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
        
                    if(scrollTop >= sectionTop - sectionHeight / 3) {
                        currentID = section.getAttribute('id');
                    };
                    
                });
                navLinks.forEach(link => {
                    const a = link.querySelector('a');
                    link.classList.remove('active');
                    if(a.getAttribute('href') === `#${currentID}`) {
                        link.classList.add('active');
                    }
                });
            })
        } else {
            window.addEventListener('scroll', function(){
                let currentID = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
        
                    if(pageYOffset >= sectionTop - 100) {
                        currentID = section.getAttribute('id');
                    };
                    
                });
                navLinks.forEach(link => {
                    const a = link.querySelector('a');
                    link.classList.remove('active');
                    if(a.getAttribute('href') === `#${currentID}`) {
                        link.classList.add('active');
                    }
                });
            })
        }
    }
    handleScroll();
    window.addEventListener('resize', function(){
        handleScroll();
    });
}

export default scrollFunctions;