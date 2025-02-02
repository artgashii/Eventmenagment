document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filterValue = button.textContent.toLowerCase();
            
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category') || 'all';
                
                if (filterValue === 'all' || category === filterValue) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 0);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    const lightbox = {
        init: function() {
            this.container = document.createElement('div');
            this.container.id = 'lightbox';
            this.container.innerHTML = `
                <div class="lightbox-content">
                    <span class="close-lightbox">&times;</span>
                    <img src="/placeholder.svg" alt="Lightbox Image">
                    <div class="lightbox-info">
                        <h3></h3>
                        <p class="description"></p>
                        <p class="date"></p>
                    </div>
                    <button class="prev-btn">&lt;</button>
                    <button class="next-btn">&gt;</button>
                </div>
            `;
            document.body.appendChild(this.container);
            
            this.currentIndex = 0;
            this.setupListeners();
        },

        setupListeners: function() {
            galleryItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    this.currentIndex = index;
                    this.show(item);
                });
            });

            this.container.querySelector('.close-lightbox').addEventListener('click', () => {
                this.hide();
            });

            this.container.querySelector('.prev-btn').addEventListener('click', () => {
                this.navigate(-1);
            });

            this.container.querySelector('.next-btn').addEventListener('click', () => {
                this.navigate(1);
            });

            document.addEventListener('keydown', (e) => {
                if (!this.container.classList.contains('active')) return;
                
                if (e.key === 'Escape') this.hide();
                if (e.key === 'ArrowLeft') this.navigate(-1);
                if (e.key === 'ArrowRight') this.navigate(1);
            });
        },

        show: function(item) {
            const img = item.querySelector('img');
            const info = item.querySelector('.gallery-item-info');
            
            this.container.querySelector('img').src = img.src;
            this.container.querySelector('.lightbox-info h3').textContent = 
                info.querySelector('h3').textContent;
            this.container.querySelector('.lightbox-info .description').textContent = 
                info.querySelector('p:first-of-type').textContent;
            this.container.querySelector('.lightbox-info .date').textContent = 
                info.querySelector('p:last-of-type').textContent;

            this.container.classList.add('active');
            document.body.style.overflow = 'hidden';
        },

        hide: function() {
            this.container.classList.remove('active');
            document.body.style.overflow = '';
        },

        navigate: function(direction) {
            this.currentIndex = (this.currentIndex + direction + galleryItems.length) % galleryItems.length;
            this.show(galleryItems[this.currentIndex]);
        }
    };

    lightbox.init();

    const lazyLoad = function() {
        const images = document.querySelectorAll('.gallery-item img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    };

    lazyLoad();
});

const searchGallery = (searchTerm) => {
    const items = document.querySelectorAll('.gallery-item');
    const term = searchTerm.toLowerCase();

    items.forEach(item => {
        const title = item.querySelector('h3').textContent.toLowerCase();
        const description = item.querySelector('p').textContent.toLowerCase();

        if (title.includes(term) || description.includes(term)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
};

const sortGallery = (criteria) => {
    const gallery = document.querySelector('.gallery-grid');
    const items = Array.from(document.querySelectorAll('.gallery-item'));

    items.sort((a, b) => {
        let valueA, valueB;

        switch(criteria) {
            case 'date':
                valueA = new Date(a.querySelector('.date').textContent);
                valueB = new Date(b.querySelector('.date').textContent);
                break;
            case 'title':
                valueA = a.querySelector('h3').textContent;
                valueB = b.querySelector('h3').textContent;
                break;
        }

        if (valueA < valueB) return -1;
        if (valueA > valueB) return 1;
        return 0;
    });

    items.forEach(item => gallery.appendChild(item));
};