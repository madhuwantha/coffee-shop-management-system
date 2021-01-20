(function ($)
{
    "use strict";

    let passiveSupported = false;

    try
    {
        const options = Object.defineProperty({}, 'passive', {
            get: function ()
            {
                passiveSupported = true;
            }
        });

        window.addEventListener('test', null, options);
    } catch (err) { }


    /*
    // initialize custom numbers
    */
    $(function ()
    {
        $('.input-number').customNumber();
    });


    /*
    // topbar dropdown
    */
    $(function ()
    {
        $('.topbar-dropdown__btn').on('click', function ()
        {
            $(this).closest('.topbar-dropdown').toggleClass('topbar-dropdown--opened');
        });

        $(document).on('click', function (event)
        {
            $('.topbar-dropdown')
                .not($(event.target).closest('.topbar-dropdown'))
                .removeClass('topbar-dropdown--opened');
        });
    });


    /*
    // dropcart, drop search
    */
    $(function ()
    {
        $('.indicator--trigger--click .indicator__button').on('click', function (event)
        {
            event.preventDefault();

            const dropdown = $(this).closest('.indicator');

            if (dropdown.is('.indicator--opened'))
            {
                dropdown.removeClass('indicator--opened');
            } else
            {
                dropdown.addClass('indicator--opened');
                dropdown.find('.drop-search__input').focus();
            }
        });

        $('.indicator--trigger--click .drop-search__input').on('keydown', function (event)
        {
            if (event.which === 27)
            {
                $(this).closest('.indicator').removeClass('indicator--opened');
            }
        });

        $(document).on('click', function (event)
        {
            $('.indicator')
                .not($(event.target).closest('.indicator'))
                .removeClass('indicator--opened');
        });
    });


    /*
    // product tabs
    */
    $(function ()
    {
        $('.product-tabs').each(function (i, element)
        {
            $('.product-tabs__list', element).on('click', '.product-tabs__item', function (event)
            {
                event.preventDefault();

                const tab = $(this);
                const content = $('.product-tabs__pane' + $(this).attr('href'), element);

                if (content.length)
                {
                    $('.product-tabs__item').removeClass('product-tabs__item--active');
                    tab.addClass('product-tabs__item--active');

                    $('.product-tabs__pane').removeClass('product-tabs__pane--active');
                    content.addClass('product-tabs__pane--active');
                }
            });

            const currentTab = $('.product-tabs__item--active', element);
            const firstTab = $('.product-tabs__item:first', element);

            if (currentTab.length)
            {
                currentTab.trigger('click');
            } else
            {
                firstTab.trigger('click');
            }
        });
    });


    /*
    // megamenu position
    */
    $(function ()
    {
        $('.nav-panel__nav-links .nav-links__item').on('mouseenter', function ()
        {
            const megamenu = $(this).find('.nav-links__megamenu');

            if (megamenu.length)
            {
                const container = megamenu.offsetParent();
                const containerWidth = container.width();
                const megamenuWidth = megamenu.width();
                const itemPosition = $(this).position().left;
                const megamenuPosition = Math.round(Math.min(itemPosition, containerWidth - megamenuWidth));

                megamenu.css('left', megamenuPosition + 'px');
            }
        });
    });


    /*
    // mobile search
    */
    $(function ()
    {
        const mobileSearch = $('.mobile-header__search');

        if (mobileSearch.length)
        {
            $('.indicator--mobile-search .indicator__button').on('click', function ()
            {
                if (mobileSearch.is('.mobile-header__search--opened'))
                {
                    mobileSearch.removeClass('mobile-header__search--opened');
                } else
                {
                    mobileSearch.addClass('mobile-header__search--opened');
                    mobileSearch.find('input')[0].focus();
                }
            });

            mobileSearch.find('.mobile-header__search-button--close').on('click', function ()
            {
                mobileSearch.removeClass('mobile-header__search--opened');
            });

            document.addEventListener('click', function (event)
            {
                if (!$(event.target).closest('.indicator--mobile-search, .mobile-header__search').length)
                {
                    mobileSearch.removeClass('mobile-header__search--opened');
                }
            }, true);
        }
    });


    /*
    // departments, sticky header
    */
    $(function ()
    {
        /*
        // departments
        */
        const CDepartments = function (element)
        {
            const self = this;

            element.data('departmentsInstance', self);

            this.element = element;
            this.body = this.element.find('.departments__body');
            this.button = this.element.find('.departments__button');
            this.mode = this.element.is('.departments--fixed') ? 'fixed' : 'normal';
            this.fixedBy = $(this.element.data('departments-fixed-by'));
            this.fixedHeight = 0;

            if (this.mode === 'fixed' && this.fixedBy.length)
            {
                this.fixedHeight = this.fixedBy.offset().top - this.body.offset().top + this.fixedBy.outerHeight();
                this.body.css('height', this.fixedHeight + 'px');
            }

            this.button.on('mouseenter', function (event)
            {
                self.clickOnButton(event);
                document.getElementById("set").style.backgroundColor = "#525d66";

            }
            );

            $('.departments__links-wrapper', this.element).on('transitionend', function (event)
            {
                if (event.originalEvent.propertyName === 'height')
                {
                    $(this).css('height', '');
                    $(this).closest('.departments').removeClass('departments--transition');

                }
            });

            document.addEventListener('mouseleave', function (event)
            {
                self.element.not($(event.target).closest('.departments')).each(function ()
                {
                    if (self.element.is('.departments--opened'))
                    {
                        self.element.data('departmentsInstance').close();
                        document.getElementById("set").style.backgroundColor = "transparent";
                    }
                });
            }, true);
        };
        CDepartments.prototype.clickOnButton = function (event)
        {
            event.preventDefault();

            if (this.element.is('.departments--opened'))
            {

                this.close();
            } else
            {
                this.open();
            }
        };
        CDepartments.prototype.setMode = function (mode)
        {
            this.mode = mode;

            if (this.mode === 'normal')
            {
                this.element.removeClass('departments--fixed');
                this.element.removeClass('departments--opened');
                this.body.css('height', 'auto');
            }
            if (this.mode === 'fixed')
            {
                this.element.addClass('departments--fixed');
                this.element.addClass('departments--opened');
                this.body.css('height', this.fixedHeight + 'px');
            }
        };
        CDepartments.prototype.close = function ()
        {
            if (this.element.is('.departments--fixed'))
            {
                return;
            }

            const content = this.element.find('.departments__links-wrapper');
            const startHeight = content.height();

            content.css('height', startHeight + 'px');
            this.element
                .addClass('departments--transition')
                .removeClass('departments--opened');

            content.css('height', '');
        };
        CDepartments.prototype.open = function ()
        {
            const content = this.element.find('.departments__links-wrapper');
            const startHeight = content.height();

            this.element
                .addClass('departments--transition')
                .addClass('departments--opened');

            const endHeight = content.height();

            content.css('height', startHeight + 'px');
            content.css('height', endHeight + 'px');
        };

        const departments = new CDepartments($('.departments'));


        /*
        // sticky header
        */
        const nav = $('.nav-panel--sticky');

        if (nav.length)
        {
            const departmentsMode = departments.mode;
            const defaultPosition = nav.offset().top;
            let stuck = false;

            window.addEventListener('scroll', function ()
            {
                if (window.pageYOffset > defaultPosition)
                {
                    if (!stuck)
                    {
                        nav.addClass('nav-panel--stuck');
                        stuck = true;

                        if (departmentsMode === 'fixed')
                        {
                            departments.setMode('normal');
                        }
                    }
                } else
                {
                    if (stuck)
                    {
                        nav.removeClass('nav-panel--stuck');
                        stuck = false;

                        if (departmentsMode === 'fixed')
                        {
                            departments.setMode('fixed');
                        }
                    }
                }
            }, passiveSupported ? { passive: true } : false);
        }
    });


    /*
    // block slideshow
    */
    $(function ()
    {
        $('.block-slideshow .owl-carousel').owlCarousel({
            items: 1,
            nav: false,
            dots: true,
            loop: true
        });
    });


    /*
    // block brands carousel
    */
    $(function ()
    {
        $('.block-brands__slider .owl-carousel').owlCarousel({
            nav: false,
            dots: false,
            loop: true,
            responsive: {
                1200: { items: 6 },
                992: { items: 5 },
                768: { items: 4 },
                576: { items: 3 },
                0: { items: 2 }
            }
        });
    });


    /*
    // block posts carousel
    */
    $(function ()
    {
        $('.block-posts').each(function ()
        {
            const layout = $(this).data('layout');
            const options = {
                margin: 30,
                nav: false,
                dots: false,
                loop: true
            };
            const layoutOptions = {
                'grid-nl': {

                    responsive: {
                        992: { items: 3 },
                        768: { items: 2 },
                        0: { items: 1 }
                    }
                },
                'list-sm': {
                    responsive: {
                        992: { items: 2 },
                        0: { items: 1 }
                    }
                }
            };
            const owl = $('.block-posts__slider .owl-carousel');

            owl.owlCarousel($.extend({}, options, layoutOptions[layout]));

            $(this).find('.block-header__arrow--left').on('click', function ()
            {
                owl.trigger('prev.owl.carousel', [500]);
            });
            $(this).find('.block-header__arrow--right').on('click', function ()
            {
                owl.trigger('next.owl.carousel', [500]);
            });
        });
    });


    /*
    // teammates
    */
    $(function ()
    {
        $('.teammates .owl-carousel').owlCarousel({
            nav: false,
            dots: true,
            responsive: {
                768: { items: 3, margin: 32 },
                380: { items: 2, margin: 24 },
                0: { items: 1 }
            }
        });
    });

    /*
    // quickview
    */
    const quickview = {
        cancelPreviousModal: function () { },
        clickHandler: function ()
        {
            const modal = $('#quickview-modal');
            const button = $(this);
            const doubleClick = button.is('.product-card__quickview--preload');

            quickview.cancelPreviousModal();

            if (doubleClick)
            {
                return;
            }

            button.addClass('product-card__quickview--preload');

            let xhr = null;
            // timeout ONLY_FOR_DEMO!
            const timeout = setTimeout(function ()
            {
                xhr = $.ajax({
                    url: 'quickview.html',
                    success: function (data)
                    {
                        quickview.cancelPreviousModal = function () { };
                        button.removeClass('product-card__quickview--preload');

                        modal.find('.modal-content').html(data);
                        modal.find('.quickview__close').on('click', function ()
                        {
                            modal.modal('hide');
                        });
                        modal.modal('show');
                    }
                });
            }, 1000);

            quickview.cancelPreviousModal = function ()
            {
                button.removeClass('product-card__quickview--preload');

                if (xhr)
                {
                    xhr.abort();
                }

                // timeout ONLY_FOR_DEMO!
                clearTimeout(timeout);
            };
        }
    };

    $(function ()
    {
        const modal = $('#quickview-modal');

        modal.on('shown.bs.modal', function ()
        {
            modal.find('.product').each(function ()
            {
                const gallery = $(this).find('.product-gallery');

                if (gallery.length > 0)
                {
                    initProductGallery(gallery[0], $(this).data('layout'));
                }
            });

            $('.input-number', modal).customNumber();
        });

        $('.product-card__quickview').on('click', function ()
        {
            quickview.clickHandler.apply(this, arguments);
        });
    });


    /*
    // products carousel
    */
    $(function ()
    {
        $('.block-products-carousel').each(function ()
        {
            const layout = $(this).data('layout');
            const options = {
                items: 4,
                margin: 14,
                nav: false,
                dots: false,
                loop: true,
                stagePadding: 1
            };
            const layoutOptions = {
                'grid-4': {
                    responsive: {
                        1200: { items: 4, margin: 14 },
                        992: { items: 4, margin: 10 },
                        768: { items: 3, margin: 10 },
                        576: { items: 2, margin: 10 },
                        475: { items: 2, margin: 10 },
                        0: { items: 1 }
                    }
                },
                'grid-4-sm': {
                    responsive: {
                        1200: { items: 4, margin: 14 },
                        992: { items: 3, margin: 10 },
                        768: { items: 3, margin: 10 },
                        576: { items: 2, margin: 10 },
                        475: { items: 2, margin: 10 },
                        0: { items: 1 }
                    }
                },
                'grid-5': {
                    responsive: {
                        1200: { items: 5, margin: 12 },
                        992: { items: 4, margin: 10 },
                        768: { items: 3, margin: 10 },
                        576: { items: 2, margin: 10 },
                        475: { items: 2, margin: 10 },
                        0: { items: 1 }
                    }
                },
                'horizontal': {
                    items: 3,
                    responsive: {
                        1200: { items: 3, margin: 14 },
                        992: { items: 3, margin: 10 },
                        768: { items: 2, margin: 10 },
                        576: { items: 1 },
                        475: { items: 1 },
                        0: { items: 1 }
                    }
                },
            };
            const owl = $('.owl-carousel', this);
            let cancelPreviousTabChange = function () { };

            owl.owlCarousel($.extend({}, options, layoutOptions[layout]));

            $(this).find('.block-header__group').on('click', function (event)
            {
                const block = $(this).closest('.block-products-carousel');

                event.preventDefault();

                if ($(this).is('.block-header__group--active'))
                {
                    return;
                }

                cancelPreviousTabChange();

                block.addClass('block-products-carousel--loading');
                $(this).closest('.block-header__groups-list').find('.block-header__group--active').removeClass('block-header__group--active');
                $(this).addClass('block-header__group--active');

                // timeout ONLY_FOR_DEMO! you can replace it with an ajax request
                let timer;
                timer = setTimeout(function ()
                {
                    let items = block.find('.owl-carousel .owl-item:not(".cloned") .block-products-carousel__column');

                    /*** this is ONLY_FOR_DEMO! / start */
                    /**/ const itemsArray = items.get();
                    /**/ const newItemsArray = [];
                    /**/
                    /**/ while (itemsArray.length > 0)
                    {
                    /**/     const randomIndex = Math.floor(Math.random() * itemsArray.length);
                    /**/     const randomItem = itemsArray.splice(randomIndex, 1)[0];
                    /**/
                    /**/     newItemsArray.push(randomItem);
                        /**/
                    }
                    /**/ items = $(newItemsArray);
                    /*** this is ONLY_FOR_DEMO! / end */

                    block.find('.owl-carousel')
                        .trigger('replace.owl.carousel', [items])
                        .trigger('refresh.owl.carousel')
                        .trigger('to.owl.carousel', [0, 0]);

                    $('.product-card__quickview', block).on('click', function ()
                    {
                        quickview.clickHandler.apply(this, arguments);
                    });

                    block.removeClass('block-products-carousel--loading');
                }, 1000);
                cancelPreviousTabChange = function ()
                {
                    // timeout ONLY_FOR_DEMO!
                    clearTimeout(timer);
                    cancelPreviousTabChange = function () { };
                };
            });

            $(this).find('.block-header__arrow--left').on('click', function ()
            {
                owl.trigger('prev.owl.carousel', [500]);
            });
            $(this).find('.block-header__arrow--right').on('click', function ()
            {
                owl.trigger('next.owl.carousel', [500]);
            });
        });
    });


    /*
    // product gallery
    */
    const initProductGallery = function (element, layout)
    {
        layout = layout !== undefined ? layout : 'standard';

        const options = {
            dots: false,
            margin: 10
        };
        const layoutOptions = {
            standard: {
                responsive: {
                    1200: { items: 5 },
                    992: { items: 4 },
                    768: { items: 3 },
                    480: { items: 5 },
                    380: { items: 4 },
                    0: { items: 3 }
                }
            },
            sidebar: {
                responsive: {
                    768: { items: 4 },
                    480: { items: 5 },
                    380: { items: 4 },
                    0: { items: 3 }
                }
            },
            columnar: {
                responsive: {
                    768: { items: 4 },
                    480: { items: 5 },
                    380: { items: 4 },
                    0: { items: 3 }
                }
            },
            quickview: {
                responsive: {
                    1200: { items: 5 },
                    768: { items: 4 },
                    480: { items: 5 },
                    380: { items: 4 },
                    0: { items: 3 }
                }
            }
        };

        const gallery = $(element);

        const image = gallery.find('.product-gallery__featured .owl-carousel');
        const carousel = gallery.find('.product-gallery__carousel .owl-carousel');

        image
            .owlCarousel({ items: 1, dots: false })
            .on('changed.owl.carousel', syncPosition);

        carousel
            .on('initialized.owl.carousel', function ()
            {
                carousel.find('.product-gallery__carousel-item').eq(0).addClass('product-gallery__carousel-item--active');
            })
            .owlCarousel($.extend({}, options, layoutOptions[layout]));

        carousel.on('click', '.owl-item', function (e)
        {
            e.preventDefault();

            image.data('owl.carousel').to($(this).index(), 300, true);
        });

        function syncPosition(el)
        {
            let current = el.item.index;

            carousel
                .find('.product-gallery__carousel-item')
                .removeClass('product-gallery__carousel-item--active')
                .eq(current)
                .addClass('product-gallery__carousel-item--active');
            const onscreen = carousel.find('.owl-item.active').length - 1;
            const start = carousel.find('.owl-item.active').first().index();
            const end = carousel.find('.owl-item.active').last().index();

            if (current > end)
            {
                carousel.data('owl.carousel').to(current, 100, true);
            }
            if (current < start)
            {
                carousel.data('owl.carousel').to(current - onscreen, 100, true);
            }
        }
    };

    $(function ()
    {
        $('.product').each(function ()
        {
            const gallery = $(this).find('.product-gallery');

            if (gallery.length > 0)
            {
                initProductGallery(gallery[0], $(this).data('layout'));
            }
        });
    });


    /*
    // Checkout payment methods
    */
    $(function ()
    {
        $('[name="checkout_payment_method"]').on('change', function ()
        {
            const currentItem = $(this).closest('.payment-methods__item');

            $(this).closest('.payment-methods__list').find('.payment-methods__item').each(function (i, element)
            {
                const links = $(element);
                const linksContent = links.find('.payment-methods__item-container');

                if (element !== currentItem[0])
                {
                    const startHeight = linksContent.height();

                    linksContent.css('height', startHeight + 'px');
                    links.removeClass('payment-methods__item--active');

                    linksContent.css('height', '');
                } else
                {
                    const startHeight = linksContent.height();

                    links.addClass('payment-methods__item--active');

                    const endHeight = linksContent.height();

                    linksContent.css('height', startHeight + 'px');
                    linksContent.css('height', endHeight + 'px');
                }
            });
        });

        $('.payment-methods__item-container').on('transitionend', function (event)
        {
            if (event.originalEvent.propertyName === 'height')
            {
                $(this).css('height', '');
            }
        });
    });


    /*
    // collapse
    */
    $(function ()
    {
        $('[data-collapse]').each(function (i, element)
        {
            const collapse = element;
            const openedClass = $(element).data('collapse-opened-class');

            $('[data-collapse-trigger]', collapse).on('click', function ()
            {
                const item = $(this).closest('[data-collapse-item]');
                const content = item.children('[data-collapse-content]');
                const itemParents = item.parents();

                itemParents.slice(0, itemParents.index(collapse) + 1).filter('[data-collapse-item]').css('height', '');

                if (item.is('.' + openedClass))
                {
                    const startHeight = content.height();

                    content.css('height', startHeight + 'px');
                    item.removeClass(openedClass);

                    content.css('height', '');
                } else
                {
                    const startHeight = content.height();

                    item.addClass(openedClass);

                    const endHeight = content.height();

                    content.css('height', startHeight + 'px');
                    content.css('height', endHeight + 'px');
                }
            });

            $('[data-collapse-content]', collapse).on('transitionend', function (event)
            {
                if (event.originalEvent.propertyName === 'height')
                {
                    $(this).css('height', '');
                }
            });
        });
    });


    /*
    // price filter
    */
    $(function ()
    {
        $('.filter-price').each(function (i, element)
        {
            const min = $(element).data('min');
            const max = $(element).data('max');
            const from = $(element).data('from');
            const to = $(element).data('to');
            const slider = element.querySelector('.filter-price__slider');

            noUiSlider.create(slider, {
                start: [from, to],
                connect: true,
                range: {
                    'min': min,
                    'max': max
                }
            });

            const titleValues = [
                $(element).find('.filter-price__min-value')[0],
                $(element).find('.filter-price__max-value')[0]
            ];

            slider.noUiSlider.on('update', function (values, handle)
            {
                titleValues[handle].innerHTML = values[handle];
            });
        });
    });


    /*
    // mobilemenu
    */
    $(function ()
    {
        const body = $('body');
        const mobilemenu = $('.mobilemenu');

        if (mobilemenu.length)
        {
            const open = function ()
            {
                const bodyWidth = body.width();
                body.css('overflow', 'hidden');
                body.css('paddingRight', (body.width() - bodyWidth) + 'px');

                mobilemenu.addClass('mobilemenu--open');
            };
            const close = function ()
            {
                body.css('overflow', 'auto');
                body.css('paddingRight', '');

                mobilemenu.removeClass('mobilemenu--open');
            };


            $('.mobile-header__menu-button').on('click', function ()
            {
                open();
            });
            $('.mobilemenu__backdrop, .mobilemenu__close').on('click', function ()
            {
                close();
            });
        }
    });


    /*
    // tooltips
    */
    $(function ()
    {
        $('[data-toggle="tooltip"]').tooltip({ trigger: 'hover' });
    });


    /*
    // layout switcher
    */
    $(function ()
    {
        $('.layout-switcher__button').on('click', function ()
        {
            const layoutSwitcher = $(this).closest('.layout-switcher');
            const productsView = $(this).closest('.products-view');
            const productsList = productsView.find('.products-list');

            layoutSwitcher.find('.layout-switcher__button').removeClass('layout-switcher__button--active');
            $(this).addClass('layout-switcher__button--active');

            productsList.attr('data-layout', $(this).attr('data-layout'));
            productsList.attr('data-with-features', $(this).attr('data-with-features'));
        });
    });
})(jQuery);



/* =========================================================
 * bootstrap-slider.js v2.0.0
 * http://www.eyecon.ro/bootstrap-slider
 * =========================================================
 * Copyright 2012 Stefan Petre
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

!function( $ ) {

    var Slider = function(element, options) {
        this.element = $(element);
        this.picker = $('<div class="slider">'+
            '<div class="slider-track">'+
            '<div class="slider-selection"></div>'+
            '<div class="slider-handle"></div>'+
            '<div class="slider-handle"></div>'+
            '</div>'+
            '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'+
            '</div>')
            .insertBefore(this.element)
            .append(this.element);
        this.id = this.element.data('slider-id')||options.id;
        if (this.id) {
            this.picker[0].id = this.id;
        }

        if (typeof Modernizr !== 'undefined' && Modernizr.touch) {
            this.touchCapable = true;
        }

        var tooltip = this.element.data('slider-tooltip')||options.tooltip;

        this.tooltip = this.picker.find('.tooltip');
        this.tooltipInner = this.tooltip.find('div.tooltip-inner');

        this.orientation = this.element.data('slider-orientation')||options.orientation;
        switch(this.orientation) {
            case 'vertical':
                this.picker.addClass('slider-vertical');
                this.stylePos = 'top';
                this.mousePos = 'pageY';
                this.sizePos = 'offsetHeight';
                this.tooltip.addClass('right')[0].style.left = '100%';
                break;
            default:
                this.picker
                    .addClass('slider-horizontal')
                    .css('width', this.element.outerWidth());
                this.orientation = 'horizontal';
                this.stylePos = 'left';
                this.mousePos = 'pageX';
                this.sizePos = 'offsetWidth';
                this.tooltip.addClass('top')[0].style.top = -this.tooltip.outerHeight() - 14 + 'px';
                break;
        }

        this.min = this.element.data('slider-min')||options.min;
        this.max = this.element.data('slider-max')||options.max;
        this.step = this.element.data('slider-step')||options.step;
        this.value = this.element.data('slider-value')||options.value;
        if (this.value[1]) {
            this.range = true;
        }

        this.selection = this.element.data('slider-selection')||options.selection;
        this.selectionEl = this.picker.find('.slider-selection');
        if (this.selection === 'none') {
            this.selectionEl.addClass('hide');
        }
        this.selectionElStyle = this.selectionEl[0].style;


        this.handle1 = this.picker.find('.slider-handle:first');
        this.handle1Stype = this.handle1[0].style;
        this.handle2 = this.picker.find('.slider-handle:last');
        this.handle2Stype = this.handle2[0].style;

        var handle = this.element.data('slider-handle')||options.handle;
        switch(handle) {
            case 'round':
                this.handle1.addClass('round left-round');
                this.handle2.addClass('round');
                break
            case 'triangle':
                this.handle1.addClass('triangle');
                this.handle2.addClass('triangle');
                break
        }

        if (this.range) {
            this.value[0] = Math.max(this.min, Math.min(this.max, this.value[0]));
            this.value[1] = Math.max(this.min, Math.min(this.max, this.value[1]));
        } else {
            this.value = [ Math.max(this.min, Math.min(this.max, this.value))];
            this.handle2.addClass('hide');
            if (this.selection == 'after') {
                this.value[1] = this.max;
            } else {
                this.value[1] = this.min;
            }
        }
        this.diff = this.max - this.min;
        this.percentage = [
            (this.value[0]-this.min)*100/this.diff,
            (this.value[1]-this.min)*100/this.diff,
            this.step*100/this.diff
        ];

        this.offset = this.picker.offset();
        this.size = this.picker[0][this.sizePos];

        this.formater = options.formater;

        this.layout();

        if (this.touchCapable) {
            // Touch: Bind touch events:
            this.picker.on({
                touchstart: $.proxy(this.mousedown, this)
            });
        } else {
            this.picker.on({
                mousedown: $.proxy(this.mousedown, this)
            });
        }

        if (tooltip === 'show') {
            this.picker.on({
                mouseenter: $.proxy(this.showTooltip, this),
                mouseleave: $.proxy(this.hideTooltip, this)
            });
        } else {
            this.tooltip.addClass('hide');
        }
    };

    Slider.prototype = {
        constructor: Slider,

        over: false,
        inDrag: false,

        showTooltip: function(){
            this.tooltip.addClass('in');
            //var left = Math.round(this.percent*this.width);
            //this.tooltip.css('left', left - this.tooltip.outerWidth()/2);
            this.over = true;
        },

        hideTooltip: function(){
            if (this.inDrag === false) {
                this.tooltip.removeClass('in');
            }
            this.over = false;
        },

        layout: function(){
            this.handle1Stype[this.stylePos] = this.percentage[0]+'%';
            this.handle2Stype[this.stylePos] = this.percentage[1]+'%';
            if (this.orientation == 'vertical') {
                this.selectionElStyle.top = Math.min(this.percentage[0], this.percentage[1]) +'%';
                this.selectionElStyle.height = Math.abs(this.percentage[0] - this.percentage[1]) +'%';
            } else {
                this.selectionElStyle.left = Math.min(this.percentage[0], this.percentage[1]) +'%';
                this.selectionElStyle.width = Math.abs(this.percentage[0] - this.percentage[1]) +'%';
            }
            if (this.range) {
                this.tooltipInner.text(
                    this.formater(this.value[0]) +
                    ' : ' +
                    this.formater(this.value[1])
                );
                this.tooltip[0].style[this.stylePos] = this.size * (this.percentage[0] + (this.percentage[1] - this.percentage[0])/2)/100 - (this.orientation === 'vertical' ? this.tooltip.outerHeight()/2 : this.tooltip.outerWidth()/2) +'px';
            } else {
                this.tooltipInner.text(
                    this.formater(this.value[0])
                );
                this.tooltip[0].style[this.stylePos] = this.size * this.percentage[0]/100 - (this.orientation === 'vertical' ? this.tooltip.outerHeight()/2 : this.tooltip.outerWidth()/2) +'px';
            }
        },

        mousedown: function(ev) {

            // Touch: Get the original event:
            if (this.touchCapable && ev.type === 'touchstart') {
                ev = ev.originalEvent;
            }

            this.offset = this.picker.offset();
            this.size = this.picker[0][this.sizePos];

            var percentage = this.getPercentage(ev);

            if (this.range) {
                var diff1 = Math.abs(this.percentage[0] - percentage);
                var diff2 = Math.abs(this.percentage[1] - percentage);
                this.dragged = (diff1 < diff2) ? 0 : 1;
            } else {
                this.dragged = 0;
            }

            this.percentage[this.dragged] = percentage;
            this.layout();

            if (this.touchCapable) {
                // Touch: Bind touch events:
                $(document).on({
                    touchmove: $.proxy(this.mousemove, this),
                    touchend: $.proxy(this.mouseup, this)
                });
            } else {
                $(document).on({
                    mousemove: $.proxy(this.mousemove, this),
                    mouseup: $.proxy(this.mouseup, this)
                });
            }

            this.inDrag = true;
            var val = this.calculateValue();
            this.element.trigger({
                type: 'slideStart',
                value: val
            }).trigger({
                type: 'slide',
                value: val
            });
            return false;
        },

        mousemove: function(ev) {

            // Touch: Get the original event:
            if (this.touchCapable && ev.type === 'touchmove') {
                ev = ev.originalEvent;
            }

            var percentage = this.getPercentage(ev);
            if (this.range) {
                if (this.dragged === 0 && this.percentage[1] < percentage) {
                    this.percentage[0] = this.percentage[1];
                    this.dragged = 1;
                } else if (this.dragged === 1 && this.percentage[0] > percentage) {
                    this.percentage[1] = this.percentage[0];
                    this.dragged = 0;
                }
            }
            this.percentage[this.dragged] = percentage;
            this.layout();
            var val = this.calculateValue();
            this.element
                .trigger({
                    type: 'slide',
                    value: val
                })
                .data('value', val)
                .prop('value', val);
            return false;
        },

        mouseup: function(ev) {
            if (this.touchCapable) {
                // Touch: Bind touch events:
                $(document).off({
                    touchmove: this.mousemove,
                    touchend: this.mouseup
                });
            } else {
                $(document).off({
                    mousemove: this.mousemove,
                    mouseup: this.mouseup
                });
            }

            this.inDrag = false;
            if (this.over == false) {
                this.hideTooltip();
            }
            this.element;
            var val = this.calculateValue();
            this.element
                .trigger({
                    type: 'slideStop',
                    value: val
                })
                .data('value', val)
                .prop('value', val);
            return false;
        },

        calculateValue: function() {
            var val;
            if (this.range) {
                val = [
                    (this.min + Math.round((this.diff * this.percentage[0]/100)/this.step)*this.step),
                    (this.min + Math.round((this.diff * this.percentage[1]/100)/this.step)*this.step)
                ];
                this.value = val;
            } else {
                val = (this.min + Math.round((this.diff * this.percentage[0]/100)/this.step)*this.step);
                this.value = [val, this.value[1]];
            }
            return val;
        },

        getPercentage: function(ev) {
            if (this.touchCapable) {
                ev = ev.touches[0];
            }
            var percentage = (ev[this.mousePos] - this.offset[this.stylePos])*100/this.size;
            percentage = Math.round(percentage/this.percentage[2])*this.percentage[2];
            return Math.max(0, Math.min(100, percentage));
        },

        getValue: function() {
            if (this.range) {
                return this.value;
            }
            return this.value[0];
        },

        setValue: function(val) {
            this.value = val;

            if (this.range) {
                this.value[0] = Math.max(this.min, Math.min(this.max, this.value[0]));
                this.value[1] = Math.max(this.min, Math.min(this.max, this.value[1]));
            } else {
                this.value = [ Math.max(this.min, Math.min(this.max, this.value))];
                this.handle2.addClass('hide');
                if (this.selection == 'after') {
                    this.value[1] = this.max;
                } else {
                    this.value[1] = this.min;
                }
            }
            this.diff = this.max - this.min;
            this.percentage = [
                (this.value[0]-this.min)*100/this.diff,
                (this.value[1]-this.min)*100/this.diff,
                this.step*100/this.diff
            ];
            this.layout();
        }
    };

    $.fn.slider = function ( option, val ) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('slider'),
                options = typeof option === 'object' && option;
            if (!data)  {
                $this.data('slider', (data = new Slider(this, $.extend({}, $.fn.slider.defaults,options))));
            }
            if (typeof option == 'string') {
                data[option](val);
            }
        })
    };

    $.fn.slider.defaults = {
        min: 0,
        max: 10,
        step: 1,
        orientation: 'horizontal',
        value: 5,
        selection: 'before',
        tooltip: 'show',
        handle: 'round',
        formater: function(value) {
            return value;
        }
    };

    $.fn.slider.Constructor = Slider;

}( window.jQuery );



/* =========================================================
 * bootstrap-slider.js v2.0.0
 * http://www.eyecon.ro/bootstrap-slider
 * =========================================================
 * Copyright 2012 Stefan Petre
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

!function( $ ) {

    var Slider = function(element, options) {
        this.element = $(element);
        this.picker = $('<div class="slider">'+
            '<div class="slider-track">'+
            '<div class="slider-selection"></div>'+
            '<div class="slider-handle"></div>'+
            '<div class="slider-handle"></div>'+
            '</div>'+
            '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'+
            '</div>')
            .insertBefore(this.element)
            .append(this.element);
        this.id = this.element.data('slider-id')||options.id;
        if (this.id) {
            this.picker[0].id = this.id;
        }

        if (typeof Modernizr !== 'undefined' && Modernizr.touch) {
            this.touchCapable = true;
        }

        var tooltip = this.element.data('slider-tooltip')||options.tooltip;

        this.tooltip = this.picker.find('.tooltip');
        this.tooltipInner = this.tooltip.find('div.tooltip-inner');

        this.orientation = this.element.data('slider-orientation')||options.orientation;
        switch(this.orientation) {
            case 'vertical':
                this.picker.addClass('slider-vertical');
                this.stylePos = 'top';
                this.mousePos = 'pageY';
                this.sizePos = 'offsetHeight';
                this.tooltip.addClass('right')[0].style.left = '100%';
                break;
            default:
                this.picker
                    .addClass('slider-horizontal')
                    .css('width', this.element.outerWidth());
                this.orientation = 'horizontal';
                this.stylePos = 'left';
                this.mousePos = 'pageX';
                this.sizePos = 'offsetWidth';
                this.tooltip.addClass('top')[0].style.top = -this.tooltip.outerHeight() - 14 + 'px';
                break;
        }

        this.min = this.element.data('slider-min')||options.min;
        this.max = this.element.data('slider-max')||options.max;
        this.step = this.element.data('slider-step')||options.step;
        this.value = this.element.data('slider-value')||options.value;
        if (this.value[1]) {
            this.range = true;
        }

        this.selection = this.element.data('slider-selection')||options.selection;
        this.selectionEl = this.picker.find('.slider-selection');
        if (this.selection === 'none') {
            this.selectionEl.addClass('hide');
        }
        this.selectionElStyle = this.selectionEl[0].style;


        this.handle1 = this.picker.find('.slider-handle:first');
        this.handle1Stype = this.handle1[0].style;
        this.handle2 = this.picker.find('.slider-handle:last');
        this.handle2Stype = this.handle2[0].style;

        var handle = this.element.data('slider-handle')||options.handle;
        switch(handle) {
            case 'round':
                this.handle1.addClass('round left-round');
                this.handle2.addClass('round');
                break
            case 'triangle':
                this.handle1.addClass('triangle');
                this.handle2.addClass('triangle');
                break
        }

        if (this.range) {
            this.value[0] = Math.max(this.min, Math.min(this.max, this.value[0]));
            this.value[1] = Math.max(this.min, Math.min(this.max, this.value[1]));
        } else {
            this.value = [ Math.max(this.min, Math.min(this.max, this.value))];
            this.handle2.addClass('hide');
            if (this.selection == 'after') {
                this.value[1] = this.max;
            } else {
                this.value[1] = this.min;
            }
        }
        this.diff = this.max - this.min;
        this.percentage = [
            (this.value[0]-this.min)*100/this.diff,
            (this.value[1]-this.min)*100/this.diff,
            this.step*100/this.diff
        ];

        this.offset = this.picker.offset();
        this.size = this.picker[0][this.sizePos];

        this.formater = options.formater;

        this.layout();

        if (this.touchCapable) {
            // Touch: Bind touch events:
            this.picker.on({
                touchstart: $.proxy(this.mousedown, this)
            });
        } else {
            this.picker.on({
                mousedown: $.proxy(this.mousedown, this)
            });
        }

        if (tooltip === 'show') {
            this.picker.on({
                mouseenter: $.proxy(this.showTooltip, this),
                mouseleave: $.proxy(this.hideTooltip, this)
            });
        } else {
            this.tooltip.addClass('hide');
        }
    };

    Slider.prototype = {
        constructor: Slider,

        over: false,
        inDrag: false,

        showTooltip: function(){
            this.tooltip.addClass('in');
            //var left = Math.round(this.percent*this.width);
            //this.tooltip.css('left', left - this.tooltip.outerWidth()/2);
            this.over = true;
        },

        hideTooltip: function(){
            if (this.inDrag === false) {
                this.tooltip.removeClass('in');
            }
            this.over = false;
        },

        layout: function(){
            this.handle1Stype[this.stylePos] = this.percentage[0]+'%';
            this.handle2Stype[this.stylePos] = this.percentage[1]+'%';
            if (this.orientation == 'vertical') {
                this.selectionElStyle.top = Math.min(this.percentage[0], this.percentage[1]) +'%';
                this.selectionElStyle.height = Math.abs(this.percentage[0] - this.percentage[1]) +'%';
            } else {
                this.selectionElStyle.left = Math.min(this.percentage[0], this.percentage[1]) +'%';
                this.selectionElStyle.width = Math.abs(this.percentage[0] - this.percentage[1]) +'%';
            }
            if (this.range) {
                this.tooltipInner.text(
                    this.formater(this.value[0]) +
                    ' : ' +
                    this.formater(this.value[1])
                );
                this.tooltip[0].style[this.stylePos] = this.size * (this.percentage[0] + (this.percentage[1] - this.percentage[0])/2)/100 - (this.orientation === 'vertical' ? this.tooltip.outerHeight()/2 : this.tooltip.outerWidth()/2) +'px';
            } else {
                this.tooltipInner.text(
                    this.formater(this.value[0])
                );
                this.tooltip[0].style[this.stylePos] = this.size * this.percentage[0]/100 - (this.orientation === 'vertical' ? this.tooltip.outerHeight()/2 : this.tooltip.outerWidth()/2) +'px';
            }
        },

        mousedown: function(ev) {

            // Touch: Get the original event:
            if (this.touchCapable && ev.type === 'touchstart') {
                ev = ev.originalEvent;
            }

            this.offset = this.picker.offset();
            this.size = this.picker[0][this.sizePos];

            var percentage = this.getPercentage(ev);

            if (this.range) {
                var diff1 = Math.abs(this.percentage[0] - percentage);
                var diff2 = Math.abs(this.percentage[1] - percentage);
                this.dragged = (diff1 < diff2) ? 0 : 1;
            } else {
                this.dragged = 0;
            }

            this.percentage[this.dragged] = percentage;
            this.layout();

            if (this.touchCapable) {
                // Touch: Bind touch events:
                $(document).on({
                    touchmove: $.proxy(this.mousemove, this),
                    touchend: $.proxy(this.mouseup, this)
                });
            } else {
                $(document).on({
                    mousemove: $.proxy(this.mousemove, this),
                    mouseup: $.proxy(this.mouseup, this)
                });
            }

            this.inDrag = true;
            var val = this.calculateValue();
            this.element.trigger({
                type: 'slideStart',
                value: val
            }).trigger({
                type: 'slide',
                value: val
            });
            return false;
        },

        mousemove: function(ev) {

            // Touch: Get the original event:
            if (this.touchCapable && ev.type === 'touchmove') {
                ev = ev.originalEvent;
            }

            var percentage = this.getPercentage(ev);
            if (this.range) {
                if (this.dragged === 0 && this.percentage[1] < percentage) {
                    this.percentage[0] = this.percentage[1];
                    this.dragged = 1;
                } else if (this.dragged === 1 && this.percentage[0] > percentage) {
                    this.percentage[1] = this.percentage[0];
                    this.dragged = 0;
                }
            }
            this.percentage[this.dragged] = percentage;
            this.layout();
            var val = this.calculateValue();
            this.element
                .trigger({
                    type: 'slide',
                    value: val
                })
                .data('value', val)
                .prop('value', val);
            return false;
        },

        mouseup: function(ev) {
            if (this.touchCapable) {
                // Touch: Bind touch events:
                $(document).off({
                    touchmove: this.mousemove,
                    touchend: this.mouseup
                });
            } else {
                $(document).off({
                    mousemove: this.mousemove,
                    mouseup: this.mouseup
                });
            }

            this.inDrag = false;
            if (this.over == false) {
                this.hideTooltip();
            }
            this.element;
            var val = this.calculateValue();
            this.element
                .trigger({
                    type: 'slideStop',
                    value: val
                })
                .data('value', val)
                .prop('value', val);
            return false;
        },

        calculateValue: function() {
            var val;
            if (this.range) {
                val = [
                    (this.min + Math.round((this.diff * this.percentage[0]/100)/this.step)*this.step),
                    (this.min + Math.round((this.diff * this.percentage[1]/100)/this.step)*this.step)
                ];
                this.value = val;
            } else {
                val = (this.min + Math.round((this.diff * this.percentage[0]/100)/this.step)*this.step);
                this.value = [val, this.value[1]];
            }
            return val;
        },

        getPercentage: function(ev) {
            if (this.touchCapable) {
                ev = ev.touches[0];
            }
            var percentage = (ev[this.mousePos] - this.offset[this.stylePos])*100/this.size;
            percentage = Math.round(percentage/this.percentage[2])*this.percentage[2];
            return Math.max(0, Math.min(100, percentage));
        },

        getValue: function() {
            if (this.range) {
                return this.value;
            }
            return this.value[0];
        },

        setValue: function(val) {
            this.value = val;

            if (this.range) {
                this.value[0] = Math.max(this.min, Math.min(this.max, this.value[0]));
                this.value[1] = Math.max(this.min, Math.min(this.max, this.value[1]));
            } else {
                this.value = [ Math.max(this.min, Math.min(this.max, this.value))];
                this.handle2.addClass('hide');
                if (this.selection == 'after') {
                    this.value[1] = this.max;
                } else {
                    this.value[1] = this.min;
                }
            }
            this.diff = this.max - this.min;
            this.percentage = [
                (this.value[0]-this.min)*100/this.diff,
                (this.value[1]-this.min)*100/this.diff,
                this.step*100/this.diff
            ];
            this.layout();
        }
    };

    $.fn.slider = function ( option, val ) {
        return this.each(function () {
            var $this = $(this),
                data = $this.data('slider'),
                options = typeof option === 'object' && option;
            if (!data)  {
                $this.data('slider', (data = new Slider(this, $.extend({}, $.fn.slider.defaults,options))));
            }
            if (typeof option == 'string') {
                data[option](val);
            }
        })
    };

    $.fn.slider.defaults = {
        min: 0,
        max: 10,
        step: 1,
        orientation: 'horizontal',
        value: 5,
        selection: 'before',
        tooltip: 'show',
        handle: 'round',
        formater: function(value) {
            return value;
        }
    };

    $.fn.slider.Constructor = Slider;

}( window.jQuery );


/*price range*/

if ($.fn.slider) {
    $('#sl2').slider();
}

var RGBChange = function () {
    $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
};

/*scroll to top*/

$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });
});
